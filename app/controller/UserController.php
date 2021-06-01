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
            # Showing the 5 firsts users.
            if(empty($searchInfos))  {
                $this->dectList = array();
                $table = UserModel::customRequest('SELECT * FROM `UTILISATEURS` ORDER BY nom_UTILISATEUR ASC LIMIT 5;');
            } else {
                $this->dectList = array();
                $table = UserModel::customRequest('SELECT * FROM `UTILISATEURS` WHERE nom_UTILISATEUR LIKE "%' . $searchInfos . '%" OR embauche_UTILISATEUR LIKE "%' . $searchInfos . '%" ORDER BY nom_UTILISATEUR ASC;');
               
                if(empty($table)) {
                    $this->msg_type = 'danger';
                    $this->msg_text = "L'utilisateur que vous recherchez ne semble pas exister.";
                }
            }
            
            # Set the class table usersList to the $table variable
            $this->usersList = $table;

            # Starts primal functions
            $this->usersSearch();
            $this->userCheckAdd();
            $this->userCheckModify();
        }

        private function usersSearch() : void {
            if(isset($_POST['users_SEARCH'])) {
                header('Location: ?action=users_global&searchInfos=' . $_POST['users_SEARCH']);
            }
        }

        private function userCheckAdd() : void {
            if(isset($_POST['nom_UTILISATEUR__add']) && isset($_POST['prenom_UTILISATEUR__add']) && isset($_POST['embauche_UTILISATEUR__add']) && isset($_POST['ca_UTILISATEUR__add'])) {
                $nom = strtoupper($_POST['nom_UTILISATEUR__add']);
                $prenom = strtolower($_POST['prenom_UTILISATEUR__add']); # I turn the text into a lowercase
                $prenom = ucfirst($prenom); # And I just capitalize it
                $embauche = strtoupper($_POST['embauche_UTILISATEUR__add']);
                $ca = strtoupper($_POST['ca_UTILISATEUR__add']);

                UserModel::addUser($nom, $prenom, $embauche, $ca);

                // Redirect to global page
                header('Location: ./?action=users_global');
            }
        }

        private function userCheckModify() : void {
            if(isset($_POST['nom_UTILISATEUR__update']) && isset($_POST['prenom_UTILISATEUR__update']) && isset($_POST['embauche_UTILISATEUR__update']) && isset($_POST['ca_UTILISATEUR__update'])) {
                $nom = strtoupper($_POST['nom_UTILISATEUR__update']);
                $prenom = strtolower($_POST['prenom_UTILISATEUR__update']); # I turn the text into a lowercase
                $prenom = ucfirst($prenom); # And I just capitalize it
                $embauche = strtoupper($_POST['embauche_UTILISATEUR__update']);
                $ca = strtoupper($_POST['ca_UTILISATEUR__update']);
                $old_emb = $_GET['emb'];

                // Setup the 'infosTable'
                $infosTable = array('embChanged' => false, 'oldEmb' => $old_emb);

                // Check if the user changed the 'embauche', if yes then the boolean turn to true. Else it stay to false.
                $userObj = UserModel::getByEmbauche($infosTable['oldEmb']);
                if($userObj->getEmbauche() != $embauche) { $infosTable['embChanged'] = true; }

                UserModel::modifyUser($nom, $prenom, $embauche, $ca, $infosTable);

                // Refresh the page
                header('Location: ./?action=users_global&searchInfos=' . $nom);
            }
        }

        public function userCheckDelete($emb) : void {
            // delete the user
            UserModel::deleteUser($emb);

            // Redirect
            header('Location: ./?action=users_global');
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