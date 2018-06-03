<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require "database.php";
  require "sec.php";
  session_start();
  $db = $_SESSION['db'];
  $db->updatePayment(Encryption::encrypt($_POST['email']));
  $db->sponsorizza(Encryption::encrypt($_POST['email']));
?>
