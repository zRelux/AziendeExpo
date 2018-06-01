<?php
  require('res/mailer.php');
  require('res/database.php');
  require('res/sec.php');
  session_start();
  $errorReg = "";
  if(!isset($_SESSION['db'])){
      header("Location: login.php");
    }else{
      $db = $_SESSION['db'];
    }
  $db = $_SESSION['db'];

  if(isset($_POST['remail']) && isset($_POST['regpass']) && !empty($_POST['remail']) && !empty($_POST['regpass']) && isset($_POST['reregpass']) && !empty($_POST['reregpass'])){

    $email = Encryption::encrypt($_POST['remail']);
    $pass = Encryption::encrypt($_POST['regpass']);

    if($db->checkLogin($email, $pass) == true){

      $errorReg = "Email già registrata";

    }else if($_POST['regpass'] === $_POST['reregpass'] && strlen($_POST['regpass']) > 7){

      $_SESSION['user'] = $email;
      $_SESSION['password'] = $pass;
      $db->addUser($email, $pass);

      $hash = Encryption::hashpass($pass, $email);
      $_SESSION['hash'] = $hash;

      $to = Encryption::decrypt($email);

      $subject = 'Signup | Verification';
      $body    = '

      Thanks for signing up!
      Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
      Please click this link to activate your account:
      http://mostralatuazienda.epizy.com/verify.php?email=' . $to . '&hash=' . $hash . '

      ';

      Mailer::email($to, $subject, $body);


      $errorReg = "Verifica il tuo account per accedere";

    }else if($_POST['regpass'] !== $_POST['reregpass']){

      $errorReg =  "Le password non sono uguali";

    }else if(strlen($_POST['regpass']) < 7){

      $errorReg = "La password è meno di 7 caratteri";

    }
  }
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Registrazione</title>

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
          <form class="" action="" method="post" autocomplete="off">
           <div class="title">Registrazione</div>
           <div class="input">
             <input name="remail" type="email" placeholder="Email" class="validate">
           </div>
           <div class="input">
             <input name="regpass" type="password" placeholder="Password" class="validate">
           </div>
           <div class="input">
             <input name="reregpass" type="password" placeholder="Ripeti Password" class="validate">
           </div>
           <div class="button login">
              <button type="submit"><span>Registrati</span><i class="fa fa-check"></i></button>
           </div>
           <div class="help">
             <?php
               echo "<a href='' class=" . "wrong-use" . ">" . $errorReg . "</a>"
              ?>
             <a href="login.php" class="nuovo">Hai già un'account? Accedi.</a>
           </div>
         </form>
       </div>
     </div>
   </body>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <script src="js/main.js"></script>
</html>
