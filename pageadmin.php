<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('connexionBDD.php');
    include('sessionstart.php');

if (isset($_SESSION['admin']) && $_SESSION['admin'] === '1') {
?>

<!DOCTYPE html>
<html lang="fr">

<body>
    
<?php 
    
$title = "Admin";
include("head.php");
include("header.php");

    if ($db) {
        // Requête SQL pour récupérer les recettes
        $sql = "SELECT
                    r.id_recipe,
                    r.category,
                    r.title,
                    r.instruction,
                    r.preparation_time,
                    r.cooking_time,
                    GROUP_CONCAT(CONCAT(i.name_ingredient, ': ', i.value_measure, ' ', i.unite_measure) SEPARATOR ', ') AS ingredients_list
                FROM
                    recipe r
                LEFT JOIN
                    ingredient i ON r.id_recipe = i.id_recipe
                WHERE
                    r.status = 0
                GROUP BY
                    r.id_recipe";

        $query = $db->prepare($sql);
        $query->execute();

        // Vérifier si des résultats ont été retournés
        if ($query->rowCount() > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<hr>";
                echo "<div class='center-text style-recipe'>";
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p><strong>Catégorie:</strong> " . $row["category"] . "</p>";
                echo "<p><strong>Instruction:</strong> " . $row["instruction"] . "</p>";
                echo "<p><strong>Temps de préparation:</strong> " . $row["preparation_time"] . "</p>";
                echo "<p><strong>Temps de cuisson:</strong> " . $row["cooking_time"] . "</p>";
                echo "<p><strong>Ingredients:</strong> " . $row["ingredients_list"] . "</p>";
                echo "</div>";

                // Ajouter les boutons de suppression et de mise à jour du statut
                echo "<form method='post' action='' class='formAdmin'>";
                echo "<input type='hidden' name='recipe_id' value='" . $row['id_recipe'] . "'>";
                echo "<button type='submit' name='update_status'>Mettre à jour le statut</button>";
                echo "<button type='submit' name='delete_recipe' class='delete_recipe'>Supprimer</button>";       
                echo "</form>";
            }

                if (isset($_POST['delete_recipe'])) {
                    // Récupérez l'ID de la recette à supprimer depuis le formulaire
                    $recipeId = $_POST['recipe_id'];

                    // Préparez la requête de suppression
                    $delete_query = $db->prepare("DELETE FROM recipe WHERE id_recipe = ?");
                    
                    // Liez le paramètre
                    $delete_query->bindParam(1, $recipeId, PDO::PARAM_INT);

                    // Exécutez la requête
                    $delete_query->execute();

                }

                if (isset($_POST['update_status'])) {
                    // Récupérez l'ID de la recette à mettre à jour depuis le formulaire
                    $recipeId = $_POST['recipe_id'];

                    // Préparez la requête de mise à jour
                    $update_query = $db->prepare("UPDATE recipe SET status = 1 WHERE id_recipe = ?");

                    // Liez le paramètre
                    $update_query->bindParam(1, $recipeId, PDO::PARAM_INT);

                    // Exécutez la requête
                    $update_query->execute();

                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit();

                }
        } else {
            echo "<div class='center-container2'><h1 class='center-text'>Aucune recette est en attente de validation</h1></div>";
        }
    }

?>
    <?php include("footer.php"); ?>
    
</body>
</html>

<?php
} else {
    echo "<h1 class='text-center'>Vous n'avez pas encore des supers pouvoirs pour être ici :)</h1>";
}
?>