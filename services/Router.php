<?php

class Router extends AbstractController
{
    private AuthController $authController;
    private GroupController $groupController;
    private ExpenseController $expenseController;
    private UserController $userController;
    private SettlementController $settlementController;

    public function __construct()
    {
        $this->authController = new AuthController();
        $this->groupController = new GroupController();
        $this->expenseController = new ExpenseController();
        $this->userController = new UserController();
        $this->settlementController = new SettlementController();
    }
    
    public function handleRequest(array $get): void
    {
        $routes = [
            // Auth routes
            "login" => fn() => $this->authController->login(),
            "register" => fn() => $this->authController->register(),
            "logout" => fn() => $this->authController->logout(),

            // User routes
            "profile" => fn() => $this->userController->viewProfile(),
            "edit-profile" => fn() => $this->userController->editProfile(),
            
            // Group routes
            "groups" => fn() => $this->groupController->listGroups(),
            "group-details" => fn() => $this->groupController->groupDetails(),
            "create-group" => fn() => $this->groupController->createGroup(),
            "join-group" => fn() => $this->groupController->joinGroup(),
            "leave-group" => fn() => $this->groupController->leaveGroup(),
            
            // Expense routes
            "expenses" => fn() => $this->expenseController->listExpenses(),
            "expense-details" => fn() => $this->expenseController->expenseDetails(),
            "add-expense" => fn() => $this->expenseController->addExpense(),
            "delete-expense" => fn() => $this->expenseController->deleteExpense(),

            // Settlement routes
            "settlements" => fn() => $this->settlementController->listSettlements(),
            "settle-expense" => fn() => $this->settlementController->settleExpense(),
            "delete-settlement" => fn() => $this->settlementController->deleteSettlement(),
        ];
        
        $route = $get["route"] ?? "login";
        
        if (array_key_exists($route, $routes)) {
            $routes[$route]();
        } else {
            http_response_code(404);
            echo "404 - Page Not Found";
        }
    }
}