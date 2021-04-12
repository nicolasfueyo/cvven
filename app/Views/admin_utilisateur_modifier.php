<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/design.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/anima.css") ?>">
    <link rel="shortcut icon" href="../img/icon.webp">
    
    <title>Admin - Modifier un utilisateur</title>
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
                <?php if(isset($validation)):?>
                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                <?php endif;?>
                <form action="<?php echo site_url('adminUtilisateurs/modifierSave/' . $util['id']) ?>" method="post">
                    <div class="mb-3">
                        <label for="InputForName" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= set_value('prenom', $util['prenom']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="InputForName" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= set_value('nom', $util['nom']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="InputForEmail" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= set_value('email', $util['email']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="InputForEmail" class="form-label">Téléphone</label>
                        <input type="tel" name="tel" class="form-control" value="<?= set_value('tel', $util['tel']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="InputForEmail" class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" value="<?= set_value('adresse', $util['adresse']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="InputForPassword" class="form-label">Mot de passe</label>
                        <input type="password" name="mdp" class="form-control" id="InputForPassword">
                    </div>
                    <div class="mb-3">
                        <label for="InputForConfPassword" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="confMdp" class="form-control" id="InputForConfPassword">
                    </div>
                    <button type="submit" class="btn btn-primary">S'enregistrer</button>
                </form>
            </div>
             
        </div>
    </div>
     
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  </body>
</html>
