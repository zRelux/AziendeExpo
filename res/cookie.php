<?php
  if(!isset($_COOKIE['cookie'])){
      setcookie('cookie', true, time() + (60*60*24*30));
  }
?>
