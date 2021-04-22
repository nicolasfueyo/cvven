<?php
helper('html');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <?= anchor("Dashboard", '<img src="' . base_url("img/icon.webp") . '" alt="logo">', "class = 'navbar-brand'") ?>

        <!--<a class="navbar-brand" href="../index.php">
        <img src=" alt="logo">CCVEN Jura</a>
      -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="navbar-nav ml-auto">

            <li class="nav-item">
                <?php echo anchor("reservation/mesReservations", "Mes réservation", "class = 'nav-link'") ?>
            </li>


            <li class="nav-item">
                <?php echo anchor("reservation", "Réservation", "class = 'nav-link'") ?>
            </li>


            <li>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="true" aria-expanded="false" src=("img/icon.webp")>
                        <?php echo img('img/user.png', false, ['style'=>'width:18px']) ?>
                    </a> <!-- lien -->

                    <div class="dropdown-menu">  <?php $session = session(); ?>

                        <!-- session pour récuperer le username du client connecté -->

                        <?php echo anchor("Moncompte/changermdpget", $session->get('user_name'), "class = 'dropdown-item'") ?>
                        <?php echo anchor("Login/logout", "Déconnexion", "class = 'dropdown-item'") ?>


                    </div>
                </div>
            </li>


        </ul>


    </div>
    </div>
</nav>
