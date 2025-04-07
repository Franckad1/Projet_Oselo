<?php

namespace Model;

// Classe ModelArtwork : représente la table 'artwork' et hérite des méthodes de base de Model
class ModelArtwork extends Model
{
  public function __construct()
  {
    // Appelle le constructeur du parent pour initialiser la connexion PDO
    Parent::__construct();

    // Spécifie la clé primaire de la table
    $this->IDTable = 'id_artwork';

    // Nom de la table dans la base de données
    $this->nomTable = 'artwork';

    // Liste des propriétés utilisées dans les opérations d'insertion ou mise à jour
    $this->propriete = ['id_warehouse', 'title', 'year', 'artist_name', 'size'];
  }

  // Récupère toutes les œuvres avec les informations de leur entrepôt via une jointure INNER JOIN
  public function join()
  {
    $stmt = $this->pdo->prepare(
      "SELECT * FROM warehouse w 
       INNER JOIN " . $this->nomTable . " a 
       ON w.id_warehouse = a.id_warehouse"
    );

    $stmt->execute();
    return $stmt->fetchAll();
  }

  // Récupère toutes les œuvres appartenant à un entrepôt spécifique
  public function joined($id)
  {
    $stmt = $this->pdo->prepare(
      "SELECT * FROM " . $this->nomTable . " WHERE id_warehouse = $id"
    );

    $stmt->execute();
    return $stmt->fetchAll();
  }
}
