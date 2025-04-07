<?php

namespace Model;

use Manager\PDOManager;
use PDOException;

// Classe abstraite Model : sert de base pour tous les modèles liés à des tables BDD
abstract class Model
{
  protected $pdo;         // Objet PDO pour la connexion à la BDD
  protected $IDTable;     // Nom de la colonne ID (clé primaire)
  protected $nomTable;    // Nom de la table en base
  protected $propriete;   // Propriétés du modèle (utilisé potentiellement par les classes filles)

  public function __construct()
  {
    // Récupère la connexion PDO via le PDOManager
    $this->pdo = PDOManager::getPDO();
  }

  // Sélectionne tous les enregistrements de la table
  public function selectAll()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $this->nomTable);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  // Sélectionne un enregistrement par son ID
  public function selectById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $this->nomTable . " WHERE " . $this->IDTable . " = $id");
    $stmt->execute();
    return $stmt->fetch();
  }

  // Insère un enregistrement dans la table
  public function insertInto($values)
  {
    // Génère la requête SQL dynamiquement à partir des clés du tableau $values
    $stmt = $this->pdo->prepare(
      "INSERT INTO " . $this->nomTable .
        "(" . implode(',', array_keys($values)) . ")" .
        " VALUES (:" . implode(',:', array_keys($values)) . ")"
    );

    $stmt->execute($values);

    // Retourne l’ID de la dernière insertion
    return $this->pdo->lastInsertId();
  }

  // Met à jour un enregistrement existant identifié par $id
  public function update($values, $id)
  {
    $chaine = [];

    // Prépare les paires clé = :clé pour la requête SQL
    foreach (array_keys($values) as $name) {
      $chaine[] = "$name = :$name";
    }

    $stmt = $this->pdo->prepare(
      "UPDATE " . $this->nomTable .
        " SET " . implode(',', $chaine) .
        " WHERE " . $this->IDTable . " = :id"
    );

    // Ajoute l'ID au tableau des valeurs
    $values['id'] = $id;

    $stmt->execute($values);
  }

  // Supprime un enregistrement par son ID
  public function delete($id)
  {
    $stmt = $this->pdo->prepare(
      "DELETE FROM " . $this->nomTable . " WHERE " . $this->IDTable . " = :id"
    );

    $stmt->execute(['id' => $id]);
  }
}
