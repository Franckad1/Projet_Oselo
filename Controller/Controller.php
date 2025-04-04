<?php

namespace Controller;
use Manager;
class Controller{
protected $model;
  public function render($view,$param = array()) {
    extract($param);
    require_once('View/header.html');
    require_once('View/'.$view);
    require_once('View/footer.html');
  }

  public function page404(){
    $params=[
      'title'=>'Error Page 404',
    ];
    $this->render('page404.html',$params);
  }
  public function delete($id){
    $this->model->delete($id);
    header("Location:".Manager\Config::URL);
  }
  public function home(){
    $ctlWarehouse= new ControllerWarehouse;

    $params=[
      'title'=>'Accueil Oselo',
      'warehouses'=>$ctlWarehouse->model->selectAll()
    ];
    
    $this->render('home.html',$params);
  }
}