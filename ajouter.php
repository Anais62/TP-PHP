<?php
include('connexionBDD.php');

if (!empty($_POST['nom']) && !empty($_POST['description']) && 
 !empty($_POST['image']) && !empty($_POST['prix'])) {
    
    // On récupère les infos du formulaire et on les stocke dans des variables 
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $prix = $_POST['prix'];
     
    // Préparation de la requête
     $requete = 'INSERT INTO article (nom, description, image, prix) VALUES (:nom, :description, :image, :prix )';

     // Création d'un objet PDOStatement
     $query = $db->prepare($requete);

     // Association des valeurs aux paramètres de l'objet PDOStatement
     $query->bindValue(':nom', $nom, PDO::PARAM_STR);
     $query->bindValue(':description', $description, PDO::PARAM_STR);
     $query->bindValue(':image', $image, PDO::PARAM_STR);
     $query->bindValue(':prix', $prix, PDO::PARAM_STR);
     
    // Exécution de la requête
    $query->execute();

    // Fermeture du curseur
    $query->closeCursor();
 
    // Redirection vers la page d'accueil 
    header("Location: index.php");
}
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
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    echo "<center><h1>Ajouter l'article de votre choix</h1></center>";
    echo "<form class='form' action='' method='POST' name='ajout'>";
    echo "<label for='nom'>Nom : </label>";
    echo "<input type='text' name='nom'>";
    echo "<label for='description'>Description :</label>";
    echo "<input type='text' name='description'></input>";
    echo "<label for='image'>Image :</label>";
    echo "<input type='text' name='image'>";
    echo "<label for='prix'>Prix :</label>";
    echo "<input type='text' name='prix'>";

    echo "<input type='submit' value='Ajouter un article'>";
    echo "</form>";
} else {
    echo "<div class='seco'>Veuillez vous inscrire pour pouvoir ajouter un article</div>";
}
?>

</body>
</html>
