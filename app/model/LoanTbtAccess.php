<?php
    # Requires
    namespace App\model;
    use PDO;

    # Class 'LoanTbtAccess'
    class LoanTbtAccess extends Database {
        # Class Functions
        public static function customRequest($request) : array {
            $query = self::query($request);
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id_PRET']] = new LoanTBT($rows['id_PRET'], $rows['localTBT_PRET'], $rows['fournisseurs_PRET'], $rows['contact_PRET'], $rows['donneurOrdre_PRET'], $rows['descriptionTrav_PRET'], $rows['dateSort_PRET'], $rows['datePrev_PRET'], $rows['dateRet_PRET'], $rows['intervenant_PRET'], );
                }
            }

            return $table;
        }

        public static function getAll() : array {
            $query = self::query('SELECT * FROM `TBT_PRETS`');
            $table = array();

            if(!empty($query)) {
                foreach($query as $rows) {
                    $table[$rows['id_PRET']] = new LoanTBT($rows['id_PRET'], $rows['localTBT_PRET'], $rows['fournisseurs_PRET'], $rows['contact_PRET'], $rows['donneurOrdre_PRET'], $rows['descriptionTrav_PRET'], $rows['dateSort_PRET'], $rows['datePrev_PRET'], $rows['dateRet_PRET'], $rows['intervenant_PRET'], );
                }
            }

            return $table;
        }

        public static function getByID($string) : object {
            $request = self::prepare('SELECT * FROM `TBT_PRETS` WHERE id_PRET=:id', array(':id' => $string));

            if(!empty($request)) {
                return new LoanTBT($request[0]['id_PRET'], $request[0]['localTBT_PRET'], $request[0]['fournisseurs_PRET'], $request[0]['contact_PRET'], $request[0]['donneurOrdre_PRET'], $request[0]['descriptionTrav_PRET'], $request[0]['dateSort_PRET'], $request[0]['datePrev_PRET'], $request[0]['dateRet_PRET'], $request[0]['intervenant_PRET']);
            }
        }

        public static function changePrevDate($date, $id) : void {
            $request = self::request("UPDATE `TBT_PRETS` SET datePrev_PRET = :datePrev WHERE id_PRET = :id;", array(':datePrev' => $date, ':id' => $id));
        }

        public static function addLoan($table) : void {
            $request = self::request('INSERT INTO `TBT_PRETS`(localTBT_PRET, fournisseurs_PRET, contact_PRET, donneurOrdre_PRET, descriptionTrav_PRET, dateSort_PRET, datePrev_PRET, dateRet_PRET, intervenant_PRET) VALUES (:localtbt, :providers, :contact, :orderGiver, :descriptionT, :todayDate, :prevDate, "", "")', array(':localtbt' => $table['localTBT'], ':providers' => $table['company'], ':contact' => $table['contact'], ':orderGiver' => $table['orderGiver'], ':descriptionT' => $table['description'], ':todayDate' => $table['todayDate'], ':prevDate' => $table['prevDate']));      
        }

        public static function restituteKey($string) : void {
            $request = self::request('DELETE FROM `TBT_PRETS` WHERE id_PRET = :id', array(':id' => $string));
        }
    }
?>