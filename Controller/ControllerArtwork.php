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
      'title' => 'Artworks',
      'artworks' => $this->model->join()
    ];
    $this->render('artwork/artworks.html', $params);
  }
  public function viewJoined($id)
  {
    $ctlWarehouse = new ControllerWarehouse;
    $params = [
      'title' => 'Artworks of ' . $ctlWarehouse->model->selectById($id)->name,
      'artworks' => $this->model->joined($id),
      'warehouse' => $ctlWarehouse->model->selectById($id)
    ];
    $this->render('artwork/artworks.html', $params);
  }
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
  public function new()
  {
    $error = '';
    if (!empty($_POST)) {
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
        try {
          $this->model->insertInto($_POST);
          $_SESSION['Message'] = "The artwork has been added with success";
        } catch (PDOException $e) {
          $_SESSION['Message'] = "Oh No an error has been detected";
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }
        header("Location:" . Manager\Config::URL . "artwork/viewALL");
        exit;
      }
    }
    $this->view($error);
  }
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
  public function edit($id)
  {

    if (!empty($_POST)) {
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
    $this->viewId($id, '');
  }
}
