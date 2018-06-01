<?php
  include('res/database.php');
  session_start();
  $db = $_SESSION['db'];
  $mode = false;

  if(isset($_GET['id'])){
    $result = $db->findByName($_GET['id']);
    if(!isset($result) || empty($result) || $result === null){
      header("location: pagenotfound.php");
    }else if(!isset($_SESSION['user']) || empty($_SESSION['user']) || !$db->profile($_SESSION['user'], $result['id'])){
      $mode = false;
    }else if(isset($_SESSION['user']) && $db->profile($_SESSION['user'], $result['id'])){
      $mode = true;
    }
  }else if(isset($_GET['find'])){
    if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
      header("Location: login.php");
    }
    $result = $db->find($_SESSION['user']);
    if(!isset($result) || empty($result) || $result === null){
      header("Location: login.php");
    }else{
      $mode = true;
    }
  }else if(!isset($db) || empty($db) || !isset($_SESSION['user']) || empty($_SESSION['user']) || !isset($_SESSION['password']) || empty($_SESSION['password']) || $db->checkLogin($_SESSION['user'], $_SESSION['password']) != true){
    header("Location: login.php");
  }

  if($mode == false && !isset($_COOKIE[$result['id']])){
    $db->addVisual($result['id']);
    setcookie($result['id'],$result['ragione'], time() + (60*60*24));
  }

  if(isset($_GET['id'])){
    $cards = $db->loadCardsById($_GET['id']);
  }else{
    $cards = $db->loadCards($result['id']);
  }

  function loadPosts($cards){
    if($cards)
      if ($cards->num_rows > 0) {
        while($row = $cards->fetch_assoc()) {
          if(!isset($row['postimage']) || empty($row['postimage']) || $row['postimage'] == "./upload/"){
            $row['postimage'] = "images/background2.jpg";
          }
            $prodotto =  str_replace("https://", "", $row['link']);
            $prodotto =  str_replace("http://", "", $prodotto);
            echo '<div class="card medium">
                    <a name="' . $row['nome_progetto'] . '"></a>
                    <div class="card-image waves-effect waves-block waves-light">
                      <img materialize="" class="materialboxed" src=' . $row['postimage'] . ' alt="immagine progetto">
                      <a class="btn-floating btn-small waves-effect waves-light red btn-close immagine" onclick="cancellaPost(' .  $row['id'] . ')"><i class="material-icons">close</i></a>
                    </div>
                    <div class="card-content">
                      <span class="card-title activator grey-text text-darken-4">' . $row['nome_progetto'] . '<i class="material-icons right">more_vert</i></span>';
                      if($row['link'] != "no"){
                        echo '<div class="card-action">
                          <a target="_blank" href="' . $row['link'] . '">' . $prodotto . '</a>
                        </div>';
                    }
                    echo '</div>
                    <div class="card-reveal">
                      <span class="card-title grey-text text-darken-4">' . $row['nome_progetto'] . '<i class="material-icons right">close</i></span>
                      <p>' . $row['descrizione'] . '</p>
                    </div>
                  </div>';
        }
      }
    }
?>

  <!DOCTYPE html>
  <html lang="it">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="robots" content="index,follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?php echo $result['card_info'] ?>"/>
    <meta name="copyright" content="Diritti riservati ad AziendeExpo.it" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="<?php echo $result['ragione']; ?>,<?php echo $result['sitoweb']; ?>, <?php echo $result['info']; ?>, <?php echo $result['card_info']; ?>">

    <title>
      <?php echo $result['ragione'] ?>
    </title>
    <!-- Favicons-->
    <link rel="icon" href="<?php if($result['userimage'] != null && $result['userimage'] != " 20 ") echo $result['userimage']; else echo 'images/background1.jpg' ?>" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="">
    <meta name="theme-color" content="#db5945">
    <!-- For Windows Phone -->

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" rel="stylesheet">
    <link href="css/stileProfilo.css" type="text/css" rel="stylesheet" media="screen,projection" />


  </head>

  <body>
    <!-- Barra di navigazione -->
    <header id="header" class="page-topbar">
      <nav class="white">
        <div class="navbar-fixed">
          <div class="nav-wrapper">
            <a href="./index.php" class="brand-logo"><img src="images/logo.PNG" alt="Logo" class="image-logo" width="150px"></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li>
                <li>
                  <form id="ricercaAz" method="get" action="index.php">
                    <div class="input-field">
                      <i class="black-text material-icons prefix">search</i>
                      <input id="ricercaAziende" type="text" placeholder="Cerca..." name="data" onkeydown="search(this)" ><!--onkeyup="ricerca()"-->
                    </div>
                  </form>
                </li>
              </li>
              <li><a href="index.php">Home</a></li>
              <li><a href="contatti.php">Team</a></li>
              <li><a href="login.php" class="waves-effect waves-teal"><i class="material-icons">add_circle</i></a></li>
              <li><a href="profile.php?find=true" class="dropdown-button profiledropdown waves-effect waves-teal" data-target='dropdownNav'><i class="medium material-icons">account_circle</i></a></li>
            </ul>
            <ul id='dropdownNav' class='dropdown-content'>
              <li><a href="profile.php?find=true">Profilo</a></li>
              <li><a href="info.php">Info Azienda</a></li>
              <li><a href="res/logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <ul id="mobile-demo" class="sidenav">
        <li><a href="index.php">Home</a></li>
        <li><a href="contatti.php">Team</a></li>
        <li><a href="login.php">Accedi</a></li>
        <li><a href="profile.php?find=true">Profilo</a></li>
        <li><a href="info.php">Info Azienda</a></li>
        <li><a href="res/logout.php">Logout</a></li>
      </ul>
    </header>


    <!--FAI SOLO SE TUO PROFILO-->

    <?php
    if($mode == true){
      echo '<div class="fixed-action-btn">
        <a class="btn-floating btn-large red" onselectstart="return false;" ondragstart="return false;">
          <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
          <li><a class="btn-floating red tooltipped" data-position="left" data-tooltip="Visualizza statistiche" onselectstart="return false;" ondragstart="return false;" href=".\statistiche.php"><i class="material-icons">insert_chart</i></a></li>
          <li><a class="btn-floating yellow darken-1 tooltipped" data-position="left" data-tooltip="Posta nuovo progetto" onselectstart="return false;" ondragstart="return false;" href=".\newPost.php"><i class="material-icons">format_quote</i></a></li>
          <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="Salva modifiche" onselectstart="return false;" ondragstart="return false;" onclick="saveEdit()"><i class="material-icons">save</i></a></li>
          <li><a class="btn-floating blue tooltipped" data-position="left" data-tooltip="Modifica" onselectstart="return false;" ondragstart="return false;" onclick="modify()"><i class="material-icons">mode_edit</i></a></li>
        </ul>
      </div>';
    }
    ?>

      <!-- START MAIN -->
      <div id="main">
        <div class="wrapper">
          <section id="content">
            <div id="profile-page" class="section">
              <div class="card">
                <div class="card-image">
                  <a href="<?php if($result['backgroundimage'] != null && $result['backgroundimage'] != " 20 ") echo $result['backgroundimage']; else echo 'images/background2.jpg' ?>"><img class="background-image" src="<?php if($result['backgroundimage'] != null && $result['backgroundimage'] != "20") echo $result['backgroundimage']; else echo 'images/background2.jpg' ?>" alt="user background" height="250px"></a>
                  <form enctype="multipart/form-data" method="POST" action="./res/upload.php">
                    <input type="file" id="selectedFile1" name="backgroundimage" maxlength='1' accept="image/jpg, image/png, image/jpeg" onchange="form.submit()" style="display: none;" />
                    <a class="btn-floating btn-large waves-effect waves-light btn-upload immagine" onclick="document.getElementById('selectedFile1').click();"><i class="material-icons">add</i></a>
                  </form>
                </div>
                <div class="card-content">
                  <div class="row pt-2">
                    <div class="card-profile-image">
                      <div class="col s12 m12 l2 center">
                        <img class="profile-image materialboxed" src="<?php if($result['userimage'] != null && $result['userimage'] != " 20 ") echo $result['userimage']; else echo 'images/background2.jpg' ?>" alt="profile image" width="110px" width="110px">
                        <form enctype="multipart/form-data" method="POST" action="./res/upload.php">
                          <input type="file" id="selectedFile2" name="userimage" maxlength='1' accept="image/jpg, image/png, image/jpeg" onchange="form.submit()" style="display: none;" />
                          <a class="btn-floating btn-large waves-effect waves-light immagine btn-profile" onclick="document.getElementById('selectedFile2').click();"><i class="material-icons">add</i></a>
                        </form>
                      </div>
                    </div>
                    <?php
                    $campi = 4;
                    $i = 10;
                    if(empty($result['nome_campo_1']) || empty($result['campo_1'])){
                      $campi --;
                    }
                    if(empty($result['nome_campo_2']) || empty($result['campo_2'])){
                      $campi --;
                    }
                    if(empty($result['nome_campo_3']) || empty($result['campo_3'])){
                      $campi --;
                    }
                    $spazio = $i / $campi;

                    echo '<div class="col s12 m12 l' . ceil($spazio) . ' center-align">
                            <h4 class="m-text" contenteditable="false" class="card-title grey-text text-darken-4">' . $result['ragione'] . '</h4>
                            <p class="medium-small grey-text">Nome Azienda</p>
                          </div>';
                    if(!empty($result['nome_campo_1']) &&  !empty($result['campo_1'])){
                      echo '<div class="col s12 m12 l' . round($spazio, 0, PHP_ROUND_HALF_DOWN) . ' center-align">
                              <h4 class="card-title grey-text text-darken-4 m-text" contenteditable="false">' . $result['campo_1'] . '</h4>
                              <p class="medium-small grey-text m-text" contenteditable="false">' . $result['nome_campo_1'] . '</p>
                            </div>';
                    }else{
                      echo '<div class="col s12 m12 l2 center-align invisibile" style="display: none">
                              <h4 class="card-title grey-text text-darken-4 m-text invisibile" contenteditable="false">' . $result['campo_1'] . '</h4>
                              <p class="medium-small grey-text m-text" contenteditable="false">' . $result['nome_campo_1'] . '</p>
                            </div>';
                    }
                    if(!empty($result['nome_campo_2']) &&  !empty($result['campo_2'])){
                      echo '<div class="col s12 m12 l' . round($spazio, 0, PHP_ROUND_HALF_DOWN) . ' center-align">
                              <h4 class="card-title grey-text text-darken-4 m-text" contenteditable="false">' . $result['campo_2'] . '</h4>
                              <p class="medium-small grey-text m-text" contenteditable="false">' . $result['nome_campo_2'] . '</p>
                            </div>';
                    }else{
                      echo '<div class="col s12 m12 l center-align invisibile" style="display: none">
                              <h4 class="card-title grey-text text-darken-4 m-text invisibile" contenteditable="false">' . $result['campo_2'] . '</h4>
                              <p class="medium-small grey-text m-text" contenteditable="false">' . $result['nome_campo_2'] . '</p>
                            </div>';
                    }
                    if(!empty($result['nome_campo_3']) &&  !empty($result['campo_3'])){
                      echo '<div class="col s12 m12 l' . round($spazio, 0, PHP_ROUND_HALF_DOWN) . ' center-align">
                              <h4 class="card-title grey-text text-darken-4 m-text" contenteditable="false">' . $result['campo_3'] . '</h4>
                              <p class="medium-small grey-text m-text" contenteditable="false">' . $result['nome_campo_3'] . '</p>
                            </div>';
                    }else{
                      echo '<div class="col s12 m12 l center-align invisibile" style="display: none">
                              <h4 class="card-title grey-text text-darken-4 m-text invisibile" contenteditable="false">' . $result['campo_3'] . '</h4>
                              <p class="medium-small grey-text m-text" contenteditable="false">' . $result['nome_campo_3'] . '</p>
                            </div>';
                    }
                  ?>
                  </div>
                </div>
              </div>
              <div class="card light-blue lighten-5 hoverable">
                <div class="card-content black-text">
                  <span class="card-title">Informazioni su di noi.</span>
                  <p class="m-text" contenteditable="false">
                    <?php echo $result['info'] ?>
                  </p>
                </div>
              </div>
            </div>
            <div id="profile-page-content" class="row">
              <div id="profile-page-sidebar" class="col s12 m12 l4">
                <ul id="profile-page-about-details" class="collection z-depth-3">
                  <?php
                      if(!empty($result['sitoweb'])){
                        $sito =  str_replace("https://", "", $result['sitoweb']);
                        $sito =  str_replace("http://", "", $sito);
                        echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s12 m4">
                              <i class="material-icons left">card_travel</i> Sitoweb</div>
                            <div class="col s12 m8 right-align"><a target="_blank" href="' . $result['sitoweb'] . '">' . $sito . '</a></div>
                          </div>
                        </li>';
                      }else{
                        echo '<li class="collection-item invisibile" style="display: none">
                          <div class="row">
                            <div class="col s12 m4">
                              <i class="material-icons left">card_travel</i> Sitoweb</div>
                            <div class="col s12 m8 right-align"><a target="_blank" href="' . $result['sitoweb'] . '">' . $sito . '</a></div>
                          </div>
                        </li>';
                      }
                      if(!empty($result['sede'])){
                        echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s12 m4">
                              <i class="material-icons left">domain</i> Sede in</div>
                            <div class="col s12 m8 right-align m-text" contenteditable="false">'. $result['sede'] . '</div>
                          </div>
                        </li>';
                      }else{
                        echo '<li class="collection-item invisibile" style="display: none">
                          <div class="row">
                            <div class="col s12 m4">
                              <i class="material-icons left">domain</i> Sede in</div>
                            <div class="col s12 m8 right-align m-text" contenteditable="false">'. $result['sede'] . '</div>
                          </div>
                        </li>';
                      }
                      if(!empty($result['nata'])){
                        echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s12 m5">
                              <i class="material-icons left">cake</i> Fondata il</div>
                            <div class="col s12 m7 right-align m-text" contenteditable="false">'. $result['nata'] . '</div>
                          </div>
                        </li>';
                      }else{
                        echo '<li class="collection-item invisibile" style="display: none">
                          <div class="row">
                            <div class="col s12 m5">
                              <i class="material-icons left">cake</i> Fondata il</div>
                            <div class="col s12 m7 right-align m-text" contenteditable="false">'. $result['nata'] . '</div>
                          </div>
                        </li>';
                      }
                      if(!empty($result['email'])){
                        echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s12 m5">
                              <i class="material-icons">email</i> Email</div>
                            <div class="col s12 m7 right-align">'. $result['email'] . '</div>
                          </div>
                        </li>';
                      }else{
                        echo '<li class="collection-item invisibile" style="display: none">
                          <div class="row">
                            <div class="col s12 m5">
                              <i class="material-icons">email</i> Email</div>
                            <div class="col s12 m7 right-align">'. $result['email'] . '</div>
                          </div>
                        </li>';
                      }
                      if(!empty($result['telefono'])){
                        echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s12 m5">
                              <i class="material-icons">perm_phone_msg</i> Telefono</div>
                            <div class="col s12 m7 right-align">'. $result['telefono'] . '</div>
                          </div>
                        </li>';
                      }else{
                        echo '<li class="collection-item invisibile" style="display: none">
                          <div class="row">
                            <div class="col s12 m5">
                              <i class="material-icons">perm_phone_msg</i> Telefono</div>
                            <div class="col s12 m7 right-align">'. $result['telefono'] . '</div>
                          </div>
                        </li>';
                      }
                      if(!empty($result['tipoazienda'])){
                        echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s12 m4">
                              <i class="material-icons">style</i> Tipologia:</div>
                            <div class="col s12 m8 right-align">'. $result['tipoazienda'] . '</div>
                          </div>
                        </li>';
                      }else{
                        echo '<li class="collection-item invisibile" style="display: none">
                          <div class="row">
                            <div class="col s12 m8">
                              <i class="material-icons">style</i> Tipologia:</div>
                            <div class="col s12 m48 right-align">'. $result['tipoazienda'] . '</div>
                          </div>
                        </li>';
                      }
                    ?>
                </ul>
                <?php
                    if($cards)
                      if ($cards->num_rows > 0) {
                        echo '<div class="contact">
                                <div class="card z-depth-3">
                                  <div class="card-content black-text">
                                    <div class="row">
                                    <form action="res/contact.php" method="POST" class="col s12 m12">
                                      <h5 class="center">Contattaci!</h5>
                                      <input id="emailDest" name="emailDest" type="text" class="validate" style="display: none" value=' . $result['email'] . ' required>
                                      <div class="row">
                                        <div class="input-field col s6">
                                          <input id="first_name" name="nome" type="text" class="validate" required>
                                          <label for="first_name">Nome mittente</label>
                                        </div>
                                        <div class="input-field col s6">
                                          <input id="last_name" name="cognome" type="text" class="validate" required>
                                          <label for="last_name">Cognome Mittente</label>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="input-field col s12 m12">
                                          <input id="email" name="emailMitt" type="email" class="validate" required>
                                          <label for="email">Email</label>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="input-field col s12 m12">
                                          <textarea id="descrizione" name="desc" class="materialize-textarea" data-length="300" required></textarea>
                                          <label for="textarea1">Descrizione</label>
                                        </div>
                                      </div>
                                      <div class="row center">
                                        <button class="btn waves-effect waves-light" type="submit" name="action" >Contatta
                                          <i class="material-icons right">send</i>
                                        </button>
                                      </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                      }
                  ?>
              </div>
              <div id="profile-page-wall" class="col s12 m12 l8">
                <div id="profile-page-wall-posts" class="row">
                  <div class="col s12 m12">
                    <?php
                      if($cards)
                        if ($cards->num_rows <= 0) {
                          echo '<div class="contact">
                                  <div class="card z-depth-3">
                                    <div class="card-content black-text">
                                      <div class="row">
                                      <form action="res/contact.php" method="POST" class="col s12 m12">
                                        <h5 class="center">Contattaci!</h5>
                                        <input id="emailDest" name="emailDest" type="text" class="validate" style="display: none" value=' . $result['email'] . ' required>
                                        <div class="row">
                                          <div class="input-field col s6">
                                            <input id="first_name" name="nome" type="text" class="validate" required>
                                            <label for="first_name">Nome mittente</label>
                                          </div>
                                          <div class="input-field col s6">
                                            <input id="last_name" name="cognome" type="text" class="validate" required>
                                            <label for="last_name">Cognome Mittente</label>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="input-field col s12 m12">
                                            <input id="email" name="emailMitt" type="email" class="validate" required>
                                            <label for="email">Email</label>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="input-field col s12 m12">
                                            <textarea id="descrizione" name="desc" class="materialize-textarea" data-length="300" required></textarea>
                                            <label for="textarea1">Descrizione</label>
                                          </div>
                                        </div>
                                        <div class="row center">
                                          <button class="btn waves-effect waves-light" type="submit" name="action" >Contatta
                                            <i class="material-icons right">send</i>
                                          </button>
                                        </div>
                                      </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>';
                        }else{
                          loadPosts($cards);
                        }
                      ?>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
      </section>
      </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="js/main.js"></script>
      <?php if($mode == true && !isset($_COOKIE['info'])) echo "<script> M.toast({html: 'Ricorda di modificare le info relative all azienda'}, 4000)   </script>"; ?>
      <script>
      </script>
  </body>

  </html>
