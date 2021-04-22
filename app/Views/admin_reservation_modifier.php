<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/design.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/anima.css") ?>">
    <link rel="shortcut icon" href="../img/icon.webp">

    <title>Admin - Modifier une réservation</title>
</head>
<body>

<!-- NAVBAR -->
<?php include '_MENU_ADMIN.php' ?>

<div class="row justify-content-md-center">

    <div class="col-6">

        <br>
        <br>
        <br>

        <h1 style="color:#4d4d4d;">Modifier un utilisateur</h1>

        <br>
        <br>
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <form action="<?php echo site_url('adminReservations/modifierSave/' . $reservation['id']) ?>" method="post">

            <div class="mb-3">
                <label class="form-label">Client</label>
                <?php echo form_dropdown('utilisateur', $utilisateurs, $reservation['utilisateur_id'], ['class' => 'form-control']) ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Date d'entrée</label>
                <input type="date" name="dateEntree" class="form-control"
                       value="<?= set_value('dateEntree', $reservation['date_entree']) ?>">
                    </div>
                    <div class=" mb-3">
                <label class="form-label">Date de sortie</label>
                <input type="date" name="dateSortie" class="form-control"
                    value="<?= set_value('dateSortie', $reservation['date_sortie']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Type de logement</label>
                <?php echo form_dropdown('typeLogement', $typesLogements, $reservation['typeLogementId'], ['class' => 'form-control']) ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre de logements</label>
                <input type="number" min="1" max="10" name="nbLogements" class="form-control"
                       value="<?= set_value('nbLogements', $reservation['nbLogements']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Type de séjour</label>
                <?php echo form_dropdown('typePension', ['DEMI-PENSION' => 'DEMI-PENSION', 'PENSION COMPLETE' => 'PENSION COMPLETE'], $reservation['type_sejour'], ['class' => 'form-control']) ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Ménage inclus en fin de séjour</label>
                <?php echo form_checkbox('menageInclus', true, $reservation['menage_fin_sejour_inclus'], ['class' => 'form-control']) ?>
            </div>
            <div class="mb-3">
                <input type="submit" value="Valider" class="form-control">
            </div>


        </form>
    </div>

</div>
</div>

<!-- Popper.js first, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"></script>
</body>
</html>
