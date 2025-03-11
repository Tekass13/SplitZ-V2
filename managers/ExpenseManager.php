<?php

class ExpenseManager {
    public function createExpense($amount, $description, $groupId) {
        return new Expense($amount, $description, $groupId);
    }

    public function getExpenseById($id) {
        // Logique pour récupérer une dépense par son ID
    }

    public function updateExpense($expense, $amount, $description) {
        $expense->setAmount($amount);
        $expense->setDescription($description);
        return $expense;
    }

    public function deleteExpense($expense) {
        // Logique pour supprimer une dépense
    }
}
?>