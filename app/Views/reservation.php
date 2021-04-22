<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Site CCVEN Jura">

    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/design.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/anima.css") ?>">

    <link rel="shortcut icon" href="../img/icon.webp">

    <title>Site CVVEN - Profil</title>
</head>
<body id="haut">

<!-- NAVBAR -->
<?php include '_MENU_CLIENT.php'?>

<!-- HEADER -->
<header class="container-fluid">

    <div class="row align-items-center">

        <div class="col-12 col-md-10 formBlack d-flex align-items-center">

            <div>
                <h2>Réservez votre séjour</h2>

            </div>
            <div class="col-12 col-md-6">
                <h3>
                    <?php if(isset($validation)):?>
                        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                    <?php endif;?>
                </h3>
                Formulaire ICI
                <?php echo form_open('reservation/post') ?>
                    <div class="mb-3">
                        <label class="form-label">Date d'entrée</label>
                        <input type="date" name="dateEntree" class="form-control" value="<?= set_value('dateEntree', $reservation['dateEntree']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de sortie</label>
                        <input type="date" name="dateSortie" class="form-control" value="<?= set_value('dateSortie', $reservation['dateSortie']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type de logement</label>
                        <?php echo form_dropdown('typeLogementId', $typesLogements, $reservation['typeLogementId'], ['class'=>'form-control']) ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de logements</label>
                        <input type="number" min="1" max="10" name="nbLogements" class="form-control" value="<?= set_value('nbLogements', $reservation['nbLogements']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"></label>
                        <?php echo form_dropdown('typePension', ['DEMI-PENSION' => 'DEMI-PENSION', 'PENSION COMPLETE' => 'PENSION COMPLETE'], $reservation['typePension'], ['class' => 'form-control']) ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ménage inclus en fin de séjour</label>
                        <?php echo form_checkbox('menageInclus', true, $reservation['menageInclus'], ['class' => 'form-control']) ?>
                    </div>
                <?php
                    $session = session();
                    if( $session->has('prix_total') ){
                        $titreBouton = "Réserver au prix de : " . $session->getFlashdata('prix_total');
                    }else{
                        $titreBouton = "Afficher le prix";
                    }

                ?>
                    <div class="mb-3">
                        <input type="submit" value="<?php echo $titreBouton ?>" class="form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>


<br/>
<br/>
<br/>
<br/>
<br/>



<footer class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 text-center">

            <p>© CVVEN Jura</p>


        </div>
    </div>
</footer>



<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



</body>
</html>