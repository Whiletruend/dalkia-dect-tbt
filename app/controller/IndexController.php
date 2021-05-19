<?php
    # Requires
    namespace App\controller;

    # Class 'IndexController'
    class IndexController {
        # Class Variable
        private static $_instance = null;
        private $currentPage;

        # Class Functions
        private function __construct() {}
        
        public static function getInstance() {
            if(is_null(self::$_instance)) {
                self::$_instance = new IndexController;
            }

            return self::$_instance;
        }

        public function setRenderTo($view) {
            $this->currentPage = $view;
            include_once('app/view/' . $view);
        }
    }
?>