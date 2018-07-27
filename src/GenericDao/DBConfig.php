<?php
namespace Jose\GenericDao;

/**
 * Class used to configure connection of database.
 *
 * @author JosÃ© Martins <j.msantos.netto@gmail.com>
 *        
 */
class DBConfig implements IDBConfig
{

    /**
     * Stores the config setup in setFileConfig()
     *
     * @var array
     */
    private static $dbConfig = [];

    /**
     *
     * {@inheritdoc}
     * @see \Jose\GenericDao\IDBConfig::getConfig()
     */
    public static function setFileConfig(string $location)
    {
        $fileConfig = file_get_contents($location);

        self::$dbConfig = json_decode($fileConfig, true);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Jose\GenericDao\IDBConfig::getConfig()
     */
    public static function getConfig(): array
    {
        return self::$dbConfig;
    }
}