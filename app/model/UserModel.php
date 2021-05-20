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
            $query = self::query('SELECT * FROM UTILISATEURS');
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['embauche_UTILISATEUR']] = new User($rows['nom_UTILISATEUR'], $rows['prenom_UTILISATEUR'], $rows['embauche_UTILISATEUR'], $rows['ca_UTILISATEUR']);
                }
            }

            return $table;
        }
    }
?>