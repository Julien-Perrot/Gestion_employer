<!-- ### Déconnexion

Créer un fichier *logout.php*. Lorsque l'on arrive sur cette page, cela déconnecte l'utilisateur et redirige vers la page d'accueil.

Code pour supprimer la session :
```php
session_start();
$_SESSION = [];
session_destroy();
``` -->

<?php

session_start();
$_SESSION = [];
session_destroy();

header('Location: index.php');
exit();