<?php
  include('res/database.php');
  include('res/sec.php');
  include('res/mailer.php');
  session_start();
  if(isset($_POST['email']) && !empty($_POST['email'])){
    $db = $_SESSION['db'];
    $email = Encryption::encrypt($_POST['email']);
    $hash = $db->getHash($email)['hash'];

    $to = $_POST['email'];

    $subject = 'Password dimenticata';
    $body    = '

    Ciao!
    Per modificare la tua password clicca qui!
    http://mostralatuazienda.epizy.com/newPassword.php?email=' . $to . '&hash=' . $hash . '

    ';


    Mailer::email($to, $subject, $body);
  }

?>
<!DOCTYPE html>
<html>
   <head>
      <title>Password dimenticata</title>

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
            <div class="title">Ricorda Password</div>
            <div class="input">
              <input name="email" type="email" placeholder="Email" class="validate">
            </div>
            <div class="button login">
               <button type="submit"><span>Invia email</span><i class="fa fa-check"></i></button>
            </div>
            <div class="help">
              <?php
                echo "<a href='' class=" . "wrong-use" . ">" . $error . "</a>"
               ?>
              <a href="login.php" class="pass-forgot">Accedi</a>
              <a href="register.php" class="nuovo">Crea un account</a>
            </div>
          </form>
        </div>
      </div>
   </body>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <script src="js/main.js"></script>
</html>
