<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Site CCVEN Jura">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/design.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/anima.css") ?>">
    
    <link rel="shortcut icon" href="../img/icon.webp">
    
    <title>Page d'authentification</title>
  </head>
  <body>
    
      

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <?= anchor("",'<img src="'.base_url("img/icon.webp").'" alt="logo">',"class = 'navbar-brand'" )?>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <ul class="navbar-nav ml-auto">
          
          <li class="nav-item">
    <?php echo anchor("register","Inscription","class = 'nav-link'")?>
  </li>
          
          
  <li>     
          <div class="dropdown">
      
      
    </div>
  </li>
   
          
       
  
       </ul>
      
      
     
      
        
            </div>
    </div>
    </nav>
        
        
     
        
        <div class="row justify-content-md-center">
 
            <div class="col-6">
                <br>
                <br>
                <br>
                
                <h1 style="color:#4d4d4d;">Connexion</h1>
                
                <br>
                <br>
                <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                <?php endif;?>
                <form action="<?php echo site_url("login/auth") ?>" method="post">
                    <div class="mb-3">
                        <label for="InputForEmail" class="form-label">Adresse Email</label>
                        <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="InputForPassword" class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="InputForPassword">
                    </div>
                    <button type="submit" class="btn btn-primary">S'authentifier</button>
                </form>
            </div>
             
        </div>
    </div>
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  </body>
</html>