<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');


// On recupere les données envoyées par le formulaire


if (!empty($_POST['userSurname']) && !empty($_POST['userName']) && !empty($_POST['userEmail']) && !empty($_POST['userPassword']) && !empty($_POST['userPassword2'])) {
    
    // On récupére les infos du formulaire et en les stockants dans des variables 

    $nom = $_POST['userSurname'];
    $prenom = $_POST['userName'];
    $email = $_POST['userEmail'];
    $mdp = $_POST['userPassword'];
    $mdp2 = $_POST['userPassword2'];
   
    //On verifie si l'adresse mail est déjà utilisé
    
    $sql = "SELECT * FROM `user` WHERE email = :email";
            $query = $db->prepare($sql);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();
            $verifEmail = $query->fetch();
        var_dump($verifEmail);

    // Si l'adresse mail n'est pas dans la bdd on rentre dans la condition sinon incorrecte
        
    if($verifEmail === false) {

        // Vérification des 2 mots de passe identiques 

        if ($mdp === $mdp2) {
            // Hachage du mot de passe
            $motdepassehash = password_hash($mdp, PASSWORD_DEFAULT);

            // Préparation de la requête
            $requete = 'INSERT INTO user (surname, name, email, password, admin) VALUES (:surname, :name, :email, :password, :admin)';

            // Création d'un objet PDOStatement
            $query = $bd->prepare($requete);

            // Association d'une valeur à un paramètre de l'objet PDOStatement
            $query->bindValue(':surname', $nom, PDO::PARAM_STR);
            $query->bindValue(':name', $prenom, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password', $motdepassehash, PDO::PARAM_STR);
            $query->bindValue(':admin', 0, PDO::PARAM_STR);

            // Exécution de la requête
            $query->execute();

            // Fermeture du curseur : la requête peut être de nouveau exécutée
            $query->closeCursor();
            
            // redirection vers la page de co 

            header("Location: pagedeco.php");

        } else {
            echo 'Les mots de passe ne correspondent pas. Veuillez réessayer.';
        }
    } else {
        echo "Adresse e-mail incorrecte";
    }
 }
 if (isset($_POST['registered'])) {
    // Redirection vers la page d'inscription
    header("Location: pagedeco.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">

<body>
    <?php 

    $title = "Inscription";
    include("head.php");
    include("header.php");
    
    ?>


<form action="" method="POST" class="sign-up">
        
        <h1 class="center-text">Formulaire d'inscription</h1>
    
        <br>

        <div>
        <label for="surname">Entrer votre nom :</label>
        <input class="formulaire" type="text" id="surname" name="userSurname">
        </div>
        
        <br>

        <div>
        <label for="name">Entrer votre prenom :</label>
        <input class="formulaire" type="text" id="name" name="userName">
        </div> 

        <br>

        <div>
        <label for="email">Entrer votre adresse email :</label>
        <input class="formulaire" type="email" name="userEmail">
        </div> 

        <br>
         
        <div>
         <label for="password">Entrer votre mot de passe :</label>
         <input class="formulaire" type="password" id="password" name="userPassword">
        </div>

        <br>
        
        <label for="password2">Entrer de nouveau votre mot de passe :</label>
        <input class="formulaire" type="password" name="userPassword2">

        <div class="space">
         <button id="sign" type="submit">Inscription </button>
        </div>
        <div>
         <button id="registered" name="registered" type="submit">Déjà inscrit </button>
        </div>
    
    
    </form> 

    <?php include("footer.php"); ?>
</body>
</html>

