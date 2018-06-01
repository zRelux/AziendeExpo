  <!DOCTYPE html>
  <html lang="it">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="robots" content="index,follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Visualizza tutte le aziende italiane e i loro prodotti, non esitare a contattare!" />
    <meta name="copyright" content="Diritti riservati ad Aziendeexpo.it" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="aziende italiane, aziende expo, aziende online, mostra la tua azienda online, mostra la tua azienda, prodotti aziende, visualizza aziende italiane, aziende italiane mostra, mostra di aziende italiane">

    <title>Team - AziendeExpo</title>

    <link rel="apple-touch-icon" sizes="76x76" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="css/stileProfilo.css" type="text/css" rel="stylesheet" media="screen,projection" />
  </head>

  <body>
    <!-- Barra di navigazione -->
    <header id="header" class="page-topbar">
      <nav class="white">
        <div class="navbar-fixed">
          <div class="nav-wrapper">
            <a href="./index.php" class="brand-logo"><img src="images/logo.PNG" alt="Logo" class="image-logo" width="150px"></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li>
                <form id="ricercaAz" method="get" action="index.php">
                  <div class="input-field">
                    <i class="black-text material-icons prefix">search</i>
                    <input id="ricercaAziende" type="text" placeholder="Cerca..." name="data" onkeydown="search(this)" ><!--onkeyup="ricerca()"-->
                  </div>
                </form>
              </li>
              <li><a href="index.php">Home</a></li>
              <li><a href="contatti.php">Team</a></li>
              <li><a href="login.php" class="waves-effect waves-teal"><i class="material-icons">add_circle</i></a></li>
              <li><a href="profile.php?find=true" class="dropdown-button waves-effect waves-teal" data-target='dropdownNav'><i class="medium material-icons">account_circle</i></a></li>
            </ul>
            <ul id='dropdownNav' class='dropdown-content'>
              <li><a href="profile.php?find=true">Profilo</a></li>
              <li><a href="info.php">Info Azienda</a></li>
              <li><a href="res/logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <ul id="mobile-demo" class="sidenav">
        <li><a href="index.php">Home</a></li>
        <li><a href="contatti.php">Team</a></li>
        <li><a href="login.php">Accedi</a></li>
        <li><a href="profile.php?find=true">Profilo</a></li>
        <li><a href="info.php">Info Azienda</a></li>
        <li><a href="res/logout.php">Logout</a></li>
      </ul>
    </header>

    <div class="container">
      <div class="team card center">
        <div class="row">
          <div class="col s12 l2">

          </div>
          <div class="col s12 l3">
              <img src="images/download.jpg" alt="developer image" class="circle responsive-img"> <!-- notice the "circle" class -->
            </div>
            <div class="col s12 l5">
              <h5>Sviluppatore e ideatore</h5>
              <p>Leonardo Drici</p>
              <p>Sviluppatore, Tester</p>
            </div>
        </div>
        <div class="row">
          <div class="divider">

          </div>
          <div class="col s12 center">
            <h4>Tecnologie principali utilizzate</h4>
          </div>
          <div class="col s12 l1">

          </div>
          <div class="col s12 l2">
              <img src="images/html.png" alt="" class="responsive-img">
          </div>
          <div class="col s12 l2">
            <img src="images/css.png" alt="" class="responsive-img">
          </div>
          <div class="col s12 l2">
            <img src="images/js.png" alt="" class="responsive-img">
          </div>
          <div class="col s12 l2">
            <img src="images/php.png" alt="" class="responsive-img">
          </div>
          <div class="col s12 l2">
            <img src="images/mysql.png" alt="" class="responsive-img">
          </div>
          <div class="col s12 l1">

          </div>

        </div>
        <br>
      </div>
    </div>
    <!--  Scripts-->
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src= "js/main.js"></script>
  </body>

  </html>
