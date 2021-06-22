<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'FailureAccess'
    class FailureAccess extends Database {
        # Class Functions
        public static function customRequest(string $request) : array {
            $query = self::query($request);
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new Failure($rows['id'], $rows['groupe'], $rows['type_panne']);
                }
            }

            return $table;
        }

        public static function getAll() : array {
            $query = self::query('SELECT * FROM `DECT_TYPES_PANNES` ORDER BY `type_panne` ASC;');
            $table = array();
            
            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new Failure($rows['id'], $rows['groupe'], $rows['type_panne']);
                }
            }

            return $table;
        }

        public static function getByID($string) : array {
            $request = self::prepare('SELECT * FROM `DECT_TYPES_PANNES` WHERE `id`=:id', array(':id' => $string));
            $table = array();

            if(!empty($request)) {
                foreach($request as $rows) {
                    $table[$rows['id']] = new Failure($rows['id'], $rows['groupe'], $rows['type_panne']);
                }
            }

            return $table;
        }
    }
?>