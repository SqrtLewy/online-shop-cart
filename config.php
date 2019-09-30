<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
	 $DATABASE_NAME = 'shop';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $e) {
    	die ('Failed to connect to database!');
    }
}