<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'DectAccess'
    class DectAccess extends Database {
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

        public static function getByEmbauche(string $returnType, string $string) : array {
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

        public static function addDect(string $appel, string $type, string $numserie, int $isDati, string $emb, string $ca) : void {
            $request = self::request('INSERT INTO `DECT` VALUES (:appel, :typedect, :numserie, :isDati, :embauche, :ca)', array(':appel' => $appel, ':typedect' => $type, ':numserie' => $numserie, ':isDati' => $isDati, ':embauche' => $emb, ':ca' => $ca));
        }

        public static function deleteDect(string $string) : void {
            $request = self::request('DELETE FROM `DECT` WHERE numserie_DECT = :numserie', array(':numserie' => $string));
        }

        public static function modifyDect(string $appel, string $type, string $numserie, $isDati, string $emb, string $ca, array $infosTable) : void {
            if($infosTable['appelChanged']) {
                $first_request = self::deleteDect($infosTable['oldAppel']);
                $second_request = self::addDect($appel, $type, $numserie, $isDati, $emb, $ca);
            } else {
                $request = self::request('UPDATE `DECT` SET appel_DECT = :appel, type_DECT = :typedect, numserie_DECT = :numserie, isDati_DECT = :isDati, embauche_UTILISATEUR = :emb, ca_UTILISATEUR = :ca WHERE appel_DECT = :appel', array(':appel' => $appel, ':typedect' => $type, ':numserie' => $numserie, ':isDati' => $isDati, ':emb' => $emb, ':ca' => $ca));
            }
        }
    }
?>