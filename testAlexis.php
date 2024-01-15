<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');
include('sessionstart.php');

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

<?php
$title = "Livre recette";
include("head.php");
include("header.php");
?>

<body>

    <div class="book">
        <h2>Livre des recettes</h2>
    </div>

    <form action="" method="post">
        <div class="mb-3">
            <label for="categoryRecipe" class="form-label">Choisir la catégorie</label>
            <select class="form-select" id="categoryRecipe" name="categoryRecipe">
                <option value="all-recipe">Toutes les recettes</option>
                <option value="entre-recipe">Entrée</option>
                <option value="plat-recipe">Plat</option>
                <option value="desert-recipe">Desert</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrer</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération de la catégorie sélectionnée
            $selectCategory = isset($_POST['categoryRecipe']) ? $_POST['categoryRecipe'] : '';

            // Construire la requête en fonction de la catégorie sélectionnée
            if ($selectCategory === 'entre-recipe') {
                $sql = "SELECT * FROM recipe WHERE status = 1 AND category ='entre' ";
            } elseif ($selectCategory === 'plat-recipe') {
                $sql = "SELECT * FROM recipe WHERE status = 1 AND category ='plat' ";
            } elseif ($selectCategory === 'desert-recipe') {
                $sql = "SELECT * FROM recipe WHERE status = 1 AND category ='desert' ";
            } else {
                // Aucune catégorie spécifique sélectionnée, afficher toutes les recettes
                $sql = "SELECT * FROM recipe WHERE status = 1";
            }

            // Exécuter la requête SQL
            $query = $db->query($sql);

            // Afficher les recettes en fonction de la requête
            while ($recipe = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="recipe-container">
                    <h2><a href="testAlexis2.php?id=<?php echo $recipe['id_recipe']; ?>"><?php echo $recipe['title']; ?></a></h2>
                    <p><strong>Categorie :</strong><?php echo $recipe['category']; ?></p>
                    <!-- <p><strong>Instruction :</strong><br><?php echo $recipe['instruction']; ?></p> -->
                    <p><strong>Temps de préparation :</strong> <?php echo $recipe['preparation_time']; ?></p>
                    <p><strong>Temps de cuisson :</strong> <?php echo $recipe['cooking_time']; ?></p>

                    <!-- Afficher les ingrédients de chaque recette -->
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

                </div>
            <?php
            }
        } else {

            $sql = "SELECT * FROM recipe WHERE status = 1";
            $query = $db->query($sql);
            while ($recipe = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="recipe-container">
                    <h2><a href="testAlexis2.php?id=<?php echo $recipe['id_recipe']; ?>"><?php echo $recipe['title']; ?></a></h2>
                    <p><strong>Categorie :</strong><?php echo $recipe['category']; ?></p>
                    <!-- <p><strong>Instruction :</strong><br><?php echo $recipe['instruction']; ?></p> -->
                    <p><strong>Temps de préparation :</strong> <?php echo $recipe['preparation_time']; ?></p>
                    <p><strong>Temps de cuisson :</strong> <?php echo $recipe['cooking_time']; ?></p>

                    <!-- Afficher les ingrédients de chaque recette -->
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

                </div>
            <?php
            }
        }
    ?>


    <!-- Footer -->
    <?php include("footer.php"); ?>

</body>
</html>