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
        case 'user_delete':
            UserController::getInstance('')->userCheckDelete($_GET['emb']);
            break;

        case 'users_create':
            UserController::getInstance('')->setRenderTo('users_create');
            break;
        
        case 'users_global':
            if(empty($_GET['searchInfos'])) {
                UserController::getInstance('')->setRenderTo('users_global');
            } else {
                UserController::getInstance($_GET['searchInfos'])->setRenderTo('users_global');
            }

            if(empty($_GET['emb'])) {
                UserController::getInstance('')->setRenderTo('users_global');
            } else {
                UserController::getInstance($_GET['emb'])->setRenderTo('users_global');
            }
            break;

        # TBT Section
        case 'tbt':
            TbtController::getInstance()->setRenderTo('tbt');
            break;

        # DECT Section
        case 'dect':
            DectController::getInstance()->setRenderTo('dect');
            break;
        
        # Default page if the action is not valid
        default:
            IndexController::getInstance()->setRenderTo('index');
            break;
    } 
?>