<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'UserModel'
    class UserModel extends Database {
        # Class Functions
        public static function customRequest($request) : array {
            $query = self::query($request);
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['embauche_UTILISATEUR']] = new User($rows['nom_UTILISATEUR'], $rows['prenom_UTILISATEUR'], $rows['embauche_UTILISATEUR'], $rows['ca_UTILISATEUR']);
                }
            }

            return $table;
        }

        public static function getAll() : array {
            $query = self::query('SELECT * FROM `UTILISATEURS`');
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['embauche_UTILISATEUR']] = new User($rows['nom_UTILISATEUR'], $rows['prenom_UTILISATEUR'], $rows['embauche_UTILISATEUR'], $rows['ca_UTILISATEUR']);
                }
            }

            return $table;
        }

        public static function getByEmbauche($string) : object {
            $request = self::prepare('SELECT * FROM `UTILISATEURS` WHERE `embauche_UTILISATEUR`=:emb', array(':emb' => $string));
            
            if(!empty($request)) {
                return new User($request[0]['nom_UTILISATEUR'], $request[0]['prenom_UTILISATEUR'], $request[0]['embauche_UTILISATEUR'], $request[0]['ca_UTILISATEUR']);
            }
        }

        public static function addUser($lastname, $firstname, $emb, $ca) : void {
            $request = self::request('INSERT INTO `UTILISATEURS` VALUES (:lastname, :firstname, :emb, :ca)', array(':lastname' => $lastname, ':firstname' => $firstname, ':emb' => $emb, ':ca' => $ca));
        }

        public static function modifyUser($lastname, $firstname, $emb, $ca) : void {
            $request = self::request('UPDATE `UTILISATEURS` SET nom_UTILISATEUR = :lastname, prenom_UTILISATEUR = :firstname, embauche_UTILISATEUR = :emb, ca_UTILISATEUR = :emb WHERE embauche_UTILISATEUR = :emb', array(':lastname' => $lastname, ':firstname' => $firstname, ':emb' => $emb, ':ca' => $ca));
        }
    }
?>