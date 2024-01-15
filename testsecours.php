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

<header class="d-flex flex-wrap align-items-center justify-content-md-between py-3 mb-4">
    <div class="col-md-3 mb-2 mb-md-0">
        <?php
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            echo "<h1 class='text-white'>Bonjour " . $_SESSION['name'] . "</h1>";
        }
        ?>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="accueil.php" class="nav-link px-2">ACCUEIL</a></li>
        <li><a href="pagepresentation.php" class="nav-link px-2">PRÉSENTATION</a></li>

        <!-- Ajout du menu déroulant pour la catégorie "Livre Recette" -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle px-2" href="pagelivrecette.php" id="bookRecipeDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                LIVRE RECETTE
            </a>
            <div class="dropdown-menu" aria-labelledby="bookRecipeDropdown">
                <a class="dropdown-item" href="pagelivrerecette.php">Toutes les recettes</a>
                <a class="dropdown-item" href="pagelivrerecetteentree.php">Entrée</a>
                <a class="dropdown-item" href="pagelivrerecetteplat.php">Plat</a>
                <a class="dropdown-item" href="pagelivrerecettedesert.php">Dessert</a>
            </div>
        </li>

        <li><a href="pagerecette.php" class="nav-link px-2">AJOUT DE RECETTE</a></li>

        <?php
        // Utilisateur est un admin, afficher l'onglet admin
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === '1') {
            echo '<li><a href="pageadmin.php" class="nav-link px-2">ADMIN</a></li>';
        }
        ?>
    </ul>

    <?php
    if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
        // Utilisateur connecté, afficher le bouton de déconnexion et son espace
        echo '<div class="disconnect col-md-3 text-end">
                <form method="post" action="" class="disconnect bg-burgundy">
                    <button type="button" class="btn btn-outline-primary me-2"><a href="pageutilisateur.php">Mon espace</a></button>
                    <button type="submit" name="disconnect" class="btn btn-outline-primary me-2">Se déconnecter</button>
                </form>
            </div>';
    } else {
        // Utilisateur non connecté, afficher les boutons de connexion et d'inscription
        echo '<div class="col-md-3 text-end">
                <button type="button" class="btn btn-outline-primary me-2"><a href="pagedeco.php">Connexion</a></button>
                <button type="button" class="btn btn-primary"><a href="pageinscription.php">Inscription</a></button>
            </div>';
    }
    ?>
</header>
