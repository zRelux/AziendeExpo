<?php
  include('res/database.php');
  include('res/sec.php');
  session_start();
  if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
      $db = $_SESSION['db'];
      if($_GET['hash'] == $_SESSION['hash'] && $db->checkEmail(Encryption::crypt($_GET['email'])) != false ){
        $db->addAzienda(Encryption::crypt($_GET['email']));
        $_SESSION['active'] = 1;
        $db->setActive(Encryption::crypt($_GET['email']));
        header('location: profile.php');
      }else{
        header('location: index.php');
      }
  }else{
    header('location: index.php');
  }
?>
