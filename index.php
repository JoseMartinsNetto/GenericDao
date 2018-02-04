<?php
/**
* php GenericDao test file
* run as command line for test this library
*/

require __DIR__. '/vendor/autoload.php';

use GenericDaoLib\GenericDao as DBExmpleDao;

$exempleDao = new DBExmpleDao('tests');

print_r($exempleDao->getItems());