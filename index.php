<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include('res/database.php');
  session_start();
  if(!isset($_SESSION['db'])){
    $connessione = explode(",", file_get_contents('res/linfo.txt'));
    $servername = $connessione[0];
    $database   = $connessione[1];
    $username   = $connessione[2];
    $password   = $connessione[3];
    $db = new Database();
    $db->setLogInfo($servername, $database, $username, $password);
    $_SESSION['db'] = $db;
  }else{
    $db = $_SESSION['db'];
  }

  $val = 0;

  if(isset($_GET['start']) && !empty($_GET['start'])){
    $val = $_GET['start'];
    if($val < 0){
      $val = 0;
    }
  }

  if(isset($_GET['tipo']) && !empty($_GET['tipo'])){
    $nMaxAziende = $db->nAziende($_GET['tipo'])['N'];
  }else if(isset($_GET['data']) && !empty($_GET['data'])){
    $nMaxAziende = $db->nAziende("data" . $_GET['data'])['N'];
  }else{
    $nMaxAziende = $db->nAziende("no")['N'];
  }

  function loadAziende($db, $val){
    if(isset($_GET['trending']) && $_GET['trending'] == true){
      $result = $db->trendingAziende();
    }else if(isset($_GET['tipo']) && !empty($_GET['tipo'])){
      $result = $db->tipoAziende($_GET['tipo'],$val);
    }else if(isset($_GET['data']) && !empty($_GET['data'])){
      $result = $db->cercaAziende($_GET['data'],$val);
    }else if(isset($_GET['recenti']) && !empty($_GET['recenti'])){
      $result = $db->recentiAziende($val);
    }else{
      $result = $db->caricaAziende($val);
    }

    if($result)
      if ($result->num_rows > 0) {
      // output data of each row
      $i = 0;
        while($row = $result->fetch_assoc()) {
          $i++;
          if(!isset($row['backgroundimage']) || empty($row['backgroundimage']) || $row['backgroundimage'] == "20"){
            $row['backgroundimage'] = "images/background2.jpg";
          }
          $cards = $db->loadCards($row['id']);

            echo '<div class="row principale">';
            echo '<div class="card hoverable">
              <div class="card-image">
                <a class="" href="profile.php?id=' . $row['id'] . '"><img class="index-background-image" src='. $row['backgroundimage'] . ' height="400px" width="auto"></a>
              </div>
              <div class="card-content">';
              if($cards){
                if($cards->num_rows > 0)
                  echo '<a class="btn-floating waves-effect waves-light right modal-trigger" href="#modal' . $i . '"><i class="material-icons">more_vert</i></a>';
              }
                echo '<a class="card-title grey-text text-darken-4" href="profile.php?id=' . $row['id'] . '">' . $row['ragione'] .'</a>
                  <p>' . $row['card_info'] .'</p>
                </div>';
                  if($cards)
                    if ($cards->num_rows > 0) {
                      echo '<div id="modal' . $i . '" class="modal">
                        <div class="modal-content">
                          <h4>Progetti <i class="material-icons modal-action modal-close right">close</i></h4>';
                    // output data of each row
                      while($rows = $cards->fetch_assoc()) {
                          if(!isset($rows['postimage']) || empty($rows['postimage']) || $rows['postimage'] == "./upload/"){
                            $rows['postimage'] = "images/background2.jpg";
                          }
                          echo '<div class="row">
                            <div class="col s12">
                              <div class="card horizontal">
                                <div class="card-image">
                                  <img src="' . $rows['postimage'] . '" width="200px" height="auto">
                                </div>
                                <div class="card-stacked">
                                  <div class="card-content">
                                    <h5>' . $rows['nome_progetto'] . '</h5>
                                    <p>' . substr($rows['descrizione'], 0, 97) . '</p>
                                  </div>
                                  <div class="card-action">
                                    <a href="profile.php?id=' . $row['id'] . '#' . $rows['nome_progetto'] . '">' . $rows['nome_progetto'] . '</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>';
                    }
                    echo "</div>
                  </div>";
                  }

                echo '</div>';
            echo '</div>';
          }
      }else{
        echo '<div class="row principale center">';
          echo "<p class='flow-text'>Nessun risultato<p>";
        echo '</div>';
      }

  }

  function loadTipiaziende(){
    $tipiaziende = explode(";", file_get_contents('res/tipi.txt'));
    foreach ($tipiaziende as $tipo) {
      echo '<a class="collection-item tipo center-align center" title="Visualizza tutte le aziende categorizzate come ' . $tipo . '"href="?tipo=' . $tipo . '">' . $tipo .'</a>';
    }
  }

  function loadTipoDropdown(){
    $tipiaziende = explode(";", file_get_contents('res/tipi.txt'));
    foreach ($tipiaziende as $tipo) {
      echo '<li><a class="collection-item tipo center-align center" title="Visualizza tutte le aziende categorizzate come ' . $tipo . '" href="?tipo=' . $tipo . '">' . $tipo .'</a></li>';
    }
  }

  function generatePages($nMaxAziende){
    if(isset($_GET['tipo']) && !empty($_GET['tipo'])){
      $tipo = "tipo=" . $_GET['tipo'] . "&";
    }else{
      $tipo = "";
    }
    if(isset($_GET['start']) && !empty($_GET['start'])){
      if($_GET['start'] == 0){
        $val = -1;
      }else{
        $val = (($_GET['start'] / 10) - 1) * 10;
        $page = ($_GET['start'] / 10);
      }
    }else{
      $page = 0;
      $val = 0;
    }
    $nPulsanti = ceil(($nMaxAziende / 10));
    $i = 0;
    echo '<ul class="pagination">';
    if($nMaxAziende > 10){
      if($page == 0){
          echo '<li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>';
      }else
          echo '<li class="waves-effect"><a href="?' . $tipo . 'start=' . $val .'"><i class="material-icons">chevron_left</i></a></li>';
    }
    if($page > 4){
      $i = ($page - 4);
      $nPulsanti += $i;
    }
    for ($i; $i < $nPulsanti; $i++) {
      if($i == $page){
        echo '<li class="waves-effect active"><a href="?' . $tipo . 'start=' . ($i * 10) . '">' . ($i + 1) . '</a></li>';
      }else
        echo '<li class="waves-effect"><a href="?' . $tipo . 'start=' . ($i * 10) . '">' . ($i + 1) . '</a></li>';
    }

    if(isset($_GET['start']) && !empty($_GET['start'])){
      $val = (($_GET['start'] / 10) + 1) * 10;
      if($val > ($max * 10)){
        $val = $max * 10;
      }
    }
    if($nMaxAziende > 10){
      if($page == (ceil($nMaxAziende / 10)) - 1){
          echo '<li class="disabled"><a><i class="material-icons">chevron_right</i></a></li>
              </ul>';
      }else
          echo '<li class="waves-effect"><a href="?' . $tipo . 'start=' . $val .'"><i class="material-icons">chevron_right</i></a></li>
            </ul>';
    }
  }
?>


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

    <title>Home - AziendeExpo</title>

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
    <main>
      <div id="main" class="">
        <div class="row">
          <div id="options" class="col s12 m12 l3 hide-on-med-and-down">
            <ul class="collection">
              <a href="?recenti=true" title="Visualizza le aziende registrate di recente" class="collection-item center-align center">Più recenti</a>
              <a href="?trending=true" title="Visualizza le aziende più viste" class="collection-item center-align center">Tendenza</a>
              <?php loadTipiaziende(); ?>
            </ul>
          </div>
          <div class="hide-on-large-only col s12">
            <ul class="collection">
              <a href="index.php" class="collection-item center-align center">Più recenti</a>
              <a href="?trending=true" class="collection-item center-align center">Tendenza</a>
              <!-- Dropdown Trigger -->
              <a id="" class='dropdown-trigger collection-item center-align center' data-target='dropdown1'>Categorie<i class="material-icons right">arrow_drop_down</i></a>
            </ul>
            <!-- Dropdown Structure -->
            <ul id='dropdown1' class='dropdown-content'>
              <?php loadTipoDropdown() ?>
            </ul>
          </div>
          <div class="content col s12 m12 l6">
            <?php loadAziende($db, $val); ?>
          </div>
          <div id="ads" class="col s12 m12 l3">
            <ul class="collapsible hoverable">
              <li class="active center">
                <div class="collapsible-header"><i class="material-icons">lightbulb_outline</i>Pubblicizza la tua azienda</div>
                <div class="collapsible-body ">
                  <span>Rendi più visibile la tua impresa.<br> Sarai visto da tutti.<br></span>
                  <a href="ads.php" class="waves-effect center-align center btn">Pubblicizza</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="pagination center-align">
            <?php if(!isset($_GET['trending'])){ generatePages($nMaxAziende); } ?>
          </div>
        </div>
      </div>
    </main>

    <!--  Scripts-->

    <script src="js/jquery.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="js/main.js"></script>
    <?php
    if(!isset($_COOKIE['policy']))
    echo "<script>  var toastHTML = '<span>Visitando questo sito accetti l\'utilizzo dei cookie.</span><br><button class="btn-flat toast-action"><i class="large material-icons">check</i></button>';
          M.toast({html: toastHTML, completeCallback: function(){
            var data = {
              dati: 1,
            };
            if (flag == true) {
              $.post('res/cookie.php', data);
            }
          }});
    </script>";
    ?>


    <footer class="page-footer blue lighten-1">
      <div class="container">
        <div class="row center">
          <div class="col l4 s12">
            <h5 class="white-text">Locazione</h5>
            <p class="grey-text text-lighten-4">Lucca - Italia</p>
          </div>
          <div class="col l4 s12">
            <h5 class="white-text">Social</h5>
            <a href="https://facebook.com/aziende.expo" target="_blank">
              <?xml version="1.0" encoding="UTF-8"?>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" version="1.1" width="50px" height="50px">
              <g id="surface1">
              <path style=" " d="M 20 2 L 4 2 C 2.898438 2 2 2.898438 2 4 L 2 20 C 2 21.101563 2.898438 22 4 22 L 20 22 C 21.101563 22 22 21.101563 22 20 L 22 4 C 22 2.898438 21.101563 2 20 2 Z M 18.398438 7.398438 L 17 7.398438 C 16.101563 7.398438 16 7.699219 16 8.398438 L 16 9.699219 L 18.101563 9.699219 L 18 12 L 16.101563 12 L 16.101563 19 L 12.898438 19 L 12.898438 12 L 11.699219 12 L 11.699219 9.601563 L 12.898438 9.601563 L 12.898438 8.101563 C 12.898438 6.101563 13.699219 5 16 5 L 18.398438 5 Z "/>
              </g>
              </svg>
            </a>
            <a href="https://twitter.com/aziendeexpo" target="_blank">
              <?xml version="1.0" encoding="UTF-8"?>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" version="1.1" width="50px" height="50px">
              <g id="surface1">
              <path style=" " d="M 20 2 L 4 2 C 2.898438 2 2 2.898438 2 4 L 2 20 C 2 21.101563 2.898438 22 4 22 L 20 22 C 21.101563 22 22 21.101563 22 20 L 22 4 C 22 2.898438 21.101563 2 20 2 Z M 17.601563 8.800781 C 17.601563 8.898438 17.601563 9 17.601563 9.199219 C 17.601563 13 14.699219 17.398438 9.398438 17.398438 C 7.800781 17.398438 6.300781 16.898438 5 16.101563 C 5.199219 16.101563 5.5 16.101563 5.699219 16.101563 C 7 16.101563 8.300781 15.601563 9.300781 14.898438 C 8 14.898438 7 14 6.601563 12.898438 C 6.800781 12.898438 7 13 7.101563 13 C 7.398438 13 7.601563 13 7.898438 12.898438 C 6.601563 12.601563 5.601563 11.5 5.601563 10.101563 C 6 10.300781 6.398438 10.398438 6.898438 10.5 C 6.101563 9.800781 5.601563 9 5.601563 8 C 5.601563 7.5 5.699219 7 6 6.601563 C 7.398438 8.300781 9.5 9.5 11.898438 9.601563 C 11.898438 9.398438 11.800781 9.199219 11.800781 8.898438 C 11.800781 7.300781 13.101563 6 14.699219 6 C 15.5 6 16.300781 6.300781 16.800781 6.898438 C 17.5 6.800781 18.101563 6.5 18.601563 6.199219 C 18.398438 6.898438 17.898438 7.398438 17.300781 7.800781 C 17.898438 7.699219 18.398438 7.601563 19 7.300781 C 18.601563 7.898438 18.101563 8.398438 17.601563 8.800781 Z "/>
              </g>
              </svg>
            </a>
            <a href="https://instagram.com/aziendeexpo" target="_blank">
              <?xml version="1.0" encoding="UTF-8"?>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" version="1.1" width="50px" height="50px">
              <g id="surface1">
              <path style=" " d="M 8 3 C 5.238281 3 3 5.238281 3 8 L 3 16 C 3 18.761719 5.238281 21 8 21 L 16 21 C 18.761719 21 21 18.761719 21 16 L 21 8 C 21 5.238281 18.761719 3 16 3 Z M 18 5 C 18.550781 5 19 5.449219 19 6 C 19 6.550781 18.550781 7 18 7 C 17.449219 7 17 6.550781 17 6 C 17 5.449219 17.449219 5 18 5 Z M 12 7 C 14.761719 7 17 9.238281 17 12 C 17 14.761719 14.761719 17 12 17 C 9.238281 17 7 14.761719 7 12 C 7 9.238281 9.238281 7 12 7 Z M 12 9 C 10.34375 9 9 10.34375 9 12 C 9 13.65625 10.34375 15 12 15 C 13.65625 15 15 13.65625 15 12 C 15 10.34375 13.65625 9 12 9 Z "/>
              </g>
              </svg>
            </a>
          </div>
          <div class="col l4 s12">
            <h5 class="white-text">Contatti</h5>
            <p class="grey-text text-lighten-4"><a href="mailto:leonard.drici@gmail.com" class="white-text">leonard.drici@gmail.com</a></p>
            <p class="grey-text text-lighten-4"><a href="mailto:help@aziendeexpo.it" class="white-text">help@aziendeexpo.it</a></p>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
          © 2018 Copyright AziendeExpo
        </div>
      </div>
    </footer>

  </body>
  </html>
