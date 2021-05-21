<?php
    # Requires
    namespace App\controller;
    use App\model\UserModel;
    use App\model\DectModel;

    # Class 'UserController'
    class UserController {
        # Class Variables
        private static ?object $_instance = null;
        private string $currentPage;
        private array $usersList;
        private array $dectList;
        private string $searchInfos;
        private string $msg_type = ''; # The type of the alert (success, danger, warning..)
        private string $msg_text = ''; # The text inside

        # Class Functions
        private function __construct(?string $searchInfos) {
            if(empty($searchInfos))  {
                $this->dectList = array();
                $table = UserModel::customRequest('SELECT * FROM `UTILISATEURS` ORDER BY nom_UTILISATEUR ASC LIMIT 8;');
            } else {
                $this->dectList = array();
                $table = UserModel::customRequest('SELECT * FROM `UTILISATEURS` WHERE nom_UTILISATEUR LIKE "%' . $searchInfos . '%" OR embauche_UTILISATEUR LIKE "%' . $searchInfos . '%" ORDER BY nom_UTILISATEUR ASC;');
               
                if(empty($table)) {
                    $this->msg_type = 'danger';
                    $this->msg_text = "L'utilisateur que vous recherchez ne semble pas exister.";
                }
            }
            
            $this->usersList = $table;

            $this->usersSearch();
        }

        private function usersSearch() : void {
            if(isset($_POST['users_SEARCH'])) {
                header('Location: ?action=users_global&searchInfos=' . $_POST['users_SEARCH']);
            }
        }

        public function getDectByEmbauche(?string $emb) : array {
            $dectList = DectModel::getByEmbauche($emb);

            return $dectList;
        }

        public function isSearching(string $emb) : string {
            $location = './?action=users_global';

            if(!isset($_GET['searchInfos']) || empty($_GET['searchInfos'])) {
                $location .= '&emb=' . $emb;
            } else {
                $searchInfos = $_GET['searchInfos'];
                $location .= '&searchInfos=' . $searchInfos . '&emb=' . $emb;
            }

            return $location;
        }

        public function getUserByEmb($emb) : object {
            if(isset($emb)) {
                $user = UserModel::getByEmbauche($emb);

                return $user;
            }
        }

        public static function getInstance(?string $searchInfos) : object {
            if(is_null(self::$_instance)) {
                self::$_instance = new UserController($searchInfos);
            }

            return self::$_instance;
        }

        public function setRenderTo($view) : void {
            $this->currentPage = $view;
            include_once('app/view/header.php');
            include_once('app/view/users/sidebar.php');
            include_once('app/view/users/' . $view . '.php');
            include_once('app/view/footer.php');
        }
    }
?>