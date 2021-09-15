<?php

require 'connection.php';

$db = getConnection();

/*
 * 2 étapes : affichage du formulaire et enregistrement dans la base de données
 *
 */

// Si aucune donnée n'a été envoyée => affichage du formulaire
if (empty($_POST)) {
	// Récupération des employées (pour la sélection du responsable hiérarchique)
	$query = $db->prepare ('
		SELECT employeeNumber, firstName, lastName 
		FROM employees
		ORDER BY lastName, firstName
');

	$query->execute();
	$employees = $query->fetchAll();

	// Récupération des bureaux (pour la sélection du bureau)
	$query = $db->prepare("
		SELECT officeCode, city
		FROM offices
		ORDER BY city
");

	$query->execute();
	$offices = $query->fetchAll();
}

// Des données ont été envoyées depuis le formulaire => enregistrement dans la base de données
 else {

//	var_dump($_POST);

 	// Enregistrement dans la base de données du nouvel employé
	$query = $db->prepare("
		INSERT INTO employees (firstName, lastName, extension, email, jobTitle, reportsTo, officeCode)
		VALUES (?, ?, ?, ?, ?, ?, ?)
");

// var_dump($_POST);

	$query->execute([
		$_POST['firstName'],
		$_POST['lastName'],
		$_POST['extension'],
		$_POST['email'],
		$_POST['jobTitle'],
		$_POST['manager'],
		$_POST['office'],
]);

	// Redirection vers la page liste des employés
	header('Location: index.php');
	exit();

}

// Information spécifique à la page
$template = 'add_employee';
$title = 'Ajouter un employé';

// Chargement du layout
require 'layout.phtml';