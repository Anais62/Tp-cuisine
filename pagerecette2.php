<?php
// form_ingredient.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');

// Ouverture de la session
session_start();

// Vérifier si la session contient l'ID de la recette
if (!isset($_SESSION['id_recipe'])) {
    echo 'ID de recette non trouvé. Assurez-vous d\'avoir l\'ID de recette correct.';
    exit;
}

// Récupérer l'ID de la recette à partir de la session
$id_recipe = $_SESSION['id_recipe'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajout des ingrédients
    if (!empty($_POST['ingredient']) && !empty($_POST['Value_measure']) && !empty($_POST['measure'])) {
        $ingredient = $_POST["ingredient"];
        $value_measure = $_POST["Value_measure"];
        $measure = $_POST["measure"];

        try {
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
            //echo 'Ingrédient ajouté avec succès à la base de données';
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            //echo 'Erreur lors de l\'ajout d\'ingrédient : ' . $e->getMessage();
        }
    } else {
        //echo 'Veuillez fournir toutes les données nécessaires pour ajouter un ingrédient.';
    }
} else {
    echo '';
}


if (isset($_POST['delete'])) {
    // Récupérer les ID des tâches à supprimer depuis le tableau POST
    $tachesASupprimer = isset($_POST['ingredient']) ? $_POST['ingredient'] : array();

    // Vérifier si des tâches ont été sélectionnées
    if (!empty($tachesASupprimer)) {
        // Requête SQL pour la suppression d'une tâche par ID
        $requeteSuppression = 'DELETE FROM ingredient WHERE id_ingredient = :id_ingredient';

        // Boucle à travers les ID des tâches à supprimer
        foreach ($tachesASupprimer as $id_ingredient) {
            // Préparer la requête de suppression
            $querySuppression = $db->prepare($requeteSuppression);

            // Associer la valeur de l'ID à supprimer dans la requête
            $querySuppression->bindValue(':id_ingredient', $id_ingredient, PDO::PARAM_INT);

            // Exécuter la requête de suppression pour chaque ID
            $querySuppression->execute();

            // Fermer le curseur pour libérer les ressources
            $querySuppression->closeCursor();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<script>
        function supprimerTaches() {
            let formulaireSuppression = document.getElementById('formrecipe');
            formulaireSuppression.submit();
        }
        function redirectionAvecDelai() {
        // Ajoutez une pause de 1 secondes (3000 millisecondes) avant la redirection
        setTimeout(function() {
            alert("Recette envoyée avec succès. Merci d'attendre la validation de l'admin");
            window.location.href = 'accueil.php';
        }, 1000);
    }

    </script>
</head>
<body>
<?php 
$title = "Recette";
include("head.php");  
include("header.php");
?>

<h1>Bonjour <?php echo $_SESSION['name']; ?></h1>

<form id="formrecipe" method="POST" action="">
    <h1> Étape 2 : Ajout des ingrédients </h1>

    <div>
        <label for="ingredient">Ingrédient :</label>
        <input class="formIngredient" type="text" id="ingredient" name="ingredient">
    </div>

    <div>
        <label for="valueMeasure" class="valueMeasure">Unité de mesure :</label>
        <input class="formValueMeasure" type="number" id="Value_measure" name="Value_measure" title="Veuillez saisir uniquement des chiffres">
        <select id="measure" name="measure">
            <option value="kilo">Kilogrammes</option>
            <option value="grammes">Grammes</option>
            <option value="milligramme">Milligrammes</option>
            <option value="millilitres">Millilitres</option>
            <option value="litre">Litre</option>
            <option value="centilitre">Centilitres</option>
            <option value="cuillères à soupe">Cuillères à soupe</option>
            <option value="cuillères à café">Cuillères à café</option>
            <option value="pincee">Pincée</option>     
            <option value="unite">Unité</option>        
        </select>
    </div>

    <hr>
    
    
    <?php
    $sql = "SELECT * FROM ingredient WHERE id_recipe = :id_recipe";
    $query = $db->prepare($sql);
    $query->bindValue(':id_recipe', $id_recipe, PDO::PARAM_INT);
    $query->execute();
    ?>

    <h2>Liste des Ingrédients</h2>
    <ul>
    <?php while ($ligne = $query->fetch(PDO::FETCH_ASSOC)) : ?>
        <li>
            <input type="checkbox" name="ingredient[]" value="<?= $ligne['id_ingredient'] ?>">
            <?= $ligne['name_ingredient'] ?>: <?= $ligne['value_measure'] ?> <?= $ligne['unite_measure'] ?>
        </li>
    <?php endwhile; ?>
</ul>
    <div class="button-recipe">
        <button id="add" name="submit" type="submit">Ajouter l'ingrédient</button>
        <br>
        <br>
        <button class="red-delete" name="delete" type="submit" onclick="supprimerTaches()">Supprimer des ingredients</button>
        <br>
        <hr>
        <br>
        <button id="redirection" type="button" onclick="redirectionAvecDelai()">Envoyer la recette</button>
    </div>
    </form>
    
    
   
    

</body>
</html>