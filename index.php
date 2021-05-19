<?php
    # Requires
    namespace App\controller;
    include_once 'vendor/autoload.php';

    # Check if action is set, else = default
    if(isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = 'default'; # Action not set, so I set it to "default"
    }

    # Switch $action variable. If the action doesn't exist = default case
    switch($action) {
        # DECT Section
        
        # TBT Section
        
        # Default page if the action is not valid
        default:
            print('default');
            break;
    } 
?>