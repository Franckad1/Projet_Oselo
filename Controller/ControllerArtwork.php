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
    $params = [
      'title' => $this->model->selectById($id)->title,
      'current' => $this->model->selectById($id),
      'warehouses' => $ctlWarehouse->model->selectAll(),

    ];
    if (!empty($_POST)) {
      if (empty($_POST['title'])) {
        $params = [
          'title' => $this->model->selectById($id)->title,
          'current' => $this->model->selectById($id),
          'warehouses' => $ctlWarehouse->model->selectAll(),
          'error' => 'Insert a title'
        ];
        $this->render('artwork/newArtwork.html', $params);
      } else if (empty($_POST['artist_name'])) {
        $params = [
          'title' => $this->model->selectById($id)->title,
          'current' => $this->model->selectById($id),
          'warehouses' => $ctlWarehouse->model->selectAll(),
          'error' => 'Insert an artist name'
        ];
        $this->render('artwork/newArtwork.html', $params);
      } else if (empty($_POST['year'])) {
        $params = [
          'title' => $this->model->selectById($id)->title,
          'current' => $this->model->selectById($id),
          'warehouses' => $ctlWarehouse->model->selectAll(),
          'error' => 'Insert a year of creation'
        ];
        $this->render('artwork/newArtwork.html', $params);
      } else if (empty($_POST['size'])) {
        $params = [
          'title' => $this->model->selectById($id)->title,
          'current' => $this->model->selectById($id),
          'warehouses' => $ctlWarehouse->model->selectAll(),
          'error' => 'Insert a size'
        ];
        $this->render('artwork/newArtwork.html', $params);
      } else if (empty($_POST['id_warehouse'])) {
        $params = [
          'title' => $this->model->selectById($id)->title,
          'current' => $this->model->selectById($id),
          'warehouses' => $ctlWarehouse->model->selectAll(),
          'error' => 'Choose a warehouse '
        ];
        $this->render('artwork/newArtwork.html', $params);
      } else {
        try {
          $this->model->update($_POST, $id);
          $_SESSION['Message'] = 'The update is a success';
        } catch (PDOException $e) {
          $_SESSION['Message'] = 'Oh No an error has been detected';
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }
        header("Location:" . Manager\Config::URL . "artwork/viewALL");
        exit;
      }
    }
    $this->render('artwork/newArtwork.html', $params);
  }
}
