<?php
    # Requires
    namespace App\controller;
    use App\model\DectAccess;
    use App\model\DectModelAccess;
    use App\model\FailureAccess;
    use App\model\OrdersAccess;
    use App\model\TradesAccess;
    use App\model\UserAccess;
    use App\model\WhichOrderAccess;
    use FPDF;

# Class 'DectController'
    class DectController {
        # Class Variables
        private static ?object $_instance = null;
        private string $currentPage;
        private array $dectList;
        private array $ordersList;
        private string $searchInfos;
        private string $msg_type = ''; # The type of the alert (success, danger, warning..)
        private string $msg_text = ''; # The text inside

        # Class Functions
        private function __construct(?string $searchInfos) {
            # Showing the 5 firsts users.
            if(empty($searchInfos)) {
                $dect_table = DectAccess::customRequest('SELECT * FROM `DECT` ORDER BY appel_DECT ASC LIMIT 5;');
            } else {
                $dect_table = DectAccess::customRequest('SELECT * FROM `DECT` WHERE appel_DECT LIKE "%' . $searchInfos . '%" OR numserie_DECT LIKE "%' . $searchInfos . '%" OR embauche_UTILISATEUR LIKE "%' . $searchInfos . '" ORDER BY appel_DECT ASC;');
            }

            # Create the orders list 
            $orders_list = OrdersAccess::getAll();
            
            # Set the class table usersList to the $table variable
            $this->dectList = $dect_table;
            $this->ordersList = $orders_list;

            # Start functions
            $this->dectSearch();

            $this->dectCheckModify();
            $this->dectCheckAdd();
            $this->dectCheckIntervention();
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

        private function dectCheckIntervention() {
            if(isset($_POST['newnumserie_DECT__inter'])) {
                // Syst. Variables
                $hour = $_POST['hour_DECT__inter'];
                $date = $_POST['date_DECT__inter'];

                // DECT Variables
                $numserie = $_GET['numserie']; // Old serial number
                $new_numserie = $_POST['newnumserie_DECT__inter']; // New serial number

                $dect = DectAccess::getByNumSerie($numserie); // DECT Object
                $dect_model = $dect->getType(); // The type of the DECT Object 
                $dect_appel = $dect->getAppel(); // The appel of the DECT Object

                $new_dect_model_id = $_POST['newtype_DECT__inter']; // New DECT model ID
                $new_dect_model = DectModelAccess::getByID($new_dect_model_id)[$new_dect_model_id]->getModele(); // The model of the new DECT

                $old_dect_model_Initials = $this->getInitials($dect_model, 0, 1); // Get 2 first letters of the old model
                $new_dect_model_Initials = $this->getInitials($new_dect_model, 0, 1); // Get 2 first letters of the new model

                // Client Variables
                $client_emb = $_GET['emb']; // Client emb
                $client_infos = UserAccess::getByEmbauche($client_emb); // Client Object
                $client_ca = $client_infos->getCA(); // The CA of the Client Object
                $client_firstname = $client_infos->getPrenom(); // The firstname of the Client Object
                $client_lastname = $client_infos->getNom(); // The lastname of the Client Object

                // Intervention Variables
                $failure_id = $_POST['failure_DECT__inter']; // Failure ID
                $failure = FailureAccess::getByID($failure_id)[$failure_id]; // Failure Object
                $failure_type = $failure->getType(); // Failure type (Text)
                $failure_group = $failure->getGroup(); // Failure group
                $which_order = WhichOrderAccess::getByGroupAndModel($failure_group, $new_dect_model)[0]; // Which order that depend of the failure & the model
                $need_ITC = false; // Is the ITC needed to be created ?

                
                // Check if the model is different from the new one
                if($old_dect_model_Initials != $new_dect_model_Initials) {
                    $which_order = WhichOrderAccess::getByGroupAndModel(3, $new_dect_model)[0];
                } elseif($old_dect_model_Initials == $new_dect_model_Initials) {
                    $which_order = WhichOrderAccess::getByGroupAndModel(2, $new_dect_model)[0];
                }

                // Check if the failure concern accessories
                if($failure_group == 1) {
                    $which_order = WhichOrderAccess::getByGroupAndModel(1, $new_dect_model)[0];
                }

                // Check if the failure group is 2 and if the DECT warranty is expired
                if($failure_group == 2) {
                    if($this->isGuaranted($numserie)) {
                        $need_ITC = true;

                        $this->renderITC_PDF($date, $hour, $dect, $client_infos, $client_emb, $numserie, $dect_model, $new_numserie, $failure_type); // PDF Show Up
                    }
                } 
                
                // Add the intervention to the interventions table
                TradesAccess::addTrade($date, $hour, $numserie, $dect_appel, $dect_model, 'Non', $new_numserie, $new_dect_model, $failure_type, $client_emb, $client_ca);

                // Add the order to the orders tables
                if(!$need_ITC) {
                    OrdersAccess::addOrder($which_order->getPiece(), $which_order->getReference(), $date, $client_ca, $client_lastname . ' ' . $client_firstname . ' - ' . $client_emb . ' (' . $failure_type . ')');
                }
            }
        }

        private function renderITC_PDF($date, $hour, $dect, $client_infos, $client_emb, $numserie, $dect_model, $new_numserie, $failure_type) {
            // PDF Creation
            $pdf = new FPDF('P', 'mm', 'A4');
            $pdf->AddPage();
            
            // PDF Title
            $pdf->SetFont('Arial', 'BU', 18);
            $pdf->Cell(0, 25, "FICHE D'INTERVENTION POUR ENVOI CHEZ ITC", 0, 0, 'C');

            // Main Rect
            $pdf->SetLineWidth(1);
            $pdf->Rect(10, 35, 190, 114, 'D');


            // Date Text
            $pdf->SetFont('Arial', '', 13);
            $pdf->Text(20, 50, 'Date: ' . $date);

            // Hour
            $pdf->Text(85, 50, 'Heure: ' . $hour);

            // N°Appel Text
            $pdf->Text(150, 50, "N" . utf8_decode('°') . "d'appel: " . $dect->getAppel());


            // Client Infos Rect
            $pdf->SetLineWidth(0.5);
            $pdf->Rect(20, 60, 75, 50, 'D');

            $pdf->SetFont('Arial', 'BU', 16);
            $pdf->Text(31, 67, 'Informations Client'); // Informations Client - text

            $pdf->SetFont('Arial', '', 11);
            $pdf->Text(23, 75, 'Nom: ' . $client_infos->getNom()); // Nom
            $pdf->Text(23, 85, 'Pr' . utf8_decode('é') . 'nom: ' . $client_infos->getPrenom()); // Prénom
            $pdf->Text(23, 95, 'N' . utf8_decode('°') . ' Embauche: ' . $client_emb); // Embauche
            $pdf->Text(23, 105, 'C.A: ' . $client_infos->getCA()); // CA


            // DECT Infos Rect
            $pdf->Rect(115, 60, 75, 50, 'D');

            $pdf->SetFont('Arial', 'BU', 16);
            $pdf->Text(126, 67, 'Informations DECT'); // Informations Client - text

            $pdf->SetFont('Arial', '', 11);
            $pdf->Text(118, 75, 'N' . utf8_decode('°') . ' de s' . utf8_decode('é') . 'rie: ' . $numserie); // NumSerie
            $pdf->Text(118, 85, 'Mod' . utf8_decode('è') . 'le: ' . $dect_model); // Modele
            $pdf->Text(118, 95, 'Nouveau N' . utf8_decode('°') . ' de s' . utf8_decode('é') . 'rie: ' . $new_numserie); // New NumSerie
            $pdf->Text(118, 105, 'Nouveau Mod' . utf8_decode('è') . 'le: ' . $new_numserie); // New Modele


            // Interventions Infos Rect
            $pdf->Rect(20, 115, 170, 25, 'D');

            $pdf->SetFont('Arial', 'BU', 13);
            $pdf->Text(77, 120, 'Informations Intervention'); // Informations Client - text

            $pdf->SetFont('Arial', '', 11);
            $pdf->Text(23, 130, 'Type Panne: ' . $failure_type); // CA


            // Render the PDF
            $pdf->Output();
        }

        private function getInitials(string $string, int $from, int $to) : string {
            // Variables
            $final_str = '';

            // Get every letters (initials) from n to n
            for($i = $from; $i <= $to; $i++) {
                $final_str .= $string[$i];
            }

            return $final_str;
        }

        private function getGuarantee($numserie, $type) : string {
            if(strtoupper($type) == 'W') {
                return $numserie[5] . $numserie[6];
            } elseif(strtoupper($type) == 'Y') {
                return $numserie[3] . $numserie[4];
            }
        }

        public function clearOrders() : void {
            OrdersAccess::removeEveryOccurences();
            header('Location: ./?action=dect_ordersList');
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
                if($week > $actual_week) {
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

        public function getEveryDectFailures() : array {
            $table = FailureAccess::getAll();

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