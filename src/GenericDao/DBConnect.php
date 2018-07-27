<?php
namespace Jose\GenericDao;

use PDO;
use PDOException;

/**
 * @author José Martins <j.msantos.netto@gmail.com>
 *
 */
class DBConnect implements IDBConnect
{
    /**
     * Stores the instance of PDO class.
     * 
     * @var PDO
     */
    private static $db;
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IDBConnect::connect()
     */
    public static function connect(): void
    {
        $dbConfig = DBConfig::getConfig();
        
        $dsn = $dbConfig['type'] .':host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['name'];
        
        try {
            self::$db = new PDO($dsn, $dbConfig['user'],  $dbConfig['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            exit('Error to connect to DataBase: Error returned:>>' . $error->getMessage());
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IDBConnect::getConnection()
     */
    public static function getConnection(): PDO
    {
        self::connect();
        return self::$db;
    }
    
}