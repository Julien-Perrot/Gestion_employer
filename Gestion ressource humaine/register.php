<?php

session_start();

// #### Formulaire

// Sur la page *register.php*, créer un formulaire d'inscription (nom d'utilisateur, email et mot de passe) qui va ajouter l'utilisateur dans la table *users*.

require 'connection.php';

$db = getConnection();

// Si on a envoyé des données depuis le formulaire (si on a cliqué sur le bouton du formulaire)
// On enregistre l'utilisateur
if (! empty($_POST)) {

	// Tableau (stocké dans la session) contenant toutes les erreurs du formulaire
	$_SESSION['errors'] = [];

	// Est-ce que le mot de passe est assez long ?
	if (strlen($_POST['password']) < 6) {
		$_SESSION['errors']['password'] = "Le mot de passe et trop court.";
	}
	
	// Avant d'enregistrer on vérifie si un utilisateur n'existe pas dèjà avec ce pseudo

	// #### Enregistrement de l'utilisateur

	// Lorsque le formulaire est soumis, on enregistre l'utilisateur dans la table *users* puis on redirige vers la page de connexion *login.php*.

	// Enregistrement de l'inscription du nouvelle utilisateur dans la base de données
	$query = $db->prepare("
		INSERT INTO users (username, email, password, creationDate)
		VALUES (?, ?, ?, NOW())
");

	$query->execute([
		$_POST['username'],
		$_POST['email'],
		password_hash($_POST['password'], PASSWORD_DEFAULT)
]);

	// Redirection vers la page de connexion login.php
	header('Location: login.php');
	exit();
}

// Information spécifique à la page
$template = 'register';
$title = 'Inscription';

// Chargement du layout
require 'layout.phtml';