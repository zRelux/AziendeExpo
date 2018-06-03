<?php
  require "res/sec.php";
  session_start();
  if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
    header("location: index.php");
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
  <title>Pubblicizza azienda</title>

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


  <div class="container">
      <div class="row">
        <h1 class="center-align">Pubblicizza la tua azienda!</h1>
        <div class="indicizzazione">
          <div class="row">
                <div class="row">
                  <div class="row center">
                    <h5>Rendi la tua azienda la piu vista per un'intera settimana!!
                        Non peredere questa occasione a solo 5€!</h5>
                  </div>
                  <div class="row">
                    <div class="col s12">
                      <p class="flow-text">Il tuo bussines verrà visto sempre da chiunque non perdere questa occasione!!<br>
                    A solo 5€ potrai rendere la tua azienda più visibile a tutti!</p>
                    </div>
                  </div>
                  <div class="center">
                    <div id="paypal-button"></div>
                  </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/main.js"></script>

  <script src="https://www.paypalobjects.com/api/checkout.js"></script>

  <script>
      paypal.Button.render({

          env: 'sandbox', // Or 'sandbox'

          client: {
              sandbox:    'AR9Vb6n96kpAWztYoQbZazEZS4VgiiuhntHmyssKJ1V2TeWltykpgBqFBUk7Qdd7ukkQOznc63fvIVP6',
              production: 'AToPN6RrOd93N2WcJDg0uj27Ff7vkHjw1GZi2p6uj3VfrA-CeqY2yIG3fB_Nlj-1rNU26z0UX0KhG5XA'
          },

          commit: true, // Show a 'Pay Now' button

          payment: function(data, actions) {
              return actions.payment.create({
                  payment: {
                      transactions: [
                          {
                              amount: { total: '5.00', currency: 'EUR' }
                          }
                      ]
                  }
              });
          },

          onAuthorize: function(data, actions) {
              return actions.payment.execute().then(function(payment) {
                /*$.ajax({
                  url: 'res/payments.php',
                  type: 'POST',
                  data: {
                    email:
                  },
                  dataType: "json",
                  success: function(result) {

                  },

                  error: function(data) {
                    console.log(data);
                  }

                });*/
              });
          }

      }, '#paypal-button');
  </script>
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
