<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Site CCVEN Jura">

    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/design-admin.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/anima.css") ?>">

    <link rel="shortcut icon" href="img/icon.webp">

    <title>Page Admin</title>
</head>
<body id="haut">

<!-- NAVBAR -->
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
                <?php echo anchor("##", "Gestion utilisateurs", "class = 'nav-link'") ?>
            </li>
            <li class="nav-item">
                <?php echo anchor("##", "Gestion séjours", "class = 'nav-link'") ?>
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

<!-- HEADER -->
<header class="container-fluid">

    <div class="row align-items-center">

        <div class="col-12 col-md-10 formBlack d-flex align-items-center row">
    # Liste des reservation en BDD
            <div class="col4">
                <h2>Liste des réservations</h2>

            </div>
            <div class="col-8">
                <section>
                    <h3>Réservations non validées</h3>
                    <table class="table">
                        <thead>
                        <th>Nom et prénom</th>
                        <th>Date entrée</th>
                        <th>Date sortie</th>
                        <th>Type de logement</th>
                        <th>Quantité</th>
                        <th>Type de séjour</th>
                        <th>Ménage</th>
                        <th>Prix total</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php foreach ($reservationsNonValidees as $r): ?>
                            <tr>
                                <td><?php echo $r['prenom'] . ' ' . $r['nom'] ?></td>
                                <td><?php echo $r['date_entree'] ?></td>
                                <td><?php echo $r['date_sortie'] ?></td>
                                <td><?php echo $r['tl_nom'] ?></td>
                                <td><?php echo $r['quantite'] ?></td>
                                <td><?php echo $r['type_sejour'] ?></td>
                                <td><?php echo $r['menage_fin_sejour_inclus'] ?></td>
                                <td><?php echo $r['prix_total'] ?></td>
                                <td>
                                    <!-- bouton valider et refuser une reservation -->
                                    <a href="<?php echo site_url('AdminReservations/valider/'.$r['id']) ?>" class="btn btn-sm btn-success" style="margin: 5px;">Valider</a>
                                    <a href="<?php echo site_url('AdminReservations/refuser/'.$r['id']) ?>" class="btn btn-sm btn-danger">Refuser</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

                <section>
                    <h3>Réservations validées</h3>
                    <table class="table">
                        <thead>
                        <th>Nom et prénom</th>
                        <th>Date entrée</th>
                        <th>Date sortie</th>
                        <th>Type de logement</th>
                        <th>Quantité</th>
                        <th>Type de séjour</th>
                        <th>Ménage</th>
                        <th>Prix total</th>
                        </thead>
                        <tbody>
                        <?php foreach ($reservationsValidees as $r): ?>
                            <tr>
                                <td><?php echo $r['prenom'] . ' ' . $r['nom'] ?></td>
                                <td><?php echo $r['date_entree'] ?></td>
                                <td><?php echo $r['date_sortie'] ?></td>
                                <td><?php echo $r['tl_nom'] ?></td>
                                <td><?php echo $r['quantite'] ?></td>
                                <td><?php echo $r['type_sejour'] ?></td>
                                <td><?php echo $r['menage_fin_sejour_inclus'] ?></td>
                                <td><?php echo $r['prix_total'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

            </div>
        </div>
    </div>
</header>


<footer class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 text-center">

            <p>© CCVEN Jura</p>


        </div>
    </div>
</footer>


<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>


</body>
</html>