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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <?= anchor("Dashboard",'<img src="'.base_url("img/icon.webp").'" alt="logo">',"class = 'navbar-brand'")?>

        <!--<a class="navbar-brand" href="../index.php">
        <img src=" alt="logo">CCVEN Jura</a>
      -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="navbar-nav ml-auto">

            <li class="nav-item">
                <?php echo anchor("reservation","Réservation","class = 'nav-link'")?>
            </li>


            <li>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" src=("img/icon.webp")>
                        <img src="../../img/user.png" style="width:18px;">

                    </a> <!-- lien -->
                    <div class="dropdown-menu">  <?php $session = session();?>

                        <?php echo anchor("Dashboard/dash", $session->get('user_name'), "class = 'dropdown-item'")?>
                        <?php echo anchor("Login/logout","Déconnexion","class = 'dropdown-item'")?>


                    </div>
                </div>
            </li>




        </ul>





    </div>
    </div>
</nav>

<!-- HEADER -->
<header class="container-fluid">

    <div class="row align-items-center">

        <div class="col-12 col-md-10 formBlack d-flex align-items-center">

            <div>
                <h2><?php echo $titre ?></h2>

            </div>
            <div class="col-12 col-md-6">
                <?php echo $message ?>
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