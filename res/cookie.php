<?php
  if(!isset($_COOKIE['data'])){
      setcookie('data', true, time() + (60*60*24*30));
  }
?>
