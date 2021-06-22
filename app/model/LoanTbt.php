<?php
    # Requires
    namespace App\model;

    # Class (object) User
    final class LoanTBT {
        # Object Variables
        private int $id;
        private ?string $localTBT;
        private ?string $fournisseurs;
        private ?string $contact;
        private ?string $donneurOrdre;
        private ?string $description;
        private ?string $dateSort;
        private ?string $datePrev;
        private ?string $dateRet;
        private ?string $intervenant;

        # Object Functions
        public function __construct($id, $localTBT, $fournisseurs, $contact, $donneurOrdre, $description, $dateSort, $datePrev, $dateRet, $intervenant) {
            $this->id = $id;
            $this->localTBT = $localTBT;
            $this->fournisseurs = $fournisseurs;
            $this->contact = $contact;
            $this->donneurOrdre = $donneurOrdre;
            $this->description = $description;
            $this->dateSort = $dateSort;
            $this->datePrev = $datePrev;
            $this->dateRet = $dateRet;
            $this->intervenant = $intervenant;
        }

        public function getID() : int {
            return $this->id;
        }

        public function getLocal() : ?string {
            return $this->localTBT;
        }

        public function getProvider() : ?string {
            return $this->fournisseurs;
        }

        public function getContact() : ?string {
            return $this->contact;
        }

        public function getOrderGiver() : ?string {
            return $this->donneurOrdre;
        }

        public function getDesc() : ?string {
            return $this->description;
        }

        public function getDateSort() : ?string {
            return $this->dateSort;
        }

        public function getDatePrev() : ?string {
            return $this->datePrev;
        }

        public function getDateRet() : ?string {
            return $this->dateRet;
        }

        public function getStakeHolder() : ?string {
            return $this->intervenant;
        }
    }
?>