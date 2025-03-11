<?php

class SearchController extends AbstractController {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function displaySearchResults() {   
        $searchManager = new SearchManager();
        
        // Sécuriser l'entrée utilisateur
        $searchTerm = filter_input(INPUT_POST, 'search-bar', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

        if (!empty($searchTerm)) {
            $contacts = $searchManager->searchContact($searchTerm);
        } else {
            $contacts = $searchManager->getAllContacts();
        }
        
        $this->render("search-result", ["contacts" => $contacts]);
    }
}
