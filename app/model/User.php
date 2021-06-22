<?php
    # Requires
    namespace App\model;

    # Class (object) User
    final class User {
        # Object Variables
        private string $nom_UTILISATEUR;
        private string $prenom_UTILISATEUR;
        private string $embauche_UTILISATEUR;
        private ?string $ca_UTILISATEUR;

        # Object Functions
        public function __construct($nom_UTILISATEUR, $prenom_UTILISATEUR, $embauche_UTILISATEUR, $ca_UTILISATEUR) {
            $this->nom_UTILISATEUR = $nom_UTILISATEUR;
            $this->prenom_UTILISATEUR = $prenom_UTILISATEUR;
            $this->embauche_UTILISATEUR = $embauche_UTILISATEUR;
            $this->ca_UTILISATEUR = $ca_UTILISATEUR;
        }

        public function getNom() : string {
            return $this->nom_UTILISATEUR;
        }

        public function getPrenom() : string {
            return $this->prenom_UTILISATEUR;
        }

        public function getEmbauche() : string {
            return $this->embauche_UTILISATEUR;
        }

        public function getCA() : ?string {
            return $this->ca_UTILISATEUR;
        }
    }
?>