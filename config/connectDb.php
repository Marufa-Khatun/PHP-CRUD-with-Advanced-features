<?php
function connect()
{
	try {
		$connection = new PDO('mysql:host=localhost;dbname=dbCrud', 'marufa', 'localhost');
		return $connection;
	} catch (PDOException $error) {
		return $error->getMessage();
	}
}
