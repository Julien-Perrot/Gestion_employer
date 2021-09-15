# Gestion des employés

## Objectifs

Création d'une petite application web qui va permettre d'afficher la liste des employés, le détail de l'employé, créer un nouvel employé, mettre à jour l'employé, supprimer l'employé.

## Technologies

* PHP et PDO pour la partie serveur
* Bootstrap autorisé (par défaut pour la correction)

## Instructions

### Liste des employés

Afficher tous les employés de notre table *employees* dans un tableau HTML.
On affichera le nom et prénom de l'employé, l'email, le numéro (*employeeNumber*) et le poste.
Comme pour l'exercice des commandes, on mettre un lien sur le numéro de l'employé qui nous enverra vers le détail de l'employé (page *show_employee.php*).

### Détail de l'employé

Lorsqu'on arrive sur la page de détail de l'employé (*show_employee.php?id=xxx*), on affichera les informations suivantes :
* prénom
* nom
* numéro
* email
* poste
* nom, prénom et poste du responsable hiérarchique
* addresse, code postal, ville et pays du bureau dans lequel l'employé travaille

### Création d'un nouvel employé

**Passer le champ employeeNumber en Auto-Increment**

<!-- ALTER TABLE customers DROP FOREIGN KEY customers_ibfk_1;
ALTER TABLE employees DROP FOREIGN KEY employees_ibfk_1;
ALTER TABLE employees MODIFY employeeNumber INTEGER NOT NULL AUTO_INCREMENT;
ALTER TABLE customers ADD CONSTRAINT customers_ibfk_1 FOREIGN KEY (salesRepEmployeeNumber) REFERENCES employees(employeeNumber);
ALTER TABLE employees ADD CONSTRAINT employees_ibfk_1 FOREIGN KEY (reportsTo) REFERENCES employees(employeeNumber); -->

#### Affichage formulaire

Créer un formulaire pour l'ajout d'un nouvel employé avec les champs suivants :
* prénom					(text)
* nom 						(text)
* email						(email)
* extension					(text)
* poste						(text)
* bureau					(select)
* responsable hiérarchique 	(select)

Il faut récupérer au préalable (à l'aide d'une requête SQL) tous les bureaux et tous les employés pour les afficher dans les 2 champs select.

#### Enregistrement dans la base de données

Lorsque le formulaire est validé, on récupère toutes les informations du formulaire (les champs correspondant au bureau et au responsable hiérarchique doivent être récupérés sous forme numérique). On insère ces informations dans la base de données puis on redirige vers la liste des employés.

### Modification et suppression

Sur le tableau avec tous les employés, ajouter 2 liens : "Modifier l'employé" et "Supprimer l'employé".
Le lien "Modifier l'employé" envoie vers la page *edit_employee.php* et le lien "Supprimer l'employé" envoie vers la page *delete_employee.php*.

#### Modification

Lorqu'on arrive sur la page de modification de l'employé (page edit_employee.php?id=xxx), on arrive sur un formulaire d'édition similaire à celui de la création avec le nom, email, extension et poste déjà pré-renseignés. Lorsque vous soumettrez ce formulaire d'édition, il faudra récupérer les données et les mettre à jour en base de données.

Rediriger vers la liste des employées.

#### Suppression

Lorqu'on arrive sur la page de modification de l'employé (page delete_employee.php?id=xxx), cela supprime l'employé correspondant (dont l'id est passé dans l'url) et redirige vers la liste des employés.

### Inscription

#### Base de données

Créer une nouvelle table *users* avec les champs suivants :
* id (int, AI, primary key)
* username (varchar(100))
* email (varchar(255))
* password (varchar(60))
* creationDate (datetime)

<!-- CREATE TABLE IF NOT EXISTS users (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	username VARCHAR(100) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(60) NOT NULL,
	creationDate datetime NOT NULL,
	PRIMARY KEY (id)
)
ENGINE=INNODB;
-->
#### Formulaire

Sur la page *register.php*, créer un formulaire d'inscription (nom d'utilisateur, email et mot de passe) qui va ajouter l'utilisateur dans la table *users*.

#### Enregistrement de l'utilisateur

Lorsque le formulaire est soumis, on enregistre l'utilisateur dans la table *users* puis on redirige vers la page de connexion *login.php*.

### Connexion

#### Formulaire

Sur la page *login.php* créer un formulaire de connexion (nom d'utilisateur, mot de passe).

#### Sauvegarde de l'utilisateur dans la session

Si le nom d'utilisateur dans la base de données correspond bien au nom d'utilisateur tapé dans le formulaire ET si le mot de passe hashé en base de données correspond bien au mot de passe tapé dans le formulaire, on enregistre les informations de l'utilisateur dans la session. Sinon on le renvoie sur la page de connexion avec un message d'erreur.

```php
session_start();

if (/* condition */) {
	$_SESSION['error'] = 'Message d\'erreur';
	// Redirection
}

$_SESSION['auth'] = [
	// Informations de l'utilisateur depuis la base de donnée
];
```

### Déconnexion

Créer un fichier *logout.php*. Lorsque l'on arrive sur cette page, cela déconnecte l'utilisateur et redirige vers la page d'accueil.

Code pour supprimer la session :
```php
session_start();
$_SESSION = [];
session_destroy();
```

### Vérification des données du formulaire lors de l'inscription

Si une erreur est détectée lors de l'inscription, on redirige vers le formulaire d'inscription avec une erreur.

Afficher un message d'erreur : 
* si l'utilisateur avec lequel on essaie de s'inscrire existe déjà
* si le mot de passe fait moins de 6 caractères

Un peu comme pour la page de connexion, utiliser la session pour stocker les erreurs pour les afficher après la redirection.

```php
$_SESSION['errors'][] = 'nouveau message d\'erreur';
```






