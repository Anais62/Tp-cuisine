<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');
include('sessionstart.php');

if (isset($_POST['disconnect'])) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: pagedeco.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<?php
$title = "Livre recette";
include("head.php");
include("header.php");
?>

<body>

    <div class="book">
        <h2>Livre des recettes</h2>
    </div>

    <!-- Remove the category filter form -->
    
    <?php
    
    // SQL query to retrieve recipes with status = 1
    $sql = "SELECT * FROM recipe WHERE status = 1;";
    $query = $db->query($sql);

    // Display recipes
    while ($recipe = $query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="recipe-container">
            <h2><a href="recetteparid.php?id=<?php echo $recipe['id_recipe']; ?>"><?php echo $recipe['title']; ?></a></h2>
            <p><strong>Categorie :</strong><?php echo $recipe['category']; ?></p>
            <!-- <p><strong>Instruction :</strong><br><?php echo $recipe['instruction']; ?></p> -->
            <p><strong>Temps de préparation :</strong> <?php echo $recipe['preparation_time']; ?></p>
            <p><strong>Temps de cuisson :</strong> <?php echo $recipe['cooking_time']; ?></p>
            

            <!-- Display ingredients for each recipe -->
            <?php
            $recipeId = $recipe['id_recipe'];
            $sqlIngredients = "SELECT * FROM ingredient WHERE id_recipe = :recipeId";
            $queryIngredients = $db->prepare($sqlIngredients);
            $queryIngredients->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
            $queryIngredients->execute();
            ?>
            
            

            <!-- <ul><p><strong>Ingrédients :</strong></p>
            <?php while ($ingredient = $queryIngredients->fetch(PDO::FETCH_ASSOC)) : ?>
                <li> <?php echo $ingredient['name_ingredient']; ?>: <?php echo $ingredient['value_measure']; ?> <?php echo $ingredient['unite_measure']; ?></li>
                <?php endwhile; ?>
            </ul> -->
        <?php
            // Requête pour récupérer toutes les notes associées à la recette
            $sqlRatings = "SELECT rating_value FROM rating WHERE recipe_id = :recipe_id";
            $queryRatings = $db->prepare($sqlRatings);
            $queryRatings->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);
            $queryRatings->execute();

            // Récupérer toutes les notes
            $ratings = $queryRatings->fetchAll(PDO::FETCH_COLUMN);

            // Calculer la moyenne des notes
            if (!empty($ratings)) {
                $averageRating = array_sum($ratings) / count($ratings);
                $averageRating = round($averageRating, 2); // Arrondir à 2 décimales
                echo "<p><strong>Note :</strong> $averageRating / 5</p>";
            } else {
                echo "<p>Aucune note pour le moment.</p>";
            }
        ?>
        </div>
        <?php
    }
    ?>

    <!-- Footer -->
    <?php include("footer.php"); ?>

</body>
</html>
