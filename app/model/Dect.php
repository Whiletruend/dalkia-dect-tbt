<?php
    # Requires
    namespace App\model;

    # Class (object) Dect
    final class Dect {
        # Object Variables
        private string $appel_DECT;
        private string $type_DECT;
        private string $numserie_DECT;
        private ?bool $isDati_DECT;
        private string $embauche_UTILISATEUR;
        private string $ca_UTILISATEUR;

        # Object Functions
        public function __construct($appel_DECT, $type_DECT, $numserie_DECT, $isDati_DECT, $embauche_UTILISATEUR, $ca_UTILISATEUR) {
            $this->appel_DECT = $appel_DECT;
            $this->type_DECT = $type_DECT;
            $this->numserie_DECT = $numserie_DECT;
            $this->isDati_DECT = $isDati_DECT;
            $this->embauche_UTILISATEUR = $embauche_UTILISATEUR;
            $this->ca_UTILISATEUR = $ca_UTILISATEUR;
        }

        public function getAppel() : string {
            return $this->appel_DECT;
        }

        public function getType() : string {
            return $this->type_DECT;
        }

        public function getNumSerie() : string {
            return $this->numserie_DECT;
        }

        public function getIsDati() : bool {
            return $this->isDati_DECT;
        }

        public function getEmbauche() : string {
            return $this->embauche_UTILISATEUR;
        }

        public function getCA() : string {
            return $this->ca_UTILISATEUR;
        }
    }
?>