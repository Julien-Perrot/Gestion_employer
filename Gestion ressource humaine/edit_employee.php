<?php

require 'connection.php';

$db = getConnection();

if (empty($_POST)) {
	// Récupération de l'employé (dont l'id est dans l'url) pour pré-remplir les champs du formulaire
	$query = $db->prepare("
		SELECT *
		FROM employees
		WHERE employeeNumber = ?
");

	$query->execute([
		$_GET['id']
]);

	$employee = $query->fetch();

	// Récupération des employés (sauf l'employé en cours d'édition)
	$query = $db->prepare('
		SELECT employeeNumber, firstName, lastName
		FROM employees
		WHERE employeeNumber != ?
		ORDER BY lastName, firstName
');

	$query->execute([
		$employee['employeeNumber']
]);

	$managers = $query->fetchAll();

	// Récupération des bureaux (pour la sélection du bureau)
	$query = $db->prepare("
		SELECT officeCode, city
		FROM offices
		WHERE officeCode
		ORDER BY city
");

	$query->execute();
	$offices = $query->fetchAll();

} else {
	// Modification en base de données : récupérer toutes les données du formulaire, modifier les champs de l'utilisateur dont on a récupéré l'id (le input type="hidden")

//	var_dump($_POST);

	$query = $db->prepare("
		UPDATE employees SET firstName = ?, lastName = ?, extension = ?, email = ?, jobTitle = ?, officeCode = ?, reportsTo = ?
		WHERE employeeNumber = ?
");

	$query->execute([
		$_POST['firstName'],
		$_POST['lastName'],
		$_POST['extension'],
		$_POST['email'],
		$_POST['jobTitle'],
		$_POST['office'],
		$_POST['manager'],
		$_POST['id']
]);

	// Rediriger vers la liste des employés
	header('Location: index.php');
	exit();
}

$template = 'edit_employee';
$title = 'Modification employé';
require 'layout.phtml';