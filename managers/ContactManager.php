<?php
class ContactManager extends AbstractManager {

    public function __construct()
    {
        parent::__construct();
    }

    public function insertContact(int $userId, string $identifier): bool
    {
        // Vérifier si l'identifiant correspond à un username ou un email
        $query = $this->db->prepare("SELECT id FROM users WHERE username = :identifier OR email = :identifier");
        $query->execute([':identifier' => $identifier]);
        $contact = $query->fetch(PDO::FETCH_ASSOC);

        if (!$contact) {
            return false; // L'utilisateur recherché n'existe pas
        }

        $contactId = $contact['id'];

        // Vérifier si le contact existe déjà dans la liste de contacts de l'utilisateur
        $query = $this->db->prepare("SELECT 1 FROM contacts_list WHERE user_id = :user_id AND contact_id = :contact_id");
        $query->execute([':user_id' => $userId, ':contact_id' => $contactId]);
        $existingContact = $query->fetch();

        if ($existingContact) {
            return false; // Le contact existe déjà dans la liste
        }

        // Insérer dans contacts_list si l'utilisateur existe et n'est pas déjà dans la liste
        $query = $this->db->prepare("INSERT INTO contacts_list (user_id, contact_id) VALUES (:user_id, :contact_id)");
        return $query->execute([
            ':user_id' => $userId,
            ':contact_id' => $contactId
        ]);
    }

    public function getContactsByUserId(int $userId): array
    {
        $query = $this->db->prepare("
            SELECT users.username
            FROM users
            JOIN contacts_list ON users.id = contacts_list.contact_id
            WHERE contacts_list.user_id = :userId
        ");
        $query->execute([':userId' => $userId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>