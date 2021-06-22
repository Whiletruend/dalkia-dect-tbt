<?php
    # Requires
    namespace App\model;

    # Class (object) Dect
    final class Provider {
        # Object Variables
        private int $id;
        private string $nom;

        # Object Functions
        public function __construct($id, $nom) {
            $this->id = $id;
            $this->nom = $nom; 
        }

        public function getID() : string {
            return $this->id;
        }

        public function getNom() : string {
            return $this->nom;
        }
    }
?>