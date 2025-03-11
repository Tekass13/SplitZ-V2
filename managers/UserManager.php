<?php

class UserManager {
    public function createUser($username, $password, $email) {
        return new User($username, $password, $email);
    }

    public function getUserById($id) {
        // Logique pour récupérer un utilisateur par son ID
    }

    public function updateUser($user, $username, $password, $email) {
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        return $user;
    }

    public function deleteUser($user) {
        // Logique pour supprimer un utilisateur
    }
}
?>