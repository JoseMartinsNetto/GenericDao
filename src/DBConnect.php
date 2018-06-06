<?php
namespace GenericDaoLib;

require 'IDBConnect.php';
require 'DBConfig.php';

use PDO;
use PDOException;

class DBConnect implements IDBConnect
{
    private static $db;
    private const DSN = DBConfig::DB_TYPE .':host=' . DBConfig::DB_HOST . ';dbname=' . DBConfig::DB_NAME;
    
    public static function connect(): void
    {
        try {
            self::$db = new PDO(self::DSN, DBConfig::DB_USER,  DBConfig::DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
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