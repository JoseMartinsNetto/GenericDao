<?php
namespace Jose\GenericDao;

/**
 * Class of constants used to configure connection of database.
 * 
 * @author José Martins <j.msantos.netto@gmail.com>
 *
 */
abstract class DBConfig
{
    /**
     * Defines the type of connection Ex: mysql, sqllite, etc ...
     * 
     * @var string
     */
    const DB_TYPE = 'mysql';
    
    /**
     * Defines the name of database used.
     * 
     * @var string
     */
    const DB_NAME = 'myTestDb';
    
    /**
     * Defines the host of connection.
     * 
     * @var string
     */
    const DB_HOST = 'localhost';
    
    /**
     * Defines the username of conneciton.
     * 
     * @var string
     */
    const DB_USER = 'root';
    
    /**
     * Defines the password of connection.
     * 
     * @var string
     */
    const DB_PASS = '';
}