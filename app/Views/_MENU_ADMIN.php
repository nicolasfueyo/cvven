<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <?= anchor("", '<img src="' . base_url("img/icon.webp") . '" alt="logo">CCVEN Jura', "class = 'navbar-brand'") ?>

    <!--<a class="navbar-brand" href="../index.php">
    <img src=" alt="logo">CCVEN Jura</a>
  -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Onglet navebar page admin -->

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php echo anchor("AdminUtilisateurs/liste", "Gestion utilisateurs", "class = 'nav-link'") ?>
            </li>
            <li class="nav-item">
                <?php echo anchor("AdminReservations/liste", "Gestion séjours", "class = 'nav-link'") ?>
            </li>
            <li class="nav-item">
                <?php echo anchor("Login/logout", "Déconnexion", "class = 'nav-link'") ?>
            </li>

            <!-- récupère l'username de la session pour l'afficher -->

            <li class="nav-item">
                <?php $session = session(); ?>
                <?php echo anchor("AdminPage", $session->get('user_name'), "class = 'nav-link'") ?>
            </li>

        </ul>

    </div>
</nav>