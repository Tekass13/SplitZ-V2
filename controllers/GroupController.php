<?php

class GroupController extends AbstractController {
    private GroupManager $gm;
    private UserManager $um;

    public function __construct() {
        parent::__construct();
        $this->gm = new GroupManager();
        $this->um = new UserManager();
    }

    public function listGroups(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $groups = $this->gm->getGroupsByUserId($userId);

        $this->render("groups", [
            'groups' => $groups
        ]);
    }

    public function getGroupDetails(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $groupId = $_GET['id'] ?? null;
        if (!$groupId) {
            header('Location: index.php?route=groups');
            exit;
        }

        $group = $this->gm->getGroupById($groupId);
        $members = $this->gm->getGroupMembers($groupId);
        $expenses = $this->gm->getGroupExpenses($groupId);
        $balances = $this->gm->calculateBalances($groupId);

        $this->render("group-details", [
            'group' => $group,
            'members' => $members,
            'expenses' => $expenses,
            'balances' => $balances
        ]);
    }

    public function showAddGroupForm(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $contacts = $this->um->getUserContacts($_SESSION['user_id']);

        $this->render("add-group", [
            'contacts' => $contacts
        ]);
    }

    public function createGroup(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $name = $_POST['group-name'] ?? '';
        if (empty($name)) {
            $this->render("add-group", [
                'error' => 'Le nom du groupe est requis'
            ]);
            return;
        }

        $members = $_POST['members'] ?? [];
        // Ajouter l'utilisateur actuel aux membres
        if (!in_array($_SESSION['user_id'], $members)) {
            $members[] = $_SESSION['user_id'];
        }

        $groupId = $this->gm->createGroup($name, $_SESSION['user_id'], $members);

        header('Location: index.php?route=group-details&id=' . $groupId);
        exit;
    }

    public function joinGroup(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $groupId = $_GET['id'] ?? null;
        if (!$groupId) {
            header('Location: index.php?route=groups');
            exit;
        }

        $this->gm->addMemberToGroup($groupId, $_SESSION['user_id']);

        header('Location: index.php?route=group-details&id=' . $groupId);
        exit;
    }

    public function leaveGroup(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $groupId = $_GET['id'] ?? null;
        if (!$groupId) {
            header('Location: index.php?route=groups');
            exit;
        }

        $this->gm->removeMemberFromGroup($groupId, $_SESSION['user_id']);

        header('Location: index.php?route=groups');
        exit;
    }
}