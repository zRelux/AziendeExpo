<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include('res/database.php');
  include('res/sec.php');
  session_start();
  $error = "";
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

  if(isset($_POST['email']) && isset($_POST['pass']) && !empty($_POST['email']) && !empty($_POST['pass'])){

    $email = Encryption::encrypt($_POST['email']);
    $pass = Encryption::encrypt($_POST['pass']);

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

      $error = 'Email non valida';

    }else if($db->checkLogin($email, $pass) == true){
      if($db->checkActive($email, $pass) == true){
        $_SESSION['user'] = $email;
        $_SESSION['password'] = $pass;
        header("Location: profile.php?find=true");
      }else{
        $error = "Email non verificata";
      }
    }else{

      $error = "Email o Password errati";

    }

  }else if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['password']) && !empty($_SESSION['password']) && $db->checkLogin($_SESSION['user'], $_SESSION['password']) == true){

    header("Location: profile.php?find=true");

  }
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Accesso</title>

      <link rel="apple-touch-icon" sizes="76x76" href="images/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
      <link rel="manifest" href="images/site.webmanifest">
      <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">


      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" type="text/css" rel="stylesheet" media="screen,projection" />
      <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection" />
      <link href="css/logstile.css" type="text/css" rel="stylesheet" media="screen,projection" />
      <link href="css/stileProfilo.css" type="text/css" rel="stylesheet" media="screen,projection" />
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   </head>
   <body>
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
      <div class="materialContainer container">
         <div class="box">
           <form class="" action="" method="post" autocomplete="on">
            <div class="title">Accedi</div>
            <div class="input">
              <input name="email" type="email" placeholder="Email" class="validate">
            </div>
            <div class="input">
              <input name="pass" type="password" placeholder="Password" class="validate">
            </div>
            <div class="button login">
               <button type="submit"><span>Accedi</span><i class="fa fa-check"></i></button>
            </div>
            <div class="help">
              <?php
                echo "<a href='' class=" . "wrong-use" . ">" . $error . "</a>"
               ?>
              <a href="forgotPassword.php" class="pass-forgot">Password dimenticata?</a>
              <a href="register.php" class="nuovo">Crea un account</a>
            </div>
          </form>
        </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/materialize.min.js"></script>
      <script src="js/main.js"></script>
   </body>
</html>
