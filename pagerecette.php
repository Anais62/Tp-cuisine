<?php
// form_recette.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');

// Ouverture de la session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajout de la recette
    if (!empty($_POST['category']) && !empty($_POST['titleRecipe']) && !empty($_POST['instructionRecipe']) && !empty($_POST['preparationTime']) && !empty($_POST['cookingTime'])) {
        try {
            // Préparation de la requête pour ajouter la recette
            $requeteRecette = 'INSERT INTO recipe (category, title, instruction, preparation_time, cooking_time, id_user_recipe) VALUES (:category, :title, :instruction, :preparation_time, :cooking_time, :id_user_recipe)';
            $queryRecette = $db->prepare($requeteRecette);

            // Association d'une valeur à un paramètre de l'objet PDOStatement
            $queryRecette->bindValue(':category', $_POST['category'], PDO::PARAM_STR);
            $queryRecette->bindValue(':title', $_POST['titleRecipe'], PDO::PARAM_STR);
            $queryRecette->bindValue(':instruction', $_POST['instructionRecipe'], PDO::PARAM_STR);
            $queryRecette->bindValue(':preparation_time', $_POST['preparationTime'], PDO::PARAM_STR);
            $queryRecette->bindValue(':cooking_time', $_POST['cookingTime'], PDO::PARAM_STR);
            $queryRecette->bindValue(':id_user_recipe', $_SESSION['id'], PDO::PARAM_STR);

            // Exécution de la requête
            $queryRecette->execute();

            // Récupération de l'ID de la recette nouvellement insérée
            $id_recipe = $db->lastInsertId();

            // Stockage de l'ID de la recette dans la session
            $_SESSION['id_recipe'] = $id_recipe;

            // Redirection vers le formulaire d'ajout d'ingrédients
            header("Location:pagerecette2.php");
            exit;
        } catch (PDOException $e) {
            echo 'Erreur lors de l\'ajout de la recette : ' . $e->getMessage();
        }
    } else {
        echo 'Veuillez fournir toutes les données nécessaires pour ajouter une recette.';
    }
} else {
    echo '';
}
?>

<!DOCTYPE html>
<html lang="fr">

<?php 

$title = "Recette";
include("head.php");  
include("header.php");

?>

<body>

<?php 

if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    
    ?>
    <form id="formrecipe" method="POST" action="">
    <h1>Ajout d'une nouvelle recette - Étape 1</h1>

    <div>
        <label for="category">Veuillez choisir une categorie :</label>
        <select id="category" name="category">
            <option value="Entre">Entrée</option>
            <option value="Plat">Plat</option>
            <option value="Desert">Dessert</option>
        </select>
    </div>

    <div>
        <label for="title">Entrer le nom de votre recette :</label>
        <input class="formTitle" type="text" name="titleRecipe">
    </div>

    <div>
        <label for="instruction" class="instructionRecipe">Entrer les intructions de la recette :</label>
        <textarea class="formInstruction" id="instructionRecipe" name="instructionRecipe" rows="8" cols="40"></textarea>
    </div>

    <div>      
        <label for="instruction">Entrer le temps de préparation :</label>
        <input class="formInstruction" type="text" name="preparationTime">
    </div>

    <div>
        <label for="instruction" class="instructionCookingTime">Entrer le temps de cuisson :</label>
        <input class="formInstruction" type="text" name="cookingTime">
    </div>

    <hr>

    <div>  
        <button name="submit" type="submit">Passer à l'étape suivante</button>
    </div>
</form>

<?php
    } else {
    // Utilisateur non connecté, afficher veuilliez vous connecter
    echo "<div class='center-container2'><h1 class=center-text>Vous devez vous identifiez avec un compte pour pouvoir ajouter des recettes</h1></div>";
}

?>
    <!-- Footer -->
    <?php include("footer.php"); ?>

</body>
</html>
