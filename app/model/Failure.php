<?php
    # Requires
    namespace App\model;

    # Class (object) Failure
    final class Failure {
        # Object Variables
        private int $id;
        private int $group;
        private string $type;

        # Object Functions
        public function __construct($id, $group, $type) {
            $this->id = $id;
            $this->group = $group;
            $this->type = $type;
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
    }
?>