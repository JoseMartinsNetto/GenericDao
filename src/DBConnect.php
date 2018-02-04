<?php

namespace GenericDaoLib;

use PDO;

class DBConnect implements IDBConnect
{
    private static $db;
    private const DSN = DBConfig::DB_TYPE .':host=' . DBConfig::DB_HOST . ';dbname=' . DBConfig::DB_NAME;

    static function Connect()
    {
        try {
			self::$db = new PDO(self::DSN, DBConfig::DB_USER,  DBConfig::DB_PASS);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$db;
        } catch (Throwable $error) {
            exit('Error to connect to DataBase: Error returned:>>' . $error->getMessage());
        }

    }

}
