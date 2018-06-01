<?php
class Encryption{

  static function encrypt($password){
    $salt = self::getSalt($password);
    return $password[0] . self::cripta($password, $salt);
  }
  
  static function cripta($password, $salt){
      return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $password, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
  }

  static function decrypt($password){
      $salt = self::getSalt($password);
      return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode(substr($password, 1)), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
  }

  static function hashpass($password, $email){
      $salt = md5($email);
      return crypt($password,'$1$'.$salt.'$');
  }

  static function getSalt($password){
    $salt = "";
    switch ($password[0]){
      case "a": $salt = md5('bella');
      case "b": $salt = md5('fra');
      case "c": $salt = md5('come');
      default : $salt = md5('stai');
    }
    return $salt;
  }
}
?>
