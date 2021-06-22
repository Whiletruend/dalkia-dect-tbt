<?php
    # Requires
    namespace App\model;

    # Class (object) Dect
    final class DectModel {
        # Object Variables
        private int $id;
        private string $modele;

        # Object Functions
        public function __construct($id, $modele) {
            $this->id = $id;
            $this->modele = $modele; 
        }

        public function getID() : string {
            return $this->id;
        }

        public function getModele() : string {
            return $this->modele;
        }
    }
?>