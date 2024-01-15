<footer class="py-3 bg-burgundy footer">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="accueil.php" class="nav-link px-2 text-white">ACCUEIL</a></li>
      <li class="nav-item"><a href="pagepresentation.php" class="nav-link px-2 text-white">PRÉSENTATION</a></li>
      <li class="nav-item"><a href="pagerecette.php" class="nav-link px-2 text-white">AJOUT DE RECETTE</a></li>
      <li><a href="pagelivrerecette.php" class="nav-link px-2">LIVRE RECETTE</a></li>
      <?php
          if (isset($_SESSION['admin']) && $_SESSION['admin'] === '1') {
            echo '<li><a href="pageadmin.php" class="nav-link px-2">ADMIN</a></li>';
        }
      ?>
    </ul>
    <p class="text-center text-white">&copy; 2023 Company, Anais & Alexis</p>
  </footer>