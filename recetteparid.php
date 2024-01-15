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

// Inclure le fichier head et header

$title ="Recette";
include("head.php");
include("header.php");

// Vérifier si l'ID de la recette est passé dans l'URL
if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];

    // Requête SQL pour récupérer les détails de la recette en fonction de l'ID
    $sql = "SELECT * FROM recipe WHERE id_recipe = :recipeId AND status = 1";
    $query = $db->prepare($sql);
    $query->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
    $query->execute();

    // Vérifier si la recette existe
    if ($recipe = $query->fetch(PDO::FETCH_ASSOC)) {
        // Récupérer les détails de la recette
        $title = $recipe['title'];
        $category = $recipe['category'];
        $preparationTime = $recipe['preparation_time'];
        $cookingTime = $recipe['cooking_time'];
        $instruction = $recipe['instruction'];

        // Requête pour récupérer les ingrédients de la recette
        $sqlIngredients = "SELECT * FROM ingredient WHERE id_recipe = :recipeId";
        $queryIngredients = $db->prepare($sqlIngredients);
        $queryIngredients->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
        $queryIngredients->execute();

        ?>
        <!-- Contenu de la page recette -->
        <div class="recipe-container">
            <h1 class="center-text"><?php echo $title; ?></h1>
            <p><strong>Catégorie :</strong> <?php echo $category; ?></p>
            <p><strong>Instruction :</strong> <?php echo $instruction; ?></p>
            <p><strong>Temps de préparation :</strong> <?php echo $preparationTime; ?></p>
            <p><strong>Temps de cuisson :</strong> <?php echo $cookingTime; ?></p>

            <!-- Afficher les ingrédients de la recette -->
            <h2>Ingrédients :</h2>
            <ul>
                <?php while ($ingredient = $queryIngredients->fetch(PDO::FETCH_ASSOC)) : ?>
                    <li><?php echo "{$ingredient['name_ingredient']}: {$ingredient['value_measure']} {$ingredient['unite_measure']}"; ?></li>
                <?php endwhile; ?>
            </ul>

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
                echo "<p><strong>Moyenne des notes :</strong> $averageRating / 5</p>";
            } else {
                echo "<p>Aucune note pour le moment.</p>";
            }

       // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            // Vérifier si l'utilisateur a déjà noté cette recette
            $user_id = $_SESSION['id'];
            $existing_rating_sql = "SELECT * FROM rating WHERE user_id = :user_id AND recipe_id = :recipe_id";
            $existing_rating_query = $db->prepare($existing_rating_sql);
            $existing_rating_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $existing_rating_query->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
            $existing_rating_query->execute();

            if ($existing_rating_query->rowCount() > 0) {
                echo "Vous avez déjà noté cette recette.";
            } else {
                // Afficher le formulaire de notation
                ?>
                <!-- Formulaire de notation -->
                <form id="ratingForm" action="" method="post">
                    <label for="rating">Note (de 1 à 5) :</label>
                    <input type="number" name="rating" min="1" max="5" required>
                    <input type="hidden" name="recipe_id" value="<?php echo $recipeId; ?>">
                    <button type="submit">Noter</button>
                </form>
                <?php

                // Vérifier si le formulaire a été soumis
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Récupération des données du formulaire
                    $rating = $_POST['rating'];
                    $recipe_id = $_POST['recipe_id'];

                    // Vérifier à nouveau si l'utilisateur a voté pendant le traitement du formulaire
                    $existing_rating_query->execute();

                    if ($existing_rating_query->rowCount() > 0) {
                        echo "Vous avez déjà noté cette recette.";
                    } else {
                        // Insérer la nouvelle note dans la table rating
                        $insert_rating_sql = "INSERT INTO rating (user_id, recipe_id, rating_value, timestamp) VALUES (:user_id, :recipe_id, :rating, CURRENT_TIMESTAMP)";
                        $insert_rating_query = $db->prepare($insert_rating_sql);
                        $insert_rating_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        $insert_rating_query->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
                        $insert_rating_query->bindParam(':rating', $rating, PDO::PARAM_INT);

                        if ($insert_rating_query->execute()) {
                            echo "Note ajoutée avec succès.";
                        } else {
                            echo "Erreur lors de l'ajout de la note : " . $insert_rating_query->errorInfo()[2];
                        }
                    }
                }
            }
        } else {
            echo "Vous devez être connecté pour noter la recette.";
        }
        echo "</div>";

        // Fermer la connexion à la base de données
        $db = null;
    }
}

// Inclure le fichier footer
include("footer.php");

?>