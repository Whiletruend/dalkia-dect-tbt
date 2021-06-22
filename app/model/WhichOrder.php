<?php
    # Requires
    namespace App\model;

    # Class (object) WhichOrder
    final class WhichOrder {
        # Object Variables
        private int $id;
        private int $group;
        private string $type;
        private string $piece;
        private string $reference;

        # Object Functions
        public function __construct($id, $group, $type, $piece, $reference) {
            $this->id = $id;
            $this->group = $group;
            $this->type = $type;
            $this->piece = $piece;
            $this->reference = $reference;
        }

        public function getID() : int {
            return $this->id;
        }

        public function getGroup() : int {
            return $this->group;
        }

        public function getType() : string {
            return $this->type;
        }

        public function getPiece() : string {
            return $this->piece;
        }

        public function getReference() : string {
            return $this->reference;
        }
    }
?>