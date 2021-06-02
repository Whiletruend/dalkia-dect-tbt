<!DOCTYPE HTML>
<html lang='fr'>
    <head>
        <!-- Base -->
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Dalkia - Gestion DECT & TBT</title>


        <!-- Adding Libraries -->
        <link href='resources/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css'>
        <script src="https://code.jquery.com/jquery.js"></script>
        <script type="text/javascript" src="resources/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">


        <!-- Adding Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <img src="resources/img/dalkia-logo.png" style='width: 2.5%;'>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <div class='p-2'></div> <!-- Spacer -->

                <!-- Base buttons -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $this->currentPage == 'index' ? 'active' : '' ?>" aria-current="page" href=".">Accueil</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $this->currentPage == 'dect_global' ? 'active' : '' ?>" aria-current="page" href="./?action=dect_global">Gestion DECT</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $this->currentPage == 'tbt' ? 'active' : '' ?>" aria-current="page" href="./?action=tbt">Gestion TBT</a>
                    </li>

                    <li class='nav-item'>
                        <a class="nav-link <?= ($this->currentPage == 'users_global' or $this->currentPage == 'users_create') ? 'active' : '' ?>" aria-current="page" href="./?action=users_global">Gestion des Utilisateurs</a>
                    </li>
                </ul>
            </div>
        </nav>
    </head>
</html>