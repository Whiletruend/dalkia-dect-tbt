<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'DectModel'
    class DectModel extends Database {
        # Class Functions
        public static function customRequest($request) : array {
            $query = self::query($request);
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['embauche_UTILISATEUR']] = new Dect($rows['appel_DECT'], $rows['type_DECT'], $rows['numserie_DECT'], $rows['isDati_DECT'], $rows['embauche_UTILISATEUR'], $rows['ca_UTILISATEUR']);
                }
            }

            return $table;
        }

        public static function getAll() : array {
            $query = self::query('SELECT * FROM `DECT`');
            $table = array();
 
            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['embauche_UTILISATEUR']] = new Dect($rows['appel_DECT'], $rows['type_DECT'], $rows['numserie_DECT'], $rows['isDati_DECT'], $rows['embauche_UTILISATEUR'], $rows['ca_UTILISATEUR']);
                }
            }

            return $table;
        }

        public static function getByEmbauche($string) {
            $request = self::prepare('SELECT * FROM `DECT` WHERE `embauche_UTILISATEUR`=:emb', array(':emb' => $string));
            $table = array();

            if(!empty($request)) {
                foreach($request as $rows) {
                    $table[$rows['appel_DECT']] = new Dect($rows['appel_DECT'], $rows['type_DECT'], $rows['numserie_DECT'], $rows['isDati_DECT'], $rows['embauche_UTILISATEUR'], $rows['ca_UTILISATEUR']);
                }
            }

            return $table;
        }
    }
?>