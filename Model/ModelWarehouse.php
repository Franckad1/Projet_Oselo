<?php

namespace Model;

// Classe ModelWarehouse : représente la table 'warehouse' en base de données
class ModelWarehouse extends Model
{
  public function __construct()
  {
    // Appelle le constructeur de la classe parente pour initialiser la connexion PDO
    Parent::__construct();

    // Spécifie le nom de la colonne clé primaire
    $this->IDTable = 'id_warehouse';

    // Spécifie le nom de la table
    $this->nomTable = 'warehouse';

    // Liste des colonnes utilisées pour les insertions/mises à jour
    $this->propriete = ['name', 'adress']; // ⚠️ petit typo possible : "address" ?
  }
}
