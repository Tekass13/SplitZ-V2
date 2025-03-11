<?php

class ExpenseController extends AbstractController {
    private ExpenseManager $em;
    private GroupManager $gm;
    private UserManager $um;

    public function __construct() {
        parent::__construct();
        $this->em = new ExpenseManager();
        $this->gm = new GroupManager();
        $this->um = new UserManager();
    }

    public function showAddExpenseForm(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $groupId = $_GET['group_id'] ?? null;
        if (!$groupId) {
            header('Location: index.php?route=groups');
            exit;
        }

        $members = $this->gm->getGroupMembers($groupId);

        $this->render("add-expense", [
            'group_id' => $groupId,
            'members' => $members
        ]);
    }

    public function createExpense(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $groupId = $_POST['group_id'] ?? null;
        $amount = $_POST['amount'] ?? 0;
        $participants = $_POST['participants'] ?? [];
        $payerId = $_SESSION['user_id'];

        if (!$groupId || empty($amount) || empty($participants)) {
            header('Location: index.php?route=add-expense&group_id=' . $groupId);
            exit;
        }

        // Gérer l'upload de reçu si fourni
        $receiptUrl = '';
        if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/receipts/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['receipt']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['receipt']['tmp_name'], $uploadFile)) {
                $receiptUrl = $uploadFile;
            }
        }

        // Créer la dépense
        $expenseId = $this->em->createExpense($groupId, $payerId, $amount, $receiptUrl);

        // Ajouter les participants
        foreach ($participants as $userId => $userAmount) {
            if (!empty($userAmount)) {
                $this->em->addExpenseParticipant($expenseId, $userId, $userAmount);
            }
        }

        // Recalculer les règlements
        $this->em->calculateSettlements($groupId);

        header('Location: index.php?route=group-details&id=' . $groupId);
        exit;
    }

    public function getExpenseDetails(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $expenseId = $_GET['id'] ?? null;
        if (!$expenseId) {
            header('Location: index.php?route=groups');
            exit;
        }

        $expense = $this->em->getExpenseById($expenseId);
        $participants = $this->em->getExpenseParticipants($expenseId);

        $this->render("expense-details", [
            'expense' => $expense,
            'participants' => $participants
        ]);
    }

    public function deleteExpense(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $expenseId = $_GET['id'] ?? null;
        if (!$expenseId) {
            header('Location: index.php?route=groups');
            exit;
        }

        $expense = $this->em->getExpenseById($expenseId);
        
        // Vérifier que l'utilisateur est le créateur de la dépense
        if ($expense->getPayerId() !== $_SESSION['user_id']) {
            header('Location: index.php?route=expense-details&id=' . $expenseId);
            exit;
        }

        $groupId = $expense->getGroupId();
        
        $this->em->deleteExpense($expenseId);
        
        // Recalculer les règlements
        $this->em->calculateSettlements($groupId);

        header('Location: index.php?route=group-details&id=' . $groupId);
        exit;
    }
}