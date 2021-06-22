<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'WhichOrdersAccess'
    class WhichOrderAccess extends Database {
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
            $query = self::query('SELECT * FROM `DECT_COMMANDES` ORDER BY `id` ASC;');
            $table = array();
            
            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id']] = new Order($rows['id'], $rows['piece'], $rows['reference'], $rows['date_demande'], $rows['sdi_compas'], $rows['ancien_fan'], $rows['ca'], $rows['quantite'], $rows['nom_mrt'], $rows['nom_client']);
                }
            }

            return $table;
        }

        public static function getByGroupAndModel($group, $model) : array {
            $request = self::prepare('SELECT * FROM `DECT_QUE_COMMANDER` WHERE groupe=:group AND modele=:model;', array(':group' => $group, ':model' => $model));
            $table = array();

            if(!empty($request)) {
                foreach($request as $rows) {
                    $table[] = new WhichOrder($rows['id'], $rows['groupe'], $rows['modele'], $rows['pieces'], $rows['ref']);
                }
            }
            
            return $table;
        }
    }
?>