<?php
    # Requires
    namespace App\controller;
    use App\model\DectAccess;
    use App\model\DectModelAccess;

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
                $table = DectAccess::customRequest('SELECT * FROM `DECT` ORDER BY appel_DECT ASC LIMIT 5;');
            } else {
                $table = DectAccess::customRequest('SELECT * FROM `DECT` ORDER BY appel_DECT ASC LIMIT 5');
                $table = DectAccess::customRequest('SELECT * FROM `DECT` WHERE appel_DECT LIKE "%' . $searchInfos . '%" OR numserie_DECT LIKE "%' . $searchInfos . '%" ORDER BY appel_DECT ASC;');
            }
            
            # Set the class table usersList to the $table variable
            $this->dectList = $table;

            # Start functions
            $this->dectSearch();

            $this->dectCheckModify();
            $this->dectCheckAdd();
            $this->isGuaranted('RTC154613919');
        }

        private function dectSearch() : void {
            if(isset($_POST['dect_SEARCH'])) {
                header('Location: ?action=dect_global&searchInfos=' . $_POST['dect_SEARCH']);
            }
        }

        private function dectCheckModify() : void {
            if(isset($_POST['appel_DECT__update']) && isset($_POST['type_DECT__update']) && isset($_POST['numserie_DECT__update']) && isset($_POST['isDati_DECT__update'])) {
                // Variables
                $appel_New = strtoupper( $_POST['appel_DECT__update'] );
                $type_New = strtoupper($_POST['type_DECT__update']);
                $numserie_New = strtoupper( $_POST['numserie_DECT__update'] );
                $isDati_New = intval( $_POST['isDati_DECT__update'] );

                $numserie_Old = $_GET['numserie'];
                $appel_Old = DectAccess::getByNumSerie($numserie_Old)->getAppel();
                $embauche = DectAccess::getByNumSerie($numserie_Old)->getEmbauche();
                $ca = DectAccess::getByNumSerie($numserie_Old)->getCA();

                $isDati_Current = null;
                if($isDati_New == 0) { $isDati_Current = NULL; } elseif($isDati_New == 1) { $isDati_Current = 1; } else { $isDati_Current = 0; }
            
                // Setup the 'infosTable'
                $infosTable = array('appelChanged' => false, 'oldAppel' => $appel_Old); 

                // Check if the user changed the 'appel', if yes then the boolean turn to true. Else it stay to false.
                if($appel_New != $appel_Old) { $infosTable['appelChanged'] = true; }
                
                // Modify the user
                DectAccess::modifyDect($appel_New, $type_New, $numserie_New, $isDati_Current, $embauche, $ca, $infosTable);


                // Redirect
                header('Location: ./?action=dect_global&searchInfos=' . $appel_New);
            }
        }
        
        private function dectCheckAdd() : void {
            if(isset($_POST['appel_DECT__add']) && isset($_POST['type_DECT__add']) && isset($_POST['numserie_DECT__add']) && isset($_POST['isDati_DECT__add']) && isset($_POST['embauche_UTILISATEUR_DECT__add']) && isset($_POST['ca_UTILISATEUR_DECT__add'])) {
                // Variables
                $appel = strtoupper($_POST['appel_DECT__add']);
                $type = strtoupper($_POST['type_DECT__add']);
                $numserie = strtoupper($_POST['numserie_DECT__add']);
                $isDati = intval($_POST['isDati_DECT__add']);
                
                $embauche = strtoupper($_POST['embauche_UTILISATEUR_DECT__add']);
                $ca = strtoupper($_POST['ca_UTILISATEUR_DECT__add']);

                // Create the new DECT
                DectAccess::addDect($appel, $type, $numserie, $isDati, $embauche, $ca);
                
                // Redirect
                header('Location: ./?action=dect_global');
            }
        }

        private function getGuarantee($numserie, $type) : string {
            if(strtoupper($type) == 'W') {
                return $numserie[5] . $numserie[6];
            } elseif(strtoupper($type) == 'Y') {
                return $numserie[3] . $numserie[4];
            }
        }

        public function isGuaranted($numserie) : bool {
            // Variables // RTF191902682
            $year = intval($this->getGuarantee($numserie, 'Y'));
            $week = intval($this->getGuarantee($numserie, 'W'));
            $actual_year = intval(date('Y')[2] . date('Y')[3]);
            $actual_week = intval(date('W'));

            // Mathematics variables
            $yearDifference = $actual_year - $year;

            // Mathematics returns
            if($yearDifference < 2) {
                if($week >= $actual_week) {
                    return true;
                }
            } else {
                return false;
            }

            return false;
        }

        public function dectCheckDelete($numserie) : void {
             // delete the user
            DectAccess::deleteDect($numserie);

             // Redirect
            header('Location: ./?action=dect_global');
        }

        public static function getInstance(?string $searchInfos) : object {
            if(is_null(self::$_instance)) {
                self::$_instance = new DectController($searchInfos);
            }

            return self::$_instance;
        }

        public function getUserByEmb($emb) : array {
            if(isset($emb)) {
                $user = DectAccess::getByEmbauche('array', $emb);

                return $user;
            }
        }

        public function getDectByNumSerie(string $numserie) : object {
            if(isset($numserie)) {
                $dect = DectAccess::getByNumSerie($numserie);

                return $dect;
            }
        }

        public function getEveryDectModels() : array {
            $table = DectModelAccess::getAll();
            
            return $table;
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