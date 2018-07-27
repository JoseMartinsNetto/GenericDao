<?php

/**
 * php GenericDao test file
 * run as command line for test this library
 */
require __DIR__ . '/vendor/autoload.php';

use Jose\GenericDao\ {
    DBConfig,
    GenericDao
};

// Set the config file to connect in database
DBConfig::setFileConfig(__DIR__ . '/DBConfigExemple.json');

// run test
$exempleDao = new GenericDao('tests');

print_r($exempleDao->getItems());