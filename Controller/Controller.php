<?php

namespace Controller;

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

  public function home(){
    $ctlArtwork=new ControllerArtwork;
    $ctlWarehouse= new ControllerWarehouse;

    $params=[
      'title'=>'Accueil Oselo',
      'artworks'=>$ctlArtwork->model->join(),
      'warehouses'=>$ctlWarehouse->model->selectAll()
    ];
    
    $this->render('home.html',$params);
  }
}