<?php
  include('database.php');
  session_start();
  $db = $_SESSION['db'];
  if(isset($_POST['dati']) && !empty($_POST['dati'])){
    $elements = $_POST['dati'];
    $elements = explode('*', $elements);

    $db->update($elements, $_SESSION['user']);
  }else if(isset($_POST['info']) && !empty($_POST['info']) && isset($_POST['nome']) && !empty($_POST['nome'])){

    $_FILES['backgroundimage']['name'] = preg_replace('/\s+/', '', $_FILES['backgroundimage']['name']);

    $src = $_FILES['postimage']['tmp_name'];
    if(empty($_FILES['postimage']['name'])){
      $targ = "../upload/".$_FILES['postimage']['name'];
    }else
      $targ = "../upload/".uniqid().$_FILES['postimage']['name'];

    move_uploaded_file($src, $targ);

    $source_img = $targ;
    $destination_img = $targ;

    compress($source_img, $destination_img, 60);

    echo "$src --- $targ";

    $elements = [];
    $elements[] = $_POST['nome'];
    $elements[] = $_POST['info'];
    if(isset($_POST['linkProdotto']) && !empty($_POST['linkProdotto']) && $_POST['linkProdotto'] != 'Link che porta al prodotto | progetto' && strpos($_POST['linkProdotto'], 'http') !== false && strpos($_POST['linkProdotto'], 'porn') !== false){
      $elements[] = $_POST['linkProdotto'];
    }else{
      $elements[] = "no";
    }
    $elements[] = preg_replace('/^./', '', $targ);
    $db->newPost($elements, $_SESSION['user']);
    header("Location: ../profile.php?find=true");
  }else if(isset($_POST['tipoazienda']) || isset($_POST['ragione']) || isset($_POST['sitoweb']) || isset($_POST['telefono']) || isset($_POST['email'])){
    $campi = array();
    foreach ($_POST as $key => $value) {
      if(empty($value))
        array_push($campi, $key . " = -/");
      else
        array_push($campi, $key . " = " . $value);
    }
    $db->aggiornaInfo($campi, $_SESSION["user"]);
    header("Location: ../profile.php?find=true");
  }
  header("Location: ../profile.php?find=true");

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
