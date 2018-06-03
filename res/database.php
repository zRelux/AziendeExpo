<?php
  class Database {

    private $servername = "";
    private $database   = "";
    private $username   = "";
    private $password   = "";

    /*
      INIZIO
      FUNZIONI PER LA CONNESSIONE AL DB
    */
    function connect($servername, $database, $username, $password){
      // Create connection
      $this->servername = $servername;
      $this->database = $database;
      $this->username = $username;
      $this->password = $password;
      $conn = new mysqli($servername, $username, $password, $database);

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      return $conn;
    }


    function setLogInfo($servername, $database, $username, $password){
      // Create set variable for connection
      $this->servername = $servername;
      $this->database = $database;
      $this->username = $username;
      $this->password = $password;
    }
    /*
      FINE
      FUNZIONI PER LA CONNESSIONE AL DB
    */




    /*
      INIZIO
      FUNZIONI PER LA REGISTRAZIONE E L'ACCESSO
      Register.php Login.php
    */
    function checkLogin($email, $pass){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $email = $conn->real_escape_string($email);
      $pass = $conn->real_escape_string($pass);
      $sql = "SELECT * FROM users WHERE username=? AND password=?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $email, $pass);
      $stmt->execute();
      $stmt->store_result();


      if($stmt->num_rows > 0){
        return true;
      }else{
        return false;
      }
    }

    function checkActive($email, $pass){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $email = $conn->real_escape_string($email);
      $pass = $conn->real_escape_string($pass);
      $sql = "SELECT * FROM users WHERE username=? AND password=?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $email, $pass);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      if($row['active'] == 1){
        return true;
      }else{
        return false;
      }
    }

    function checkEmail($email){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $email = $conn->real_escape_string($email);
      $sql = "SELECT * FROM users WHERE username=?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();


      if($stmt->num_rows > 0){
        return true;
      }else{
        return false;
      }
    }


    function addUser($email, $password){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $email = $conn->real_escape_string($email);
      $password = $conn->real_escape_string($password);
      $hash = Encryption::hashpass($password, $email);
      $active = 0;

      $sql = "INSERT INTO users (username, password, hash, active) VALUES (?,?,?,?)";
      $stmt = $conn->prepare($sql);

      $stmt->bind_param("sssi", $email, $password, $hash, $active);
      $stmt->execute();

      $conn->close();
    }

    function addAzienda($email){
        $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

        $sql = "SELECT id FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();


        $sql = "INSERT INTO azienda VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);

        $id = $row['id'];
        $nome = "Nome azienda";
        $campo1 = "10";
        $nome_campo1 = "Anni nel bussiness";
        $campo2 = "20";
        $nome_campo2 = "Progetti completati";
        $campo3 = "10.000.000€";
        $nome_campo3 = "Investiti";
        $card_info = "Informazioni azienda";
        $telefono = 2943058151;
        $immagine = "";
        $email = "info@azienda.com";
        $info = "Informazioni azienda";
        $sitoweb = "https://sitoweb.it";
        $tipo = "Abbigliamento, Calzature, Accessori";
        $sede = "Lucca/IT";
        $nata = "12/10/1999";
		    $sponsorizzata = 0;

        $stmt->bind_param("ssssssssissssssssii", $nome, $campo1, $nome_campo1, $campo2, $nome_campo2, $campo3, $nome_campo3, $card_info, $telefono, $email, $info, $sitoweb, $sede, $nata, $immagine, $immagine, $tipo, $sponsorizzata, $id);
        if ($stmt->execute() === TRUE) {
          $conn->close();
          header("location: profile.php?find=true");
        }

    }


    function getActive($email){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $email = $conn->real_escape_string($email);

      $sql = "SELECT active FROM users WHERE username=?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result->fetch_assoc();
    }

    function setActive($email){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $email = $conn->real_escape_string($email);
      $active = 1;

      $sql = "UPDATE users SET active=? WHERE username=?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("is", $active, $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result->fetch_assoc();
    }



    //funzione per ottenere l'hash

    function getHash($email){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $email = $conn->real_escape_string($email);

      $sql = "SELECT hash FROM users WHERE username=?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result->fetch_assoc();
    }

    

    function changePassword($email, $password){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "UPDATE users SET password=? WHERE username=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $password, $email);

      $stmt->execute();
      $conn->close();
    }
    /*
      FINE
      FUNZIONI PER LA REGISTRAZIONE E L'ACCESSO
      Register.php Login.php
    */

    /*
      INIZIO
      FUNZIONI DI AIUTO
    */

    function ricerca($campo){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $campo = $conn->real_escape_string($campo);

      $sql = "SELECT ragione as type, id , ragione AS val
      							FROM  azienda
      							WHERE  ragione LIKE '%".$campo."%'";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    }

    function findByName($nome){
      $nome = str_replace("%20"," ",$nome);
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $sql = "SELECT * FROM azienda WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $nome);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $conn->close();
      return $row;
    }

    function findByUser($username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);

      $sql = "SELECT * FROM azienda WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $row['id']);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $conn->close();
      return $row;
    }

    function getId($user){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT id FROM users
                WHERE username = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $user);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $conn->close();
      return $row;
    }

    function update($elements, $username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);

      $sql = "UPDATE azienda SET ragione=?, campo_1=?, nome_campo_1=?, campo_2=?, nome_campo_2=?, campo_3=?, nome_campo_3=?, info=?, sede=?, nata=? WHERE id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssssssi", $elements[0], $elements[1], $elements[2], $elements[3], $elements[4], $elements[5], $elements[6], $elements[7], $elements[8], $elements[9], $row['id']);

      $stmt->execute();
      $conn->close();
    }

    function find($user){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT * FROM azienda JOIN users
                ON azienda.id = users.id
             WHERE username = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $user);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $conn->close();
      return $row;
    }

    function newPost($elements, $username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);

      $sql = "INSERT INTO `post`(`descrizione`, `nome_progetto`, `link`, `data`, `posted`, `postimage`, `id_azienda`) VALUES (?,?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $p = 1;
      $data =  date('d-m-Y H:i:s');
      $stmt->bind_param("ssssisi", $elements[1], $elements[0], $elements[2], $data, $p, $elements[3], $row['id']);

      $stmt->execute();
      $conn->close();
    }

    function loadCards($id){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT post.* FROM post JOIN azienda
                ON azienda.id = post.id_azienda
             WHERE azienda.id = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();
      return $result;
    }

    function loadCardsById($ragione){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT post.* FROM post JOIN azienda
                ON azienda.id = post.id_azienda
             WHERE azienda.id = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $ragione);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();
      return $result;
    }

    function profile($nome, $id){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT * FROM azienda JOIN users
                ON azienda.id = users.id
             WHERE username = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $nome);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $conn->close();

      if($id == $row['id']){
        return true;
      }else{
        return false;
      }
    }

    /*
      INIZIO
      Funzioni per index.php
    */
    function caricaAziende($val){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT * FROM payments";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $datacontrollo = date('d');

      while($row = $result->fetch_assoc()){
        $datapagamento = $row['createdtime'];
        $id = $row['compratore'];
        $idpayment = $row['id'];

        if($datacontrollo != $datapagamento){
          $sql = "SELECT * FROM azienda WHERE id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $id);

          $stmt->execute();
          $resulto = $stmt->get_result();
          $azienda = $resulto->fetch_assoc();
          if($azienda['sponsorizzata'] > 0){
            $sponsorizzata = $azienda['sponsorizzata'] - 1;
          }else{
            $sponsorizzata = 0;
          }

          $sql = "UPDATE azienda SET sponsorizzata=? WHERE id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ii", $sponsorizzata, $id);

          $stmt->execute();

          $sql = "UPDATE payments SET createdtime=? WHERE id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("si", $datacontrollo, $idpayment);

          $stmt->execute();
        }
      }

      $sql = "SELECT * FROM azienda ORDER BY sponsorizzata DESC LIMIT $val, 10";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result;
    }

    function trendingAziende(){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT azienda.* FROM azienda JOIN statistica ON azienda.id = statistica.id_azienda WHERE settimana=? ORDER BY visualizzazioni DESC LIMIT 10";

      $stmt = $conn->prepare($sql);
      $data = date("W/Y");
      $stmt->bind_param("s", $data);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result;
    }

    function recentiAziende($val){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT * FROM azienda ORDER BY id DESC LIMIT $val, 10";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result;
    }

    function nAziende($tipo){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $tipo = str_replace("%20"," ",$tipo);
      $campo = implode("", explode("data", $tipo, 2));
      if($tipo == "no"){
        $sql = "SELECT COUNT(id) AS N FROM azienda";
      }else if (strpos($tipo, 'data') === false) {
        $sql = "SELECT COUNT(id) AS N FROM azienda WHERE tipoazienda='" . $tipo . "'";
      }else{
        $sql = "SELECT COUNT(id) AS N FROM azienda WHERE ragione LIKE '%" . $campo . "%'";
      }
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result->fetch_assoc();
    }

    /*
      FINE
      FUNZIONI PER INDEX.PHP
      */



    function uploadImage($username, $urlfile, $tipo){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);

      $sql = "UPDATE azienda SET " . $tipo . "=? WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si", $urlfile, $row['id']);

      $stmt->execute();
      $conn->close();
    }

    function getOldImage($username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);
      $sql = "SELECT * FROM azienda WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $row['id']);

      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result->fetch_assoc();
    }

    function getPostImage($id){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $sql = "SELECT * FROM post WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id);

      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result->fetch_assoc();
    }

    function deletePost($id){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $sql = "DELETE FROM post WHERE post.id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id);

      $stmt->execute();
      $conn->close();
    }

    function addVisual($id){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "UPDATE `statistica` SET `visualizzazioni`=`visualizzazioni` + 1 WHERE `id_azienda`=? AND `settimana`=?";
      $stmt = $conn->prepare($sql);
      $data = date("W/Y");
      $stmt->bind_param("ss", $id,  $data);
      $stmt->execute();
      if ($stmt->affected_rows == 0) {
        $sql = "INSERT INTO statistica (settimana,visualizzazioni,id_azienda) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $a = 1;
        $stmt->bind_param("sii", $data, $a, $id);
        if ($stmt->execute() === TRUE) {
          $conn->close();
        }
      }
    }

    function loadStats($username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT statistica.* FROM statistica, azienda, users WHERE azienda.id = statistica.id_azienda AND azienda.id = users.id AND users.username=?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result;
    }

    function tipoAziende($tipo, $val){
      $tipo = str_replace("%20", " ", $tipo);
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);

      $sql = "SELECT azienda.* FROM azienda WHERE tipoazienda=? ORDER BY sponsorizzata DESC LIMIT $val, 10";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $tipo);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result;
    }

    function cercaAziende($data, $val){
      $tipo = str_replace("%20", " ", $tipo);
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $data = $conn->real_escape_string($data);
      $sql = "SELECT azienda.* FROM azienda WHERE ragione LIKE '%" . $data . "%' ORDER BY sponsorizzata DESC LIMIT $val, 10";

      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $conn->close();

      return $result;
    }

    function aggiornaInfo($campi, $username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);
      //mysql_real_escape_string
      $semaphore = false;
      $query = "UPDATE azienda SET ";
      $i = 0;
      $nCampi = 0;

      foreach ($campi as $campo) {
         if (strpos($campo, ' = -/') == false) {
           $nCampi++;
         }
      }

      foreach ($campi as $campo) {
         if (strpos($campo, ' = -/') == false) {
           $i++;
           $campo = $conn->real_escape_string($campo);
           if($i == $nCampi){
             $query .= explode(" = ", $campo)[0] . ' = "'.explode(" = ", $campo)[1].'"' . " ";
           }else{
             $query .= explode(" = ", $campo)[0] . ' = "'.explode(" = ", $campo)[1].'"' . ", ";
           }
         }
      }

      $query .= ' WHERE id = ' . $row['id'];
      $conn->query($query);
      $conn->close();
    }

    function updatePayment($username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);

      $sql = "INSERT INTO payments (compratore, prezzo, stato, itemid, createdtime, datapagamento) VALUES (?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $data =  date('d');
      $stato = "verificato";
      $prezzo = 5.00;
      $itemid = 1;
      $id = $row['id'];
      $stmt->bind_param("iissss", $id, $prezzo, $stato, $itemid, $data, $data);

      $stmt->execute();
      $conn->close();
    }

    function sponsorizza($username){
      $conn = $this->connect($this->servername, $this->database, $this->username, $this->password);
      $row = $this->getId($username);

      $sql = "UPDATE azienda SET sponsorizzata=? WHERE id=?";
      $stmt = $conn->prepare($sql);
      $p = 7;
      $stmt->bind_param("ii", $p, $row['id']);

      $stmt->execute();
      $conn->close();
    }

  }

?>
