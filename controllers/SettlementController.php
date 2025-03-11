<?php

class SettlementController extends AbstractController {
    private SettlementManager $sm;

    public function __construct() {
        parent::__construct();
        $this->sm = new SettlementManager();
    }

    public function listSettlements(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $settlements = $this->sm->getSettlementsByUserId($userId);

        $this->render("settlements", [
            'settlements' => $settlements
        ]);
    }

    public function createSettlement(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $groupId = $_POST['group_id'] ?? null;
        $receiverId = $_POST['receiver_id'] ?? null;
        $amount = $_POST['amount'] ?? 0;

        if (!$groupId || !$receiverId || empty($amount)) {
            header('Location: index.php?route=group-details&id=' . $groupId);
            exit;
        }

        $this->sm->createSettlement($groupId, $_SESSION['user_id'], $receiverId, $amount);

        header('Location: index.php?route=group-details&id=' . $groupId);
        exit;
    }

    public function markSettled(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $settlementId = $_GET['id'] ?? null;
        if (!$settlementId) {
            header('Location: index.php?route=settlements');
            exit;
        }

        $settlement = $this->sm->getSettlementById($settlementId);
        
        // Vérifier que l'utilisateur est concerné par ce règlement
        if ($settlement->getPayerId() !== $_SESSION['user_id'] && 
            $settlement->getReceiverId() !== $_SESSION['user_id']) {
            header('Location: index.php?route=settlements');
            exit;
        }

        $this->sm->markSettlementAsCompleted($settlementId);

        header('Location: index.php?route=settlements');
        exit;
    }
}