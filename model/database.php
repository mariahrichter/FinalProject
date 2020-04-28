<?php
class Database {
    private static $dsn = 'mysql:host=localhost;dbname=earlylearning';
    private static $username = 'mariahrichter';
    private static $password = 'password123';
    private static $db;

    private function __construct() {}

    public static function getDB () {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$password);
                //add error mode exception
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('../errors/database_error.php');
                exit();
            }
        }
        return self::$db;
    }
}
?>