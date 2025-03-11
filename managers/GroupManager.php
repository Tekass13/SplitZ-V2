<?php

class GroupManager {
    public function createGroup($name, $description) {
        return new Group($name, $description);
    }

    public function getGroupById($id) {
        // Logique pour récupérer un groupe par son ID
    }

    public function updateGroup($group, $name, $description) {
        $group->setName($name);
        $group->setDescription($description);
        return $group;
    }

    public function deleteGroup($group) {
        // Logique pour supprimer un groupe
    }
}
?>