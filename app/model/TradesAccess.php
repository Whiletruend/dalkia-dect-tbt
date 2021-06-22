<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'TradeAccess'
    class TradesAccess extends Database {
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

        /*
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
        */

        public static function addTrade($date, $hour, $numserie, $appel, $type, $trade, $newnumserie, $newtype, $nature, $emb, $ca) : void {
            $request = self::request('INSERT INTO `DECT_ECHANGES`(date_echange, heure_ECHANGE, numserie_DECT, appel_DECT, type_DECT, echange, newnumserie_DECT, newtype_DECT, nature_ECHANGE, embauche_UTILISATEUR, ca_UTILISATEUR) VALUES (:date_echange, :heure, :numserie, :appel, :type_dect, :echange, :newnumserie, :newtype, :nature, :emb, :ca)', array(':date_echange' => $date, ':heure' => $hour, ':numserie' => $numserie, ':appel' => $appel, ':type_dect' => $type, ':echange' => $trade, ':newnumserie' => $newnumserie, ':newtype' => $newtype, ':nature' => $nature, ':emb' => $emb, ':ca' => $ca));
        }
    }
?>