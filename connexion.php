<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');

$verifEmail = null;
// On récupère les données envoyées par le formulaire
if (!empty($_POST['email']) && !empty($_POST['mdp'])) {
    $emailco = $_POST['email'];
    $mdpco = $_POST['mdp'];

    // Vérification de l'e-mail
    $sql = "SELECT * FROM `user` WHERE email = :email";
    $query = $db->prepare($sql);
    $query->bindValue(":email", $emailco, PDO::PARAM_STR);
    $query->execute();
    $verifEmail = $query->fetch(PDO::FETCH_ASSOC);
    
  
        
}
if ($verifEmail && password_verify($mdpco, $verifEmail['mdp'])) {
        
    session_start();
    
    $_SESSION["id"] = $verifEmail['id'];
    $_SESSION["nom"] = $verifEmail['nom'];
    $_SESSION["prenom"] = $verifEmail['prenom'];
    $_SESSION["logged"] = true;
    
    // Redirection vers la page de l'utilisateur

    header("Location: utilisateur.php");
    
    exit();
}else{
    $errorMessage = "Identifiants incorrects. Veuillez réessayer.";
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

<form class="form" action="" method="POST">
        <h1>Connexion</h1>
        <div>
            <label for="email">Entrez votre adresse email:</label>
            <input class="" type="email" name="email">
        </div> 

        <br>
         
        <div>
            <label for="mdp">Entrez votre mot de passe:</label>
            <input class="" type="password" id="password" name="mdp">
        </div>

      
                <button type="submit">Connexion </button>
            </div>
        
           
        
      
    </form>



</form>
</body>
</html>