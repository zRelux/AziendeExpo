<?php
  include('res/database.php');
  session_start();

  if(!isset($_COOKIE['info'])){
      setcookie('info', true, time() + (60*60*24*30));
  }

  $db = $_SESSION['db'];

  if(!isset($db) || empty($db) || !isset($_SESSION['user']) || empty($_SESSION['user']) || !isset($_SESSION['password']) || empty($_SESSION['password']) || $db->checkLogin($_SESSION['user'], $_SESSION['password']) != true){
    header("Location: login.php");
  }

  $result = $db->findByUser($_SESSION['user']);


  function loadTipiaziende(){
    $tipiaziende = explode(";", file_get_contents('res/tipi.txt'));
    echo "<ul id='dropdown1' class='dropdown-content'>";
    $i = 0;
    foreach ($tipiaziende as $tipo) {
      $i++;
      echo '<option value="' . $tipo . '">' . $tipo .'</option>';
    }
    echo "</ul>";
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="robots" content="index,follow" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Inserisci tutti dati relative alla tua azienda! Permetterai a tutti di vederla!" />
  <meta name="copyright" content="Diritti riservati ad AziendeExpo.it" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="aziende italiane, aziende expo, aziende online, mostra la tua azienda online, mostra la tua azienda, prodotti aziende, visualizza aziende italiane, aziende italiane mostra, mostra di aziende italiane">
  <title>Informazioni azienda</title>

  <link rel="apple-touch-icon" sizes="76x76" href="images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
  <link rel="manifest" href="images/site.webmanifest">
  <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.min.css" rel="stylesheet">
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
    <div class="container">
      <div class="row">
        <h1 class="center-align">Indicizzazione azienda</h1>
        <div class="indicizzazione">
          <form class="col s12" action="res/save.php" method="post">
            <div class="row">
              <div class="input-field col s12">
                <input id="nome_azienda" type="text" name="ragione" class="validate" value="<?php echo $result['ragione'] ?>">
                <label for="first_name">Nome azienda</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="sitoweb" type="text" name="sitoweb" class="validate" value="<?php echo $result['sitoweb'] ?>">
                <label for="sitoweb">Sitoweb</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <input id="email" type="email" name="email" class="validate" value="<?php echo $result['email'] ?>">
                <label for="email">Email</label>
              </div>
              <div class="input-field col s6">
                <input id="phone" name="telefono" type="text" class="validate" value="<?php echo $result['telefono'] ?>">
                <label for="phone">Telefono</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="desc_azienda" type="text" name="card_info" class="validate" value="<?php echo $result['card_info'] ?>">
                <label for="desc_azienda">Brevi informazioni relative all'azienda</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <select name="tipoazienda">
                  <option value="" disabled selected>Scegli la tipologia di azienda</option>
                  <?php loadTipiaziende(); ?>
                </select>
                <label>Tipologia Azienda</label>
              </div>
            </div>
            <div class="row center">
              <div class="input-field col s12">
                <button class="btn waves-effect waves-light center-align" type="submit" name="action">Aggiorna
                  <i class="material-icons right">send</i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script src="js/jquery.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/main.js"></script>
  <footer class="page-footer blue lighten-1">
    <div class="container">
      <div class="row center">
        <div class="col l4 s12">
          <h5 class="white-text">Locazione</h5>
          <p class="grey-text text-lighten-4">Lucca - Italia</p>
        </div>
        <div class="col l4 s12">
          <h5 class="white-text">Social</h5>
          <a href="https://facebook.com/aziende.expo" target="_blank"><img src="https://png.icons8.com/material/50/000000/facebook.png"></a>
          <a href="https://twitter.com/aziendeexpo" target="_blank"><img src="https://png.icons8.com/metro/50/000000/twitter.png"></a>
          <a href="https://instagram.com/aziendeexpo" target="_blank"><img src="https://png.icons8.com/ios-glyphs/50/000000/instagram-new.png"></a>
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
