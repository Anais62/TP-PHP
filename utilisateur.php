<?php

include('connexionBDD.php'); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
include('head.php');
echo "Bonjour " . $_SESSION['prenom'] . "<br>";
echo "Votre id est le numéro : " . $_SESSION['id'];
?>  
<h1>Vos articles favoris</h1>

<?php


    $sql = "SELECT * FROM favori JOIN article ON favori.id_article = article.id WHERE id_user = :user_id";
    $query = $db->prepare($sql);
    $query->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    $query->execute();
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);
    $query->closeCursor();

    foreach ($articles as $article) {
        echo '<div class="article">';
        echo '<img class="imagearticle" src="' . $article['image'] . '" alt="' . $article['nom'] . '">';
        echo '<div class="article-details">';
        echo '<h2>' . $article['nom'] . '</h2>';
        echo '<p>' . $article['description'] . '</p>';
        echo '<span>' . $article['prix'] . ' €</span>';
        echo '</div>';

        echo '<form method="post" action="">';
        echo '<input type="hidden" name="article_id" value="' . $article['id_article'] . '">';
        echo '<button type="submit" name="unlike" class="favori"><img src="image/like.png" class="favori"></button>';
        echo '</form>';
        echo '</div>'; 
        

    }
    if (isset($_POST['unlike'])) {
        $article_id = $_POST['article_id'];
        $sql = "DELETE FROM favori WHERE id_user = :id_user AND id_article = :id_article";
        $query = $db->prepare($sql);
        $query->bindValue(":id_user", $_SESSION['id'], PDO::PARAM_STR);
        $query->bindValue(":id_article", $article_id, PDO::PARAM_STR);
        $query->execute();
        
        header("Location: utilisateur.php");
    }
    ?>  

</body>
</html>
