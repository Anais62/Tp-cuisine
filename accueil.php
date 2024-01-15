<!-- Fichier pour démarer la session -->
<?php 
include ('sessionsstart.php');
include('connexionBDD.php');
?>

<!DOCTYPE html>
<html lang="fr">
  
<?php

  $title = "Accueil";
  include("head.php");

  

?>  

<body>
  
    <!-- Lien vers le fichier header -->
    <?php include("header.php"); ?>
    
 

  <div class="welcome">
    <h3>Bienvenue chez Cuisine Facile,
    Cuisine Facile est la plateforme idéale pour les passionnés de cuisine qui aiment partager et découvrir de délicieuses recettes. Fondée le 1er décembre, notre plateforme a pour mission de rendre la cuisine accessible à tous, en favorisant le partage de connaissances culinaires et en offrant une variété de recettes délicieuses, le tout gratuitement.</h3>
  </div>
    
    
    <h1 class="trend">Tendance actuelle :</h1> 
    <br> 
    
    <div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/dinde.webp" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/reussir.webp" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/buche.webp" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="latestaddition">
  <h1>Derniers ajouts :</h1> 

  <?php
    // Requête SQL pour récupérer les 10 dernières recettes ajoutées avec le statut 1
    $sqlDerniersAjouts = "SELECT id_recipe, title FROM recipe WHERE status = 1 ORDER BY date_added DESC LIMIT 10";
    $queryDerniersAjouts = $db->query($sqlDerniersAjouts);

    while ($recette = $queryDerniersAjouts->fetch(PDO::FETCH_ASSOC)) {
      $recipeId = $recette['id_recipe'];
      $recipeTitle = $recette['title'];

       echo "<li><a href='recetteparid.php?id=$recipeId'>$recipeTitle</a></li>";
                }
            ?>

</div>
  
<!-- Footer -->
   <?php include("footer.php"); ?>

</body>
</html>
