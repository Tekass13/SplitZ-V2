<?php

class Router extends AbstractController
{
    private AuthController $ac;
    // private SearchController $sc;
    // private ContactController $cc;
    // private BudgetController $bc;
    private GroupController $gc;
    private ExpenseController $ec;
    private SettlementController $stc;

    public function __construct()
    {
        $this->ac = new AuthController();
        // $this->sc = new SearchController();
        // $this->cc = new ContactController();
        // $this->bc = new BudgetController();
        $this->gc = new GroupController();
        $this->ec = new ExpenseController();
        $this->stc = new SettlementController();
    }
    
    public function handleRequest(array $get): void
    {
        $routes = [
            // Auth routes
            "login" => fn() => $this->ac->login(),
            "check-login" => fn() => $this->ac->checkLogin(),
            "register" => fn() => $this->ac->register(),
            "check-register" => fn() => $this->ac->checkRegister(),
            "reset-password" => fn() => $this->ac->resetPassword(),
            "check-reset-password" => fn() => $this->ac->checkResetPassword(),
            "logout" => fn() => $this->ac->logout(),
            
            // Main pages
            "home" => fn() => $this->render("home", []),
            "dashboard" => fn() => $this->render("dashboard", []),
            
            // Group routes
            "groups" => fn() => $this->gc->listGroups(),
            "group-details" => fn() => $this->gc->getGroupDetails(),
            "add-group" => fn() => $this->gc->showAddGroupForm(),
            "create-group" => fn() => $this->gc->createGroup(),
            "join-group" => fn() => $this->gc->joinGroup(),
            "leave-group" => fn() => $this->gc->leaveGroup(),
            
            // Expense routes
            "add-expense" => fn() => $this->ec->showAddExpenseForm(),
            "create-expense" => fn() => $this->ec->createExpense(),
            "expense-details" => fn() => $this->ec->getExpenseDetails(),
            "delete-expense" => fn() => $this->ec->deleteExpense(),
            
            // // Budget routes (repris de votre code existant)
            // "budgets" => fn() => $this->render("budget", []),
            // "add-budget" => fn() => $this->render("add-budget", []),
            // "add-categorie" => fn() => $this->render("add-categorie", []),
            
            // Settlement routes
            "settlements" => fn() => $this->stc->listSettlements(),
            "create-settlement" => fn() => $this->stc->createSettlement(),
            "mark-settled" => fn() => $this->stc->markSettled(),
            
            // // Contact routes
            // "list-contact" => fn() => $this->cc->showContacts(),
            // "select-participant" => fn() => $this->cc->showContacts(),
            // "add-participant" => fn() => $this->bc->addParticipant(),
            // "delete-participant" => fn() => $this->bc->deleteParticipant(),
            // "search-contact" => fn() => $this->sc->displaySearchResults(),
            // "add-contact" => fn() => $this->cc->addContact(),
            // "delete-contact" => fn() => $this->cc->deleteContact()
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