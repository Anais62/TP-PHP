<?php
include('connexionBDD.php');


if (!empty($_POST['nom']) && !empty($_POST['prenom']) && 
 !empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['mdp2'])) {
    
//     On récupére les infos du formulaire et en les stockants dans des variables 

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];

//      On verifie si l'adresse mail est déjà utilisé
    
     $sql = "SELECT * FROM `user` WHERE email = :email";
     $query = $db->prepare($sql);
     $query->bindValue(":email", $email, PDO::PARAM_STR);
     $query->execute();
     $verifEmail = $query->fetch();
     var_dump($verifEmail);

//      Si l'adresse mail n'est pas dans la bdd on rentre dans la condition sinon incorrecte
        
      if($verifEmail === false) {

        // Vérification des 2 mots de passe identiques 

        if ($mdp === $mdp2) {
            // Hachage du mot de passe
            $motdepassehash = password_hash($mdp, PASSWORD_DEFAULT);

            // Préparation de la requête
            $requete = 'INSERT INTO user (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp )';

            // Création d'un objet PDOStatement
            $query = $db->prepare($requete);

            // Association d'une valeur à un paramètre de l'objet PDOStatement
            $query->bindValue(':nom', $nom, PDO::PARAM_STR);
            $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':mdp', $motdepassehash, PDO::PARAM_STR);
            

           
         // Exécution de la requête
         $query->execute();

         // Fermeture du curseur : la requête peut être de nouveau exécutée
         $query->closeCursor();
        
         // redirection vers la page de co 

         header("Location: index.php");

        } else {
         echo 'Les mots de passe ne correspondent pas. Veuillez réessayer.';
        }
        } else {
        echo "Adresse e-mail incorrecte";
        }

    }
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

<?php
include('head.php');
?> 

<?php
// Si l'utilisateur n'est pas connecté, afficher le formulaire d'inscription
if (!isset($_SESSION['logged']) || $_SESSION['logged'] === false) {
    echo '<center><h1>S\'inscrire</h1></center>';
    echo '<form class="form" action="" method="POST" name="inscription">';
    echo '<label for="nom">Nom</label>';
    echo '<input type="text" name="nom">';

    echo '<label for="prenom"> Prenom</label>';
    echo '<input type="text" name="prenom"></input>';

    echo '<label for="email">Email</label>';
    echo '<input type="email" name="email">';

    echo '<label for="mdp">Mot de passe</label>';
    echo '<input type="password" name="mdp">';

    echo '<label for="mdp2">Entrer de nouveau votre mot de passe</label>';
    echo '<input type="password" name="mdp2">';

    echo '<input type="submit" value="S\'inscrire">';

    echo '</form>';
} else {
    echo "<div class='seco'>Vous êtes déjà inscrit !</div>";
}
?>

</body>
</html>