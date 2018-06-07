<?php
namespace MVC\Models\GenericDaoLib;

use PDO;

/**
 * Interface for class of constants DBConnect
 * 
 * @author José Martins <j.msantos.netto@gmail.com>
 *
 */
interface IDBConnect
{
    /**
     * Method establishes the connection of database and stores the connection in private variable $db.
     * 
     */
    static function connect(): void;
    
    /**
     * Method return the connection  of database.
     *
     * @return PDO
     */
    static function getConnection(): PDO;
}
