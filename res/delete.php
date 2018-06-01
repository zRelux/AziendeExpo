<?php
  include('database.php');
  session_start();
  $db = $_SESSION['db'];
  if(isset($_POST['cancella']) && !empty($_POST['cancella'])){
    $id = $_POST['cancella'];
    $path = $db->getPostImage($id);
    if (file_exists("." . $path['postimage'])) {
        unlink("." . $path['postimage']);
    }
    $db->deletePost($id);
  }
?>
