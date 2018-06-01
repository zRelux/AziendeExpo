<?php
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

      $_SESSION['user'] = $email;
      $_SESSION['password'] = $pass;
      header("Location: profile.php?find=true");

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
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <!-- CSS  -->
      <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
      <link href="css/logstile.css" type="text/css" rel="stylesheet" media="screen,projection" />
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   </head>
   <body>
      <div class="materialContainer">
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
   </body>
   <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
   <script src="js/main.js"></script>
</html>
