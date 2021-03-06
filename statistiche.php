<?php
  include('res/database.php');
  session_start();
  $db = $_SESSION['db'];

  $data = array();

  $result = $db->loadStats($_SESSION['user']);

  if($result)
    if ($result->num_rows > 0) {
    // output data of each row
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


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
    <title>Statistiche</title>
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
          <div id="chartContainer" class="col s12">
            <canvas id="mycanvas"></canvas>
          </div>

        </div>
      </div>
    </main>


    <!--  Scripts-->
    <script src="js/jquery.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script>
      $(document).ready(function() {
        var settimana = [];
        var visualizzazioni = [];

        data = JSON.parse('<?php echo json_encode($data); ?>');
        for (var i in data) {
          settimana.push("Settimana: " + data[i].settimana);
          visualizzazioni.push(data[i].visualizzazioni);
        }

        var chartdata = {
          labels: settimana,
          datasets: [{
            backgroundColor: 'rgba(200, 200, 200, 0.75)',
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: visualizzazioni
          }]
        };

        var option = {
          responsive: true,
          title: {
            display: true,
            position: "top",
            text: "Visualizzazioni settimanali",
            fontSize: 18,
            fontColor: "#111"
          },
          legend: {
            display: false,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                min: 0
              }
            }]
          }
        };
        var ctx = $("#mycanvas");

        var barGraph = new Chart(ctx, {
          type: 'bar',
          data: chartdata,
          options: option
        });
      });
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
