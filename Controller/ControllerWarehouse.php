<?php

namespace Controller;

use Model, Manager;
use PDOException;

class ControllerWarehouse extends Controller
{
  public function __construct()
  {
    $this->model = new Model\ModelWarehouse;
  }
  public function new()
  {
    $error = '';
    if (!empty($_POST)) {
      if (empty($_POST['name'])) $error = "Add a name please";
      else if (empty($_POST['adress'])) $error = "Add an adress name please";
      else {
        try {
          $this->model->insertInto($_POST);
          $_SESSION['Message'] = "The artwork has been modified with success ";
        } catch (PDOException $e) {
          $_SESSION['Message'] = "Oops an error has been detected ";
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }
        header("Location:" . Manager\Config::URL);
        exit;
      }
    }
    $params = [
      'title' => 'New artwork',
      'error' => $error
    ];
    $this->render('warehouse/newWarehouse.html', $params);
  }

  public function edit($id)
  {
    if (empty($_POST)) {
      $params = [
        'title' => $this->model->selectById($id)->name,
        'current' => $this->model->selectById($id)
      ];
    } else {
      $error = '';
      if (empty($_POST['name'])) $error = "Add a name please";
      else if (empty($_POST['adress'])) $error = "Add an adress name please";
      else {
        try {
          $this->model->update($_POST, $id);
          $_SESSION['Message'] = "The artwork has been modified with success ";
        } catch (PDOException $e) {
          $_SESSION['Message'] = "Oops an error has been detected ";
          Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ') . $e->getMessage());
        }
        header("Location:" . Manager\Config::URL);
        exit;
      }
    }
    $params = [
      'title' => 'Update Warehouse',
      'error' => $error
    ];
    $this->render('warehouse/newWarehouse.html', $params);
  }
}
