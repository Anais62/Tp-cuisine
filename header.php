<?php 
include ('sessionstart.php'); 

if (isset($_POST['disconnect'])) {
    // L'utilisateur a cliqué sur le bouton de déconnexion
    // Effectuez les actions de déconnexion nécessaires
    $_SESSION['logged'] = false;

    // Redirigez vers la page d'accueil
    header("Location: accueil.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <?php
    if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            echo "<h1 class='text-white'>Bonjour " . $_SESSION['name'] . "</h1>";
        }
        ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="accueil.php">ACCUEIL</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pagepresentation.php">PRÉSENTATION</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pagerecette.php">AJOUT DE RECETTE</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            LIVRE DE RECETTE
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="pagelivrerecette.php">Toutes les recettes</a></li>
            <li><a class="dropdown-item" href="pagelivrerecetteentree.php">Entrée</a></li>
            <li><a class="dropdown-item" href="pagelivrerecetteplat.php">Plat</a></li>
            <li><a class="dropdown-item" href="pagelivrerecettedesert.php">Desert</a></li>
          </ul>
        <?php
            // Utilisateur est un admin, afficher l'onglet admin
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === '1') {
                echo '<li class="nav-item dropdown">
                    <a href="pageadmin.php" class="nav-link">ADMIN</a></li>';
            }
        ?>
        </li>
        <?php
          if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
              // Utilisateur connecté, afficher le bouton de déconnexion et son espace
              echo '<div class="disconnect">
                      <form method="post" action="" class="disconnect bg-burgundy">
                          <button type="button" class="btn btn-outline-primary me-2"><a href="pageutilisateur.php">Mon espace</a></button>
                          <button type="submit" name="disconnect" class="btn btn-outline-primary me-2">Se déconnecter</button>
                      </form>
                  </div>';
          } else {
              // Utilisateur non connecté, afficher les boutons de connexion et d'inscription
              echo '<div class="">
                      <button type="button" class="btn btn-outline-primary me-2"><a href="pagedeco.php">Connexion</a></button>
                      <button type="button" class="btn btn-primary"><a href="pageinscription.php">Inscription</a></button>
                  </div>';
          }
        ?>
      </ul>
    </div>
  </div>
</nav>
