<?php
  require("mailer.php");
  if(isset($_POST)){
    print_r($_POST);

    $subject = 'Messaggio da ' . $_POST['nome'] . " " . $_POST['cognome'];
    $body    = $_POST['desc'] . "

    Inviato da " . $_POST['nome'] . " " . $_POST['cognome'] . "

    email: " .  $_POST['emailMitt'];

    Mailer::email($_POST['emailDest'], $subject, $body);

    header("Location: ../profile.php?find=true");
  }
?>
