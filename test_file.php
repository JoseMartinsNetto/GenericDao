<?php
/**
* php GenericDao test file
* run as command line for test this library
*/

require_once 'GenericDao.php';

$testDb = new GenericDao('tests');

print_r($testDb->getItems());