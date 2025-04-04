<?php

namespace Manager;
class PDOManager{

  private static $pdo=null;

  
private function __construct(){
if (is_null(self::$pdo) )//S'assure que la connexion est déjà établie pour eviter d'en refaire plusieurs;
  self::$pdo= new \PDO(
    'mysql:host='.Config::HOST.';charset=utf8;dbname='.Config::DBNAME,
    'root',
    '',
    array(
      \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ,
      \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION
    )
    );
}//Instancie la connexion avec ma base de donnée,avec le nom et l'hote compris dans le fichier Config
public static function getPDO()  {
  $instance =new self; 
  return $instance::$pdo;
}
}

