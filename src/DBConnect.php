<?php

namespace GenericDao;

use PDO;

class DBConnect implements IDBConnect
{
    private static $db;
    private const Dsn = DBConfig::DBType .':host=' . DBConfig::DBHost . ';dbname=' . DBConfig::DBName;

    static function Connect()
    {
        try {
            self::$db = new PDO(self::Dsn, DBConfig::DBUser,  DBConfig::DBPass);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$db;
        } catch (PDOExeption $error) {
            exit('Error to connect to DataBase: Error returned:>>' . $error);
        }

    }

}
