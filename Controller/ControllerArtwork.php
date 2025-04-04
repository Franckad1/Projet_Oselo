<?php

namespace Controller;

use Model, Manager;
use PDOException;


class ControllerArtwork extends Controller
{
  public function __construct()
  {
    $this->model = new Model\ModelArtwork;
  }
  public function viewALL()
  {
    $params = [
      'title' => '',
      'artworks' => $this->model->join()
    ];
    $this->render('artwork/artworks.html', $params);
  }

  public function new()
  {
    $ctlWarehouse = new ControllerWarehouse;

    if (!empty($_POST)) {
      if (empty($_POST['title'])) $error = "Add a title please";
      else if (empty($_POST['artist_name'])) $error = "Add an artist name please";
      else if (empty($_POST['year'])) $error = "Add a year";
      else if (empty($_POST['size'])) $error = "Add a size";
      else if (empty($_POST['id_warehouse'])) $error = "Choose a Warehouse";
      else {
        try {

          if ($this->model->insertInto($_POST)) {
            $_SESSION['Message'] = "L'oeuvre a été ajouter avec succes";
          } else {
            $_SESSION['Message'] = "Oups une erreur c'est produite";
          }
        } catch (PDOException $e) {
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }
        header("Location:" . Manager\Config::URL . "artwork/viewALL");
        exit;
      }
    }
    $params = [
      'title' => 'New artwork',
      'warehouses' => $ctlWarehouse->model->selectAll(),
      'errorMessage' => $error
    ];
    $this->render('artwork/newArtwork.html', $params);
  }

  public function edit($id)
  {
    $ctlWarehouse = new ControllerWarehouse;
    if (empty($_POST)) {
      $params = [
        'title' => $this->model->selectById($id)->title,
        'current' => $this->model->selectById($id),
        'warehouses' => $ctlWarehouse->model->selectAll()
      ];
    } else {
      if (empty($_POST['title'])) {
        $error = "Add a title please";
        $params = [
          'title' => $this->model->selectById($id)->title,
          'current' => $this->model->selectById($id),
          'warehouses' => $ctlWarehouse->model->selectAll(),
          'errorMessage' => $error
        ];
      } else if (empty($_POST['artist_name'])) $error = "Add an artist name please";
      else if (empty($_POST['year'])) $error = "Add a year";
      else if (empty($_POST['size'])) $error = "Add a size";
      else if (empty($_POST['id_warehouse'])) $error = "Choose a Warehouse";
      else {
        try {
          $this->model->update($_POST, $id);
        } catch (PDOException $e) {
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }
        header("Location:" . Manager\Config::URL . "artwork/viewALL");
        exit;
      }
    }
    $params = [
      'title' => 'Update Artwork',
    ];
    $this->render('artwork/newArtwork.html', $params);
  }
}
