<?php

global $dbConfig;
$dbConfig = array();
define('VERSION', '*.*');

switch(ENVIROMENT){
	case "************":
		define("BASE_URL", '*****************');
		$dbConfig['dbName'] = '*****************';
		$dbConfig['dbHost'] = '*****************';
		$dbConfig['dbUser'] = '*****************';
		$dbConfig['dbPass'] = '*****************';
		break;
    case "************":
		define("BASE_URL", '*****************');
		$dbConfig['dbName'] = '*****************';
		$dbConfig['dbHost'] = '*****************';
		$dbConfig['dbUser'] = '*****************';
		$dbConfig['dbPass'] = '*****************';
		break;
    case "************":
		define("BASE_URL", '*****************');
		$dbConfig['dbName'] = '*****************';
		$dbConfig['dbHost'] = '*****************';
		$dbConfig['dbUser'] = '*****************';
		$dbConfig['dbPass'] = '*****************';
		break;
	default:
        define("BASE_URL", '*****************');
		$dbConfig['dbName'] = '*****************';
		$dbConfig['dbHost'] = '*****************';
		$dbConfig['dbUser'] = '*****************';
		$dbConfig['dbPass'] = '*****************';
}
