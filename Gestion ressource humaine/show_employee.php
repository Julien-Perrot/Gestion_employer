<?php

require 'connection.php';

// Connexion à la base de données
$db = getConnection();

// Récupération des informations de l'employé
$query = $db->prepare("
	SELECT e.employeeNumber, e.firstName, e.lastName, e.email, e.jobTitle, m.firstName AS managerFirstName, m.lastName AS managerLastName, m.jobTitle AS managerJob, o.addressLine1, o.postalCode, o.city, o.country
	FROM employees e
	INNER JOIN employees m ON e.reportsTo = m.employeeNumber
	INNER JOIN offices o ON o.officeCode = e.officeCode
	WHERE e.employeeNumber = ?
");

// Récupération des informations de l'employé Diane MURPHY 1002
/* $query = $db->prepare("
	SELECT e.employeeNumber, e.firstName, e.lastName, e.email, e.jobTitle, m.firstName AS managerFirstName, m.lastName AS managerLastName, m.jobTitle AS managerJob, o.addressLine1, o.postalCode, o.city, o.country
	FROM employees e
	LEFT JOIN employees m ON e.reportsTo = m.employeeNumber
	INNER JOIN offices o ON o.officeCode = e.officeCode
	WHERE e.employeeNumber = ?
"); */

$query->execute([
	$_GET['id']
]);

$employee = $query->fetch();

// Récupération de la liste des clients de l'employé
$query = $db->prepare("
	SELECT customerName, country
	FROM customers
	WHERE salesRepEmployeeNumber = ?
	ORDER BY customerName
");

$query->execute([
	$_GET['id']
]);

$customers = $query->fetchAll();

// // Version avec la requête 2 en 1
// $query = $db->prepare("
// 	SELECT e.employeeNumber, e.firstName, e.lastName, e.email, e.jobTitle, m.firstName AS managerFirstName, m.lastName AS managerLastName, m.jobTitle AS managerJob, o.addressLine1, o.postalCode, o.city, o.country, c.customerName, c.country
// 	FROM employees e
// 	INNER JOIN employees m ON e.reportsTo = m.employeeNumber
// 	INNER JOIN offices o ON o.officeCode = e.officeCode
// 	INNER JOIN customers c ON c.salesRepEmployeeNumber = e.employeeNumber
// 	WHERE e.employeeNumber = ?
// ");

// $query->execute([
// 	$_GET['id']
// ]);

// $customers = $query->fetchAll();
// $employee = $customers[0];

$template = 'show_employee';

// $title = 'Fiche info ' . $employee['firstName'] . ' ' . $employee['lastName'];
$title = "Fiche info {$employee['firstName']} {$employee['lastName']}";

require 'layout.phtml';