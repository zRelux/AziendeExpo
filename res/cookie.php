<?php
  if(!isset($_COOKIE['policy'])){
      setcookie('policy', true, time() + (60*60*24*30));
  }
?>
