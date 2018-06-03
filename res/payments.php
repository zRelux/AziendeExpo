<?php
  require "res/database.php";
  require "res/sec.php";
  session_start();
  $db = $_SESSION['db'];
  $db->updatePayment(Encryption::encrypt($_POST['email']));
  $db->sponsorizza(Encryption::encrypt($_POST['email']));
?>
