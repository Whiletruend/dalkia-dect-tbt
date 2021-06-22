<?php
    # Requires
    namespace App\model;

    # Class (object) Dect
    final class Tbt {
        # Object Variables
        private string $nom;
        private int $num_cle;

        # Object Functions
        public function __construct($nom, $num_cle) {
            $this->nom = $nom;
            $this->num_cle = $num_cle; 
        }

        public function getNom() : string {
            return $this->nom;
        }

        public function getNumCle() : int {
            return $this->num_cle;
        }
    }
?>