<?php

session_start();

require 'connection.php';

$db = getConnection();

// Si les données viennent du formulaire
if (empty($_POST)) {
	// Affichage du formulaire
}

else {
	// Gestion de la connexion

	// On récupère l'utilisateur correspondant au nom qui à été saisi dans le formulaire
	$query = $db->prepare("
		SELECT id, username, email, password
		FROM users
		WHERE username = ?
");

	$query->execute([
		$_POST['username']
]);

	$user = $query->fetch();

	// Gestion d'erreur sur le nom d'utilisateur
	if ($user === false) {
		// Cas où l'utilisateur n'existe pas
		$_SESSION['error'] = "L'utilisateur n'existe pas";
		header('Location: login.php');
		exit();
	}

//	var_dump($user);

	// Gestion d'erreur sur le mot de passe
	if (! password_verify($_POST['password'], $user['password'])) {
		// Cas où le mot de passe ne correspond pas
		$_SESSION['error'] = "Le mot de passe est erroné";
		header('Location: login.php');
		exit();
	}

	// Nom d'utilisateur et mot de passe OK !
	// => Connexion de l'utilisateur : on enregistre les informations de l'utilisateur dans la session
	$_SESSION['auth'] = [
		'id' => $user['id'],
		'username' => $user['username'],
		'email' => $user['email']
];

	header('Location: index.php');
	exit();
}


// Information spécifique à la page
$template = 'login';
$title = 'Connexion';

// Chargement du layout
require 'layout.phtml';