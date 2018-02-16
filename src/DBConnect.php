<?php
namespace GenericDaoLib;

require 'IDBConnect.php';
require 'DBConfig.php';

use PDO;

class DBConnect implements IDBConnect
{
    private static $db;
    private const DSN = DBConfig::DB_TYPE .':host=' . DBConfig::DB_HOST . ';dbname=' . DBConfig::DB_NAME;

    public static function connect(): void
    {
        try {
			self::$db = new PDO(self::DSN, DBConfig::DB_USER,  DBConfig::DB_PASS);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            exit('Error to connect to DataBase: Error returned:>>' . $error->getMessage());
        }
    }

    public static function getConnection()
    {
        self::connect();
        return self::$db;
    }

}
