<?php
  include('res/database.php');
  include('res/sec.php');
  session_start();
  if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
      $db = $_SESSION['db'];
      if($_GET['hash'] == $_SESSION['hash'] && $db->checkEmail(Encryption::encrypt($_GET['email'])) != false ){
        $db->addAzienda(Encryption::encrypt($_GET['email']));
        $_SESSION['active'] = 1;
        $db->setActive(Encryption::encrypt($_GET['email']));
        header('location: profile.php');
      }else{
        header('location: index.php');
      }
  }else{
    header('location: index.php');
  }
?>
