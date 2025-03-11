<?php
class SearchManager extends AbstractManager
{
    public function __construct() {
        parent::__construct();
    }
    
    public function searchContact(string $searchTerm) : array {
        $searchTerm = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');
        
        $query = $this->db->prepare("SELECT * FROM users WHERE username LIKE :search OR email LIKE :search");
        $parameters = [':search' => "%$searchTerm%"];
        $query->execute($parameters);
        
        return $query->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getAllContacts() : array {
        $query = $this->db->prepare("SELECT * FROM users ORDER BY username ASC");
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}