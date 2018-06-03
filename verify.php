<?php
  include('res/database.php');
  include('res/sec.php');
  session_start();
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


  echo Encryption::encrypt($_GET['email']) . " " . $_GET['hash'] == $db->getHash($_GET['email'])['hash'];
  if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
      echo Encryption::encrypt($_GET['email']) . " " . $_GET['hash'] == $db->getHash($_GET['email'])['hash'];
      if($db->checkEmail(Encryption::encrypt($_GET['email'])) != false){
        if($_GET['hash'] == $db->getHash($_GET['email'])['hash']){
          $db->addAzienda(Encryption::encrypt($_GET['email']));
          $_SESSION['active'] = 1;
          $db->setActive(Encryption::encrypt($_GET['email']));
          header('location: profile.php');
        }else{
          echo Encryption::encrypt($_GET['email']) . " " . $_GET['hash'] == $db->getHash($_GET['email'])['hash'];
        }
      }
  }else{
    header('location: index.php');
  }
?>
