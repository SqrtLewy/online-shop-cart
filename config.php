<?php

try{
	$database = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
}

catch (PDOException $e){
	echo "Failed to connect to database!";
}