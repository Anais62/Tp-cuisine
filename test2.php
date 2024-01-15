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

        // Requête pour récupérer la note moyenne de la recette
        $sqlRating = "SELECT AVG(average) AS average FROM rating WHERE id_recipe = :recipeId";
        $queryRating = $db->prepare($sqlRating);
        $queryRating->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
        $queryRating->execute();

        // Récupérer la note moyenne de la recette
        $recipeAverageRating = $queryRating->fetchColumn();

        // Requête pour récupérer le nombre de notes de la recette
        $sqlNbRating = "SELECT COUNT(*) AS nb_rating FROM rating WHERE id_recipe = :recipeId";
        $queryNbRating = $db->prepare($sqlNbRating);
        $queryNbRating->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
        $queryNbRating->execute();

        // Récupérer le nombre de notes de la recette
        $recipeNbRating = $queryNbRating->fetchColumn();

        // Si le formulaire de notation est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
            $userRating = $_POST['rating'];

            // Ajouter ici la logique pour mettre à jour la base de données avec la nouvelle note
            // Assurez-vous d'ajuster la structure de votre table rating en conséquence

            // Exemple : Ajout d'une nouvelle note
            $sqlInsertRating = "INSERT INTO rating (id_recipe, average, nb_rating) VALUES (:recipeId, :userRating, 1)";
            $queryInsertRating = $db->prepare($sqlInsertRating);
            $queryInsertRating->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
            $queryInsertRating->bindValue(':userRating', $userRating, PDO::PARAM_INT);
            $queryInsertRating->execute();

            // Rediriger pour éviter la soumission multiple du formulaire
            header("Location: {$_SERVER['PHP_SELF']}?id=$recipeId");
            exit;
        }

        // Inclure le fichier head et header
        include("head.php");
        include("header.php");
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

            <!-- Section de notation en étoiles -->
            <h2>Notes :</h2>
            <?php if ($recipeAverageRating !== false) : ?>
                <p>Note moyenne : <?php echo number_format($recipeAverageRating, 1); ?></p>
            <?php endif; ?>

            <?php if ($recipeNbRating !== false) : ?>
                <p>Nombre de notes : <?php echo $recipeNbRating; ?></p>
            <?php endif; ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $recipeId; ?>" method="post">
                <p>Votre note :</p>
                <select name="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <input type="submit" value="Noter">
            </form>
        </div>

        <?php
        // Inclure le fichier footer
        include("footer.php");

        // Terminer le script
        exit;
    }
}

// Si l'ID de recette n'est pas défini ou la recette n'existe pas, rediriger vers une page d'erreur par exemple
header("Location: page_erreur.php");
exit;
?>
