<?php
  include('res/database.php');
  include('res/sec.php');
  session_start();
  if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
      $db = $_SESSION['db'];
      if($_GET['hash'] == $_SESSION['hash'] && $_GET['email'] == Encryption::decrypt($_SESSION['user']) && $db->checkEmail($_GET['email']) != false ){
        $db->addAzienda($_SESSION['user']);
        $_SESSION['active'] = 1;
        $db->setActive($_SESSION['user']);
        header('location: profile.php');
      }else{
        header('location: index.php');
      }
  }else{
    header('location: index.php');
  }
?>
