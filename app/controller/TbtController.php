<?php
    # Requires
    namespace App\controller;

    # Class 'TbtController'
    class TbtController {
        # Class Variables
        private static ?object $_instance = null;
        private string $currentPage;

        # Class Functions
        private function __construct() {}
        
        public static function getInstance() : object {
            if(is_null(self::$_instance)) {
                self::$_instance = new TbtController;
            }

            return self::$_instance;
        }

        public function setRenderTo($view) : void {
            $this->currentPage = $view;
            include_once('app/view/header.php');
            include_once('app/view/' . $view . '.php');
            include_once('app/view/footer.php');
        }
    }
?>