<?php

require_once 'config.genericDao.php';
require_once 'IDBConnect.php';

class DBConnect implements IDBConnect {

    private static $db;
    private static $dsn;
    private static $dbConfig;

    public function __construct(){
        global $dbConfig;
        self::$dbConfig = $dbConfig;
        self::$dsn = 'mysql:host=' . self::$dbConfig['dbHost'] . ';dbname=' . self::$dbConfig['dbName'];
        self::connect();
    }

    public static function connect()
    {
       if(self::verifyConection(self::$dbConfig, 'Construct method')){
            self::$db = new PDO(self::$dsn, self::$dbConfig['dbUser'], self::$dbConfig['dbPass']);
       }
      
    }

    public static function verifyConection(array $dbConfig, string $font = 'not declared!'): bool
    {
        $font = "*!* ".$font." *!*";
        if (!isset($dbConfig['dbHost']) && empty($dbConfig['dbHost']))
        {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente o nome da base de dados chave = { dbHost } e valor correspondente!");
        }

        if (!isset($dbConfig['dbName']) && empty($dbConfig['dbName']))
        {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente o nome da base de dados chave = { dbName } e valor correspondente!");
        }

        if (!isset($dbConfig['dbUser']) && empty($dbConfig['dbUser']))
        {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente o usuário da base de dados chave = { dbUser } e valor correspondente!");
        }

        if (!isset($dbConfig['dbPass']) && empty($dbConfig['dbPass']))
        {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente a senha da base de dados chave = { dbPass } e valor correspondente!");
        }
        return true;
    }

}

new DBConnect();