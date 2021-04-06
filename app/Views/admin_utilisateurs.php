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
<?php include '_MENU_ADMIN.php' ?>

<!-- HEADER -->
<header class="container-fluid">

    <div class="row align-items-center">

        <div class="col-12 col-md-10 formBlack d-flex align-items-center row">
        <!-- Liste des reservation en BDD -->
            <div class="col4">
                <h2>Liste des utilisateurs</h2>
            </div>
            <div class="col-8">
                <section>
                    <h3>Utilisateur</h3>
                    <a href="<?php echo site_url('AdminUtilisateurs/ajouter') ?>" class="btn btn-sm btn-success" style="margin: 5px;">Nouveau</a>
                    <table class="table">
                        <thead>
                        <th>Nom et prénom</th>
                        <th>Role</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php foreach ($utilisateurs as $u): ?>
                            <tr>
                                <td><?php echo $u['prenom'] . ' ' . $u['nom'] ?></td>
                                <td><?php echo $u['role'] ?></td>
                                <td><?php echo $u['tel'] ?></td>
                                <td><?php echo $u['email'] ?></td>
                                <td><?php echo $u['adresse'] ?></td>
                                <td>
                                    <!-- bouton valider et refuser une reservation -->
                                    <a href="<?php echo site_url('AdminUtilisateurs/modifier/'.$u['id']) ?>" class="btn btn-sm btn-success" style="margin: 5px;">Modifier</a>
                                    <a href="<?php echo site_url('AdminUtilisateurs/supprimer/'.$u['id']) ?>" class="btn btn-sm btn-danger">Supprimer</a>
                                </td>
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