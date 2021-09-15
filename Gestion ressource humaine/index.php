<?php

// Démarrage de la session
session_start();

require 'connection.php';

// Connexion à la base de données
$db = getConnection();

$query = $db->prepare("
	SELECT employeeNumber, firstName, lastName, email, jobTitle
	FROM employees
	ORDER BY lastName, firstName
");

$query->execute();

$employees = $query->fetchAll();

// var_dump($employees);

// Contenu spécifique de la page
$template = 'index';
$title = 'Liste employés';

// Affichage du code html commun aux autres pages
require 'layout.phtml';