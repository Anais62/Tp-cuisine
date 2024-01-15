<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');

// On récupère les données envoyées par le formulaire
if (!empty($_POST['userEmailco']) && !empty($_POST['userPasswordco'])) {
    $emailco = $_POST['userEmailco'];
    $mdpco = $_POST['userPasswordco'];

    // Vérification de l'e-mail
    $sql = "SELECT * FROM `user` WHERE email = :email";
    $query = $db->prepare($sql);
    $query->bindValue(":email", $emailco, PDO::PARAM_STR);
    $query->execute();
    $verifEmail = $query->fetch(PDO::FETCH_ASSOC);
    

    // Vérification du mot de passe
    if ($verifEmail && password_verify($mdpco, $verifEmail['password'])) {
        echo "Connexion réussie";

        // Ouverture de la session

        session_start();
        $_SESSION["id"] = $verifEmail['id'];
        $_SESSION["name"] = $verifEmail['name'];
        $_SESSION["admin"] = $verifEmail['admin'];
        $_SESSION["logged"] = true;
        echo "Bonjour ".$verifEmail['name'];

        // Redirection vers la page de l'utilisateur

        header("Location: pageutilisateur.php");
        
        exit();
    } else {
        echo "Adresse e-mail ou mot de passe incorrect";
    }
}
if (isset($_POST['noSign'])) {
    // Redirection vers la page d'inscription
    header("Location: pageinscription.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<body>

<?php 

    $title = "Connexion";
    include("head.php"); 
    include("header.php");
    
?>
    
    <form id="formpagedeco" action="" method="POST">
        <h1 class="center-text">Connexion</h1>
        <div>
            <label for="emailco">Entrez votre adresse email:</label>
            <input class="form" type="email" name="userEmailco">
        </div> 

        <br>
         
        <div>
            <label for="passwordco">Entrez votre mot de passe:</label>
            <input class="form" type="password" id="password" name="userPasswordco">
        </div>

        <div class= "flex-center">
            <div class="spcace-button">
                <button type="submit">Connexion </button>
            </div>
        
            <div>
            <button id="noSign" name="noSign" type="submit"><a href="pageinscription.php">Pas encore inscrit ?</a></button>
            </div>
        </div>
      
    </form>

    <?php include("footer.php"); ?>
</body>
</html>
