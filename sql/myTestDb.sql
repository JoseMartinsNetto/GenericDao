/*
* Create myTestDb
* DataBase for test in GenericDao
* 
*/

CREATE DATABASE myTestDb;

USE myTestDb;

CREATE TABLE tests(
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	name VARCHAR(255) NOT NULL,
	age INT NOT NULL,
	gender VARCHAR(10)
);

INSERT INTO tests
	SET name = 'name 1',
	age = 18,
	gender = 'MALE';

INSERT INTO tests
	SET name = 'name 2',
	age = 16,
	gender = 'FEMALE';

INSERT INTO tests
	SET name = 'name 3',
	age = 30,
	gender = 'MALE';

INSERT INTO tests
	SET name = 'name 4',
	age = 20,
	gender = 'FEMALE';