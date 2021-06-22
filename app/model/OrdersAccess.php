<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'OrdersAccess'
    class OrdersAccess extends Database {
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

        public static function addOrder($piece, $reference, $date, $ca, $client_name) : void {
            $request = self::request('INSERT INTO `DECT_COMMANDES`(piece, reference, date_demande, sdi_compas, ancien_fan, ca, quantite, nom_mrt, nom_client) VALUES (:piece, :reference, :date_demande, "GUICHET", "AUCUN", :ca, 1, "DK", :client_name)', array(':piece' => $piece, ':reference' => $reference, ':date_demande' => $date, ':ca' => $ca, ':client_name' => $client_name));
        }

        public static function removeEveryOccurences() : void {
            $query = self::query('DELETE FROM `DECT_COMMANDES` WHERE 1');
        }
    }
?>