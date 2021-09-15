<?php

require 'connection.php';

$db = getConnection();

// Suppression de l'utilisateur
$query = $db->prepare("
	DELETE FROM employees
	WHERE employeeNumber = ?
");

$query->execute([
	$_GET['id']
]);

// Redirection
header('Location: index.php');
exit();