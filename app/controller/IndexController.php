<?php
    # Requires
    namespace App\controller;

    # Class 'IndexController'
    class IndexController {
        # Class Variable
        private static ?object $_instance = null;
        private string $currentPage;

        # Class Functions
        private function __construct() {}
        
        public static function getInstance() : object {
            if(is_null(self::$_instance)) {
                self::$_instance = new IndexController;
            }

            return self::$_instance;
        }

        public function setRenderTo($view) : void {
            $this->currentPage = $view;
            include_once('app/view/header.php');
            include_once('app/view/' . $view . '.php');
        }
    }
?>