<?php

namespace Model;

class ModelArtwork extends Model
{
  public function __construct()
  {
    Parent::__construct();
    $this->IDTable = 'id_artwork';
    $this->nomTable = 'artwork';
    $this->propriete = ['id_warehouse', 'title', 'year', 'artist_name', 'size'];
  }

  public function join()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM warehouse w INNER JOIN " . $this->nomTable . " a ON w.id_warehouse = a.id_warehouse");
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function joined($id)
  {

    $stmt = $this->pdo->prepare("SELECT * FROM " . $this->nomTable . " WHERE id_warehouse = $id");
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
