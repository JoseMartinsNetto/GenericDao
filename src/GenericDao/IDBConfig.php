<?php
namespace Jose\GenericDao;

/**
 *
 * @author José Martins <j.msantos.netto@gmail.com>
 *        
 */
interface IDBConfig
{

    /**
     * Setup file DBConfig.json to stores DB Information
     *
     * @param string $location
     */
    public static function setFileConfig(string $location);

    /**
     * Get the array with the DBConfig
     *
     * @return array
     */
    public static function getConfig(): array;
}

