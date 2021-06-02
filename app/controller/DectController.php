<?php
    # Requires
    namespace App\controller;
    use App\model\DectModel;
use App\model\UserModel;

# Class 'DectController'
    class DectController {
        # Class Variables
        private static ?object $_instance = null;
        private string $currentPage;
        private array $dectList;
        private string $searchInfos;
        private string $msg_type = ''; # The type of the alert (success, danger, warning..)
        private string $msg_text = ''; # The text inside

        # Class Functions
        private function __construct(?string $searchInfos) {
            # Showing the 5 firsts users.
            if(empty($searchInfos)) {
                $table = DectModel::customRequest('SELECT * FROM `DECT` ORDER BY appel_DECT ASC LIMIT 5;');
            } else {
                $table = DectModel::customRequest('SELECT * FROM `DECT` ORDER BY appel_DECT ASC LIMIT 5');
                $table = DectModel::customRequest('SELECT * FROM `DECT` WHERE appel_DECT LIKE "%' . $searchInfos . '%" OR numserie_DECT LIKE "%' . $searchInfos . '%" ORDER BY appel_DECT ASC;');
            }
            
            # Set the class table usersList to the $table variable
            $this->dectList = $table;

            # Start functions
            $this->dectSearch();
        }

        private function dectSearch() : void {
            if(isset($_POST['dect_SEARCH'])) {
                header('Location: ?action=dect_global&searchInfos=' . $_POST['dect_SEARCH']);
            }
        }
        
        public static function getInstance(?string $searchInfos) : object {
            if(is_null(self::$_instance)) {
                self::$_instance = new DectController($searchInfos);
            }

            return self::$_instance;
        }

        public function getUserByEmb($emb) {
            if(isset($emb)) {
                $user = DectModel::getByEmbauche('array', $emb);

                return $user;
            }
        }

        public function getDectByNumSerie(string $numserie) : object {
            if(isset($numserie)) {
                $dect = DectModel::getByNumSerie($numserie);

                return $dect;
            }
        }

        public function isSearching(string $emb) : string {
            $location = './?action=dect_global';

            if(!isset($_GET['searchInfos']) || empty($_GET['searchInfos'])) {
                $location .= '&emb=' . $emb;
            } else {
                $searchInfos = $_GET['searchInfos'];
                $location .= '&searchInfos=' . $searchInfos . '&emb=' . $emb;
            }

            return $location;
        }

        public function setRenderTo($view) : void {
            $this->currentPage = $view;
            include_once('app/view/header.php');
            include_once('app/view/dect/sidebar.php');
            include_once('app/view/dect/' . $view . '.php');
            include_once('app/view/footer.php');
        }
    }
?>