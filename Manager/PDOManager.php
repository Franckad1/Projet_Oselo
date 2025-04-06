<?php

namespace Manager;

class PDOManager
{
  // Propriété statique pour stocker l'instance PDO (connexion à la BDD)
  private static $pdo = null;

  // Constructeur privé pour empêcher l’instanciation directe depuis l’extérieur
  private function __construct()
  {
    // Vérifie si la connexion n’a pas encore été établie
    if (is_null(self::$pdo)) {
      // Initialise la connexion PDO avec les infos de config
      self::$pdo = new \PDO(
        'mysql:host=' . Config::HOST . ';charset=utf8;dbname=' . Config::DBNAME,
        'root',
        '',
        array(
          \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, // Retourne les résultats sous forme d'objets
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION      // Active les exceptions en cas d’erreur SQL
        )
      );
    }
  }

  // Méthode publique et statique pour obtenir l’instance PDO
  public static function getPDO()
  {
    // Crée une instance de la classe, ce qui déclenche le constructeur privé
    $instance = new self;

    // Retourne la connexion PDO stockée
    return $instance::$pdo;
  }
}
