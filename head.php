<?php
include('connexionBDD.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
    <a href="index.php">Accueil</a>
    <a href="articles.php">Articles</a>
    <a href="inscription.php">S'inscrire</a>
    <a href="ajouter.php">Ajouter un article</a>
    <div class="co">
        <?php    
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            // Utilisateur connecté, afficher le bouton de déconnexion
            echo '<button type="button" name="monespace"><a href="utilisateur.php">Mon espace</a></button>';
            echo '<button type="submit" name="deconnection"><a href="deconnexion.php">Déconnexion</a></button>';
        } else {
            // Utilisateur non connecté, afficher le bouton de connexion
            echo '<button type="button" name="connexion"><a href="connexion.php">Connexion</a></button>';
        }
        ?>
    </div>
</div>
</body>
</html>
