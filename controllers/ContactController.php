<?php

class ContactController extends AbstractController {
    private ContactManager $cm;

    public function __construct()
    {
        parent::__construct();
        $this->cm = new ContactManager();
    }

    public function addContact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? null;
            $identifier = filter_input(INPUT_POST, 'identifier', FILTER_SANITIZE_SPECIAL_CHARS);

            if (!$userId || !$identifier) {
                echo "Données invalides.";
                return;
            }

            if ($this->cm->insertContact($userId, $identifier)) {
                header('Location: index.php?route=list-contact&status=success');
                exit;
            } else {
                echo "Utilisateur introuvable ou erreur lors de l'ajout.";
            }
        } else {
            $this->showContacts();
        }
    }

    public function showContacts() : void {
        if (isset($_SESSION['user'])) {
            $userId = (int) $_SESSION['user'];

            $contacts = $this->cm->getContactsByUserId($userId);

            $this->render("list-contact", ["contacts" => $contacts]);
        } else {
            echo "Vous devez être connecté pour voir vos contacts.";
        }
    }

    public function deleteContact(int $contactId) : void {
        $query = $this->db->prepare("DELETE FROM contacts_list WHERE contact_id = :contact_id");
        $query->execute([':contact_id' => $contactId]);

        header('Location: index.php?route=search-result&status=deleted');
        exit;
    }
}
?>