<?php
    # Requires
    namespace App\controller;
    use App\model\LoanTbtAccess;
    use App\model\OrderGiverAccess;
    use App\model\ProviderAccess;
    use App\model\TbtAccess;

# Class 'TbtController'
    class TbtController {
        # Class Variables
        private static ?object $_instance = null;
        private string $currentPage;
        private ?array $loanedTbt;
        private array $orderGivers;
        private array $providers;

        # Class Functions
        private function __construct() {
            # Set-up array
            $this->everyTbt = TbtAccess::getAll(); 
            $this->loanedTbt = LoanTbtAccess::getAll();
            $this->orderGivers = OrderGiverAccess::getAll();
            $this->providers = ProviderAccess::getAll();

            # Execute useful func
            $this->tbtCreationCheck();
            $this->tbtModifCheck();
        }
        
        public function tbtCreationCheck() : void {
            if(isset($_POST['local_TBT__add']) && isset($_POST['company_TBT__add']) && isset($_POST['orderGiver_TBT__add']) && isset($_POST['desc_TBT__add']) && isset($_POST['date_TBT__add'])) {
                # Variables
                $local = strtoupper($_POST['local_TBT__add']);
                $company = $_POST['company_TBT__add'];
                $contact = '';
                $orderGiver = $_POST['orderGiver_TBT__add'];
                $description = $_POST['desc_TBT__add'];
                $today_date = date('Y-m-d');
                $prev_date = $_POST['date_TBT__add'];
                if(isset($_POST['contact_TBT__add'])) { $contact = $_POST['contact_TBT__add']; }

                # Create the infos table
                $infos_table = array(
                    'localTBT' => $local,
                    'company' => $company,
                    'contact' => $contact,
                    'orderGiver' => $orderGiver,
                    'description' => $description,
                    'todayDate' => $today_date,
                    'prevDate' => $prev_date,
                    'returnDate' => ''
                );

                # Use the LoanTbtAccess add funtion
                LoanTbtAccess::addLoan($infos_table);
            }
        }

        public function tbtModifCheck() : void {
            if(isset($_POST['datePrev_TBT__modif'])) {
                $date = $_POST['datePrev_TBT__modif'];
                $id = $_GET['loan_id'];

                LoanTbtAccess::changePrevDate($date, $id);

                header('Location: ./?action=tbt_global');
            }
        }

        public function restituteKey($string) : void {
            LoanTbtAccess::restituteKey($string);

            header('Location: ./?action=tbt_global');
        }

        public function getTbtByID($string) : object {
            $obj = LoanTbtAccess::getByID($string);
          
            return $obj;
        }

        public static function getInstance() : object {
            if(is_null(self::$_instance)) {
                self::$_instance = new TbtController;
            }

            return self::$_instance;
        }

        public function setRenderTo($view) : void {
            $this->currentPage = $view;
            include_once('app/view/header.php');
            include_once('app/view/tbt/sidebar.php');
            include_once('app/view/tbt/' . $view . '.php');
            include_once('app/view/footer.php');
        }
    }
?>