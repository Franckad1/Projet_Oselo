<?php

namespace Controller;

use Model, Manager;
use PDOException;

// Contrôleur spécifique aux œuvres d'art (artworks)
class ControllerArtwork extends Controller
{
  public function __construct()
  {
    // Initialise le modèle lié aux œuvres d'art
    $this->model = new Model\ModelArtwork;
  }

  // Affiche toutes les œuvres avec leurs entrepôts associés
  public function viewALL()
  {
    $params = [
      'title' => 'Artworks',
      'artworks' => $this->model->join() // jointure avec la table warehouse
    ];
    $this->render('artwork/artworks.html', $params);
  }

  // Affiche les œuvres d’un entrepôt spécifique
  public function viewJoined($id)
  {
    $ctlWarehouse = new ControllerWarehouse;
    $warehouse = $ctlWarehouse->model->selectById($id);

    $params = [
      'title' => 'Artworks of ' . $warehouse->name,
      'artworks' => $this->model->joined($id),
      'warehouse' => $warehouse
    ];

    $this->render('artwork/artworks.html', $params);
  }

  // Affiche le formulaire pour ajouter une nouvelle œuvre, avec un éventuel message d'erreur
  public function view($error)
  {
    $ctlWarehouse = new ControllerWarehouse;

    $params = [
      'title' => 'New artwork',
      'warehouses' => $ctlWarehouse->model->selectAll(),
      'errorMessage' => $error
    ];

    $this->render('artwork/newArtwork.html', $params);
  }

  // Traitement du formulaire de création d’une œuvre
  public function new()
  {
    $error = '';

    if (!empty($_POST)) {
      // Vérifie la présence de chaque champ requis
      if (empty($_POST['title'])) {
        $error = "Add a title please";
        $this->view($error);
      } else if (empty($_POST['artist_name'])) {
        $error = "Add an artist name please";
        $this->view($error);
      } else if (empty($_POST['year'])) {
        $error = "Add a year";
        $this->view($error);
      } else if (empty($_POST['size'])) {
        $error = "Add a size";
        $this->view($error);
      } else if (empty($_POST['id_warehouse'])) {
        $error = "Choose a Warehouse";
        $this->view($error);
      } else {
        // Tout est ok, on tente d’insérer dans la BDD
        try {
          $this->model->insertInto($_POST);
          $_SESSION['Message'] = "The artwork has been added with success";
        } catch (PDOException $e) {
          $_SESSION['Message'] = "Oh No an error has been detected";
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }

        // Redirection après insertion
        header("Location:" . Manager\Config::URL . "artwork/viewALL");
        exit;
      }
    }

    // Affiche à nouveau le formulaire en cas d’erreur
    $this->view($error);
  }

  // Affiche un formulaire de modification pour une œuvre donnée
  public function viewId($id, $error)
  {
    $ctlWarehouse = new ControllerWarehouse;

    $params = [
      'title' => $this->model->selectById($id)->title,
      'current' => $this->model->selectById($id),
      'warehouses' => $ctlWarehouse->model->selectAll(),
      'errorMessage' => $error
    ];

    $this->render('artwork/newArtwork.html', $params);
  }

  // Gère la mise à jour d'une œuvre existante
  public function edit($id)
  {
    if (!empty($_POST)) {
      // Vérification des champs
      if (empty($_POST['title'])) {
        $this->viewId($id, 'Insert a title');
      } else if (empty($_POST['artist_name'])) {
        $this->viewId($id, 'Insert an artist name');
      } else if (empty($_POST['year'])) {
        $this->viewId($id, 'Insert a year of creation');
      } else if (empty($_POST['size'])) {
        $this->viewId($id, 'Insert a size');
      } else if (empty($_POST['id_warehouse'])) {
        $this->viewId($id, 'Choose a warehouse ');
      } else {
        try {
          // Mise à jour en base
          $this->model->update($_POST, $id);
          $_SESSION['Message'] = 'The update is a success';
        } catch (PDOException $e) {
          $_SESSION['Message'] = 'Oh No an error has been detected';
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }

        // Redirection post-mise à jour
        header("Location:" . Manager\Config::URL . "artwork/viewALL");
        exit;
      }
    }

    // Affiche à nouveau le formulaire si besoin
    $this->viewId($id, '');
  }
}
