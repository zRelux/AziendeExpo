<?php
  include("database.php");
  session_start();
  $db = $_SESSION['db'];
  if(isset($_FILES['userimage'])){
    $_FILES['userimage']['name'] = preg_replace('/\s+/', '', $_FILES['userimage']['name']);

    $path = $db->getOldImage($_SESSION['user']);
    if (file_exists("." . $path['userimage']) && $path['userimage'] != $path['backgroundimage']) {
        unlink("." . $path['userimage']);
    }

    $src = $_FILES['userimage']['tmp_name'];
    $targ = "../upload/".uniqid().$_FILES['userimage']['name'];
    move_uploaded_file($src, $targ);

    $source_img = $targ;
    $destination_img = $targ;

    compress($source_img, $destination_img, 60);

    echo "$src --- $targ";

    $db->uploadImage($_SESSION['user'], preg_replace('/^./', '', $targ), "userimage");
    header("Location: ../profile.php?find=true");

  }else if(isset($_FILES['backgroundimage'])){
    $_FILES['backgroundimage']['name'] = preg_replace('/\s+/', '', $_FILES['backgroundimage']['name']);

    $path = $db->getOldImage($_SESSION['user']);


    if (file_exists("." . $path['backgroundimage']) && $path['userimage'] != $path['backgroundimage']) {
        unlink("." . $path['backgroundimage']);
    }


    $src = $_FILES['backgroundimage']['tmp_name'];
    $targ = "../upload/".uniqid().$_FILES['backgroundimage']['name'];
    move_uploaded_file($src, $targ);

    $source_img = $targ;
    $destination_img = $targ;

    compress($source_img, $destination_img, 60);

    echo "$src --- $targ";

    $db->uploadImage($_SESSION['user'], preg_replace('/^./', '', $targ), "backgroundimage");
    header("Location: ../profile.php?find=true");

  }

  function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
  }

?>
