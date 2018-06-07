<?php

/**
* php GenericDao test file
* run as command line for test this library
*/

require __DIR__ . '/vendor/autoload.php';

use Jose\GenericDao\GenericDao;

$exempleDao = new GenericDao('tests');

print_r($exempleDao->getItems());