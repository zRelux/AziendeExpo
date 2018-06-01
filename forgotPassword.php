<?php
  include('res/database.php');
  include('res/sec.php');
  include('res/mailer.php');
  session_start();
  $error = "";
  //Ciao lucche
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
      <script src="js/jquery.min.js"></script>
      <script src="js/materialize.min.js"></script>
      <script src="js/main.js"></script>

   </body>
</html>
