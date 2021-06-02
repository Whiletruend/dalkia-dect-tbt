<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'DectModel'
    class DectModel extends Database {
        # Class Functions
        public static function customRequest(string $request) : array {
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

        public static function getByEmbauche(string $returnType, string $string) {
            $request = self::prepare('SELECT * FROM `DECT` WHERE `embauche_UTILISATEUR`=:emb', array(':emb' => $string));
            $table = array();
            
            if(!empty($request)) {
                foreach($request as $rows) {
                    $table[$rows['numserie_DECT']] = new Dect($rows['appel_DECT'], $rows['type_DECT'], $rows['numserie_DECT'], $rows['isDati_DECT'], $rows['embauche_UTILISATEUR'], $rows['ca_UTILISATEUR']);
                }
            }
            
            return $table;
        }

        public static function getByNumSerie(string $string) : object {
            $request = self::prepare('SELECT * FROM `DECT` WHERE `numserie_DECT`=:numserie', array(':numserie' => $string));
            
            if(!empty($request)) {
                return new Dect($request[0]['appel_DECT'], $request[0]['type_DECT'], $request[0]['numserie_DECT'], $request[0]['isDati_DECT'], $request[0]['embauche_UTILISATEUR'], $request[0]['ca_UTILISATEUR']);
            }
        }
    }
?>