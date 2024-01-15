<?php
// form_ingredient.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');

// Vérifier si la requête est une requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pour les ingrédients
    if (!empty($_POST['ingredient']) && !empty($_POST['Value_measure']) && !empty($_POST['measure'])) {
        $ingredient = $_POST["ingredient"];
        $value_measure = $_POST["Value_measure"];
        $measure = $_POST["measure"];
             
        try {
            // Récupération de l'ID de la recette nouvellement insérée
            $id_recipe = $db->lastInsertId();       

            // Préparation de la requête pour les ingrédients
            $requeteIngredient = 'INSERT INTO ingredient (name_ingredient, value_measure, unite_measure, id_recipe) VALUES (:NameIngredient, :ValueMeasure, :Measure, :id_recipe)';
            $queryIngredient = $db->prepare($requeteIngredient);
            $queryIngredient->bindValue(':NameIngredient', $ingredient, PDO::PARAM_STR);
            $queryIngredient->bindValue(':ValueMeasure', $value_measure, PDO::PARAM_STR);
            $queryIngredient->bindValue(':Measure', $measure, PDO::PARAM_STR);
            $queryIngredient->bindValue(':id_recipe', $id_recipe, PDO::PARAM_INT);
            
            // Exécution de la requête pour les ingrédients
            $queryIngredient->execute();

            // Répondre au client
            echo 'Ingrédient ajouté avec succès à la base de données';
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            echo 'Erreur lors de l\'ajout : ' . $e->getMessage();
        }
    } else {
        // Gérer le cas où des données sont manquantes
        echo 'Veuillez fournir toutes les données nécessaires pour ajouter un ingrédient.';
    }
} else {
    // Gérer le cas où la requête n'est pas une requête POST
    echo 'Cette page ne peut être accédée qu\'en utilisant une requête POST.';
}

// Récupérer la liste des ingrédients depuis la base de données
$requeteListeIngredients = 'SELECT name_ingredient, value_measure, unite_measure FROM ingredient WHERE id_recipe = :id_recipe';
$queryListeIngredients = $db->prepare($requeteListeIngredients);
$queryListeIngredients->bindValue(':id_recipe', $id_recipe, PDO::PARAM_INT);
$queryListeIngredients->execute();
$listeIngredients = $queryListeIngredients->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<body>
    <h1>Liste des Ingrédients</h1>

    <ul>
        <?php foreach ($listeIngredients as $ingredient) : ?>
            <li><?= $ingredient['name_ingredient'] ?>: <?= $ingredient['value_measure'] ?> <?= $ingredient['unite_measure'] ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Ajoutez ici le formulaire pour ajouter de nouveaux ingrédients -->
</body>

</html>




