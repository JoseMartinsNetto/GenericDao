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
     * Stores the Data Source Name of connection of database.
     * 
     * @var string
     */
    private const DSN = DBConfig::DB_TYPE .':host=' . DBConfig::DB_HOST . ';dbname=' . DBConfig::DB_NAME;
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IDBConnect::connect()
     */
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