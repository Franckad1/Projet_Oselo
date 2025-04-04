<?php

namespace Model;

use Manager\PDOManager;
use PDOException;

abstract class Model
{
  protected $pdo;
  protected $IDTable;
  protected $nomTable;
  protected $propriete;
  public function __construct()
  {
    $this->pdo = PDOManager::getPDO();
  }

  public function selectAll()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $this->nomTable);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function selectById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $this->nomTable . " WHERE " . $this->IDTable . " = $id");
    $stmt->execute();
    return $stmt->fetch();
  }

  public function insertInto($values)
  {

    $stmt = $this->pdo->prepare("INSER INTO " . $this->nomTable . "(" . implode(',', array_keys($values)) .
      ") VALUES (:" . implode(',:', array_keys($values)) . ")");

    $stmt->execute($values);

    return $this->pdo->lastInsertId();
  }

  public function update($values, $id)
  {
    $chaine = array();

    foreach (array_keys($values) as $name) {
      $chaine[] = "$name = :$name";
    }

    $stmt = $this->pdo->prepare("UPDAT " . $this->nomTable . " SET " . implode(',', $chaine) . " WHERE " . $this->IDTable . " = :id");
    $values['id'] = $id;

    $stmt->execute($values);
  }
  public function delete($id)
  {

    $stmt = $this->pdo->prepare("DELETE FROM " . $this->nomTable . " WHERE " . $this->IDTable . " = :id");

    $stmt->execute(array(
      'id' => $id
    ));
  }
}
