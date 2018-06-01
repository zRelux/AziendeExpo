<!DOCTYPE html>
<html lang="it">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Profile page">

  <title>
    <?php echo "New Post "?>
  </title>

  <link rel="apple-touch-icon" sizes="76x76" href="images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
  <link rel="manifest" href="images/site.webmanifest">
  <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.min.css" rel="stylesheet">
  <link href="css/stileProfilo.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <style media="screen">
    [contenteditable=true] {
      border: 1px solid black;
    }
  </style>

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

  <form enctype="multipart/form-data" method="POST" action="res/save.php" autocomplete="off">
    <div class="row">
      <div class="ccont">
        <div class="fuoric l8 m12 s12 offset-l2">
          <div class="row">
            <div class="col l8 m12 s12 offset-l2">
              <h4 class="center-align">Fuori</h4>
            </div>
          </div>
          <div class="row">
            <div class="col l8 m12 s12 offset-l2">
              <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                  <img materialize="" class="materialboxed" id="img" src="images/background2.jpg" alt="user background" width="1307px" width="735px">
                  <input type="file" id="selectedFile1" name="postimage" maxlength='1' accept="image/jpg, image/png, image/jpeg" style="display: none;" onChange="readURL(this);"/>
                  <a class="btn-floating btn-large waves-effect waves-light red btn-upload" onclick="document.getElementById('selectedFile1').click();"><i class="material-icons">add</i></a>
                </div>
                <div class="card-content hoverable">
                  <input type="text" id="testoDaCopiare" name="nome" placeholder="Nome del progetto | Prodotto" maxlength="45" onkeyup="copia()" required>
                </div>
                <div class="card-action">
                  <input type="text" id="linkProdotto" name="linkProdotto" placeholder="Link che porta al prodotto | progetto">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="dentroc l6 m12 s12 offset-l2">
          <div class="row">
            <div class="col l8 m12 s12 offset-l2">
              <h4 class="center-align">Dentro</h4>
            </div>
          </div>
          <div class="row">
            <div class="col l8 m12 s12 offset-l2">
              <div class="card-reveal hoverable">
                <span id="progsubTitle" class="card-title grey-text text-darken-4 testoDaModificare">Nome Progetto | Prodotto<i class="material-icons right">close</i></span>
                <input type="text" name="info" placeholder="Informazioni relative al progetto" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bcont">
      <div class="row">
          <button type="submit" class="waves-effect waves-light btn col s2 offset-s5"><i class="material-icons left">cloud</i>Posta</button>
      </div>
    </div>
  </form>
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
<!-- -->
</html>
