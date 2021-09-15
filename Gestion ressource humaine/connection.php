<?php

function getConnection(): PDO
{
	// 6. Cette fonction renvoie la connexion à notre base de données (notre variable $db)
	return new PDO('mysql:host=localhost;dbname=exercice_PHP_MYSQL;charset=UTF8', 'root', 'root', [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
}