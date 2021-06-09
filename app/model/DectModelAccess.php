<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'DectModelAccess'
    class DectModelAccess extends Database {
        # Class Functions
        public static function customRequest(string $request) : array {
            $query = self::query($request);
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new DectModel($rows['id'], $rows['modele']);
                }
            }

            return $table;
        }

        public static function getAll() : array {
            $query = self::query('SELECT * FROM `DECT_MODELES` ORDER BY `modele` ASC');
            $table = array();
 
            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new DectModel($rows['id'], $rows['modele']);
                }
            }

            return $table;
        }
    }
?>