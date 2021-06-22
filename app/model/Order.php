<?php
    # Requires
    namespace App\model;

    # Class (object) Order
    final class Order {
        # Object Variables
        private int $id;
        private string $piece;
        private string $reference;
        private string $date_demande;
        private string $sdi_compas;
        private string $old_fan;
        private string $ca;
        private int $quantity;
        private string $mrt_name;
        private string $client_name;

        # Object Functions
        public function __construct($id, $piece, $reference, $date_demande, $sdi_compas, $old_fan, $ca, $quantity, $mrt_name, $client_name) {
            $this->id = $id;
            $this->piece = $piece;
            $this->reference = $reference;
            $this->date_demande = $date_demande;
            $this->sdi_compas = $sdi_compas;
            $this->old_fan = $old_fan;
            $this->ca = $ca;
            $this->quantity = $quantity;
            $this->mrt_name = $mrt_name;
            $this->client_name = $client_name;
        }

        public function getID() : int {
            return $this->id;
        }

        public function getPiece() : string {
            return $this->piece;
        }

        public function getReference() : string {
            return $this->reference;
        }

        public function getDateDemande() : string {
            return $this->date_demande;
        }

        public function getSDI_Compas() : string {
            return $this->sdi_compas;
        }

        public function getOldFan() : string {
            return $this->old_fan;
        }

        public function getCA() : string {
            return $this->ca;
        }

        public function getQuantity() : int {
            return $this->quantity;
        }

        public function getMRTName() : string {
            return $this->mrt_name;
        }

        public function getClientName() : string {
            return $this->client_name; 
        }
    }
?>