<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connexionBDD.php');

// Ouverture de la session
session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<body>
    
    <?php 
    
    $title = "Présentation";
    include("head.php");
    include("header.php");

    ?>

    <div class="presentation">
        <h1> Bienvenue chez Cuisine Facile </h1>

        <p>Cuisine Facile est la plateforme idéale pour les passionnés de cuisine qui aiment partager et découvrir de délicieuses recettes. 
        Fondée le 1er décembre, notre plateforme a pour mission de rendre la cuisine accessible à tous, en favorisant le partage de connaissances culinaires 
        et en offrant une variété de recettes délicieuses, le tout gratuitement.
        </p>

        <h2>À propos de nous</h2>

        <h3>Notre vision</h3>

        <p>À Cuisine Facile, nous croyons en la puissance du partage et de l'apprentissage collectif. Notre vision est de créer une communauté dynamique où les amateurs de cuisine 
        peuvent s'inspirer mutuellement, apprendre de nouvelles techniques, et partager leurs créations culinaires avec le monde.
        </p>

        <h3>Ce que nous offrons</h3>

        <ul>
            <li><strong>Partage de Recettes :</strong> Les utilisateurs peuvent partager leurs recettes préférées avec la communauté, 
                créant ainsi une bibliothèque virtuelle de saveurs variées.</li>
            <li><strong>Accès Gratuit :</strong> Tout le contenu sur Cuisine Facile est accessible gratuitement. Notre objectif est de rendre la cuisine accessible à tous, 
                peu importe le niveau de compétence culinaire.</li>
        </ul>

        <h3>Comment ça marche</h3>

        <ol>
            <li><strong>Inscription Gratuite :</strong> Rejoignez notre communauté en vous inscrivant gratuitement sur notre site.</li>
            <li><strong>Ajout de Recettes :</strong> Partagez vos créations culinaires en ajoutant vos recettes, accompagnées de photos alléchantes.</li>
            <li><strong>Découverte Culinaire :</strong> Explorez une variété de recettes provenant de cuisiniers amateurs passionnés.</li>
        </ol>

        <h2>Rejoignez-nous dès aujourd'hui !</h2>

        <p>Cuisine Facile est plus qu'une plateforme de recettes, c'est une communauté dynamique dédiée à l'amour de la cuisine. 
        Rejoignez-nous dès aujourd'hui pour découvrir, partager et apprendre ensemble.
        </p>

        <p><strong>Cuisine Facile - Rendre la cuisine accessible à tous !</strong></p>
    </div>

    <!-- Footer -->
   <?php include("footer.php"); ?>

</body>
</html>