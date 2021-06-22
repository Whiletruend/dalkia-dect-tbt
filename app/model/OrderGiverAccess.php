<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'OrderGiverAccess'
    class OrderGiverAccess extends Database {
        # Class Functions
        public static function customRequest($request) : array {
            $query = self::query($request);
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new OrderGiver($rows['id'], $rows['nom_donneur']);
                }
            }

            return $table;
        }

        public static function getAll() : array {
            $query = self::query('SELECT * FROM `TBT_DONNEURS`');
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new OrderGiver($rows['id'], $rows['nom_donneur']);
                }
            }

            return $table;
        }
    }
?>