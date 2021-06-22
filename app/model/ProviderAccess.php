<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'ProviderAccess'
    class ProviderAccess extends Database {
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
            $query = self::query('SELECT * FROM `TBT_PRESTATAIRES`');
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new Provider($rows['id'], $rows['nom_prestataire']);
                }
            }

            return $table;
        }
    }
?>