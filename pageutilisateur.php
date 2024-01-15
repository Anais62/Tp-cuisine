<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');
include('sessionstart.php');

$id = $_SESSION['id'];
$prenom = $_SESSION["name"];

if (isset($_POST['disconnect'])) {
    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion
    header("Location: pagedeco.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<body>
<?php 

    $title = $_SESSION["name"];
    include("head.php");  
    include("header.php");
    
?>
    <div class="book">
        <h2>Vos recettes en attente de validation par un admin :</h2>
    </div>

    <?php
    
    // Requête SQL pour récupérer les détails de la recette en fonction de l'ID
    $sql = "SELECT * FROM recipe WHERE id_user_recipe = :id_user_recipe AND status = 0";
    $query = $db->prepare($sql);
    $query->bindValue(':id_user_recipe', $id, PDO::PARAM_INT);
    $query->execute();
    
    // Vérifier si l'utilisateur a ajouté des recettes
    if ($query->rowCount() > 0) {
        while ($recipe = $query->fetch(PDO::FETCH_ASSOC)) {
            // Récupérer les détails de la recette
            $title = $recipe['title'];
            $category = $recipe['category'];
            $preparationTime = $recipe['preparation_time'];
            $cookingTime = $recipe['cooking_time'];
            $instruction = $recipe['instruction'];

            // Afficher les détails de la recette
            echo "<div class='recipe-container'>";
            echo "<h2>{$title}</h2>";
            echo "<p><strong>Catégorie :</strong> {$category}</p>";
            echo "<p><strong>Temps de préparation :</strong> {$preparationTime}</p>";
            echo "<p><strong>Temps de cuisson :</strong> {$cookingTime}</p>";
            echo "<p><strong>Instruction :</strong> {$instruction}</p>";
            echo "</div>";
        }
    } else {
        echo "<h1>Vous n'avez aucune recette en attente de validation</h1>";
    }
    ?>
    
    <div class="book">
        <h2>Vos recettes ajouter sur le site :</h2>
    </div>
    
    <?php
    
    // Requête SQL pour récupérer les détails de la recette en fonction de l'ID
    $sql = "SELECT * FROM recipe WHERE id_user_recipe = :id_user_recipe AND status = 1";
    $query = $db->prepare($sql);
    $query->bindValue(':id_user_recipe', $id, PDO::PARAM_INT);
    $query->execute();
    
    // Vérifier si l'utilisateur a ajouté des recettes
    if ($query->rowCount() > 0) {
        while ($recipe = $query->fetch(PDO::FETCH_ASSOC)) {
            // Récupérer les détails de la recette
            $title = $recipe['title'];
            $category = $recipe['category'];
            $preparationTime = $recipe['preparation_time'];
            $cookingTime = $recipe['cooking_time'];
            $instruction = $recipe['instruction'];

            // Afficher les détails de la recette
            echo "<div class='recipe-container'>";
            echo "<h2>{$title}</h2>";
            echo "<p><strong>Catégorie :</strong> {$category}</p>";
            echo "<p><strong>Temps de préparation :</strong> {$preparationTime}</p>";
            echo "<p><strong>Temps de cuisson :</strong> {$cookingTime}</p>";
            echo "<p><strong>Instruction :</strong> {$instruction}</p>";
            echo "</div>";
        }
    } else {
        echo "<h1>Vous n'avez pas encore ajouté de recettes sur le site.</h1>";
    }
    ?>
    

    

    <?php include("footer.php"); ?>
    
</body>
</html>
