<?php
    # Requires
    namespace App\model;
    use PDO; # PDO is an object oriented extension to communicate with a database.

    # Class 'Database'
    class Database {
        # Class Variables
        private static ?object $db = null; # The '?' before 'object' means that the variable can be null
        private static string $host_DB = 'localhost'; # 127.0.0.1 can work too
        private static string $name_DB = 'dalkia_dect_tbt'; # The database name
        private static string $user_DB = 'root'; # The username (root is admin)
        private static string $pass_DB = ''; # The password, by default there's none

        # Class Functions
        protected static function getPDO() : object {
            if(is_null(self::$db)) {
                $connect = new PDO('mysql:host=' . self::$host_DB . ';dbname=' . self::$name_DB . ';charset=utf8', self::$user_DB, self::$pass_DB);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$db = $connect;
            }

            return self::$db;
        }

        protected static function query($statement) : array {
            $stat = self::getPDO()->query($statement);
            
            return $stat->fetchAll();
        }

        protected static function prepare($statement, $attributes) : array {
            $stat = self::getPDO()->prepare($statement);
            $stat->execute($attributes);

            return $stat->fetchAll();
        }

        protected static function request($statement, $attributes) : void {
            $stat = self::getPDO()->prepare($statement);
            $stat->execute($attributes);
        }
    }
?>