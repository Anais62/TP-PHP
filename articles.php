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
    ?>

    <?php
    
    if(isset($_SESSION['logged']) && ($_SESSION['logged'])===true){
    
    $sql = "SELECT * FROM article";
    $query = $db->prepare($sql);
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

        // Vérifier si l'article est déjà dans les favoris pour cet utilisateur
        $checkSql = "SELECT * FROM favori WHERE id_user = :user_id AND id_article = :article_id";
        $checkQuery = $db->prepare($checkSql);
        $checkQuery->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $checkQuery->bindValue(':article_id', $article['id'], PDO::PARAM_INT);
        $checkQuery->execute();

        echo '<form method="post" action="">';
        echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';

        // Afficher le bouton approprié en fonction de la présence de l'article dans les favoris
        if ($checkQuery->rowCount() == 0) {
            echo '<button type="submit" name="like" class="favori"><img src="image/favori.png" class="favori"></button>';
        } else {
            echo '<button type="submit" name="unlike" class="favori"><img src="image/like.png" class="favori"></button>';
        }

        echo '</form>';
        echo '</div>';

        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            if (isset($_POST['like'])) {
                $article_id = $_POST['article_id'];

                // Vérifie avant d'ajouter
                $checkSql = "SELECT * FROM favori WHERE id_user = :user_id AND id_article = :article_id";
                $checkQuery = $db->prepare($checkSql);
                $checkQuery->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
                $checkQuery->bindValue(':article_id', $article_id, PDO::PARAM_INT);
                $checkQuery->execute();

                if ($checkQuery->rowCount() == 0) {
                    
                    // Ajouter à la table favori
                    $sql = "INSERT INTO favori (id_user, id_article, statu) VALUES (:id_user, :id_article, :statu)";
                    $query = $db->prepare($sql);
                    $query->bindValue(":id_user", $_SESSION['id'], PDO::PARAM_STR);
                    $query->bindValue(":id_article", $article_id, PDO::PARAM_STR);
                    $query->bindValue(":statu", 1, PDO::PARAM_STR);
                    $query->execute();
                }

                header("Location: articles.php");
            }
            if (isset($_POST['unlike'])) {
                $article_id = $_POST['article_id'];
                $sql = "DELETE FROM favori WHERE id_user = :id_user AND id_article = :id_article";
                $query = $db->prepare($sql);
                $query->bindValue(":id_user", $_SESSION['id'], PDO::PARAM_STR);
                $query->bindValue(":id_article", $article_id, PDO::PARAM_STR);
                $query->execute();
                
                header("Location: articles.php");
            }
        }
    }}else{
        echo "<div class='seco'>Veuillez vous inscrire pour avoir acces aux articles</div>";
    }
    ?> 
</body>
</html>

