<?php
namespace Controller;

use Model;


class ControllerArtwork extends Controller{
  public function __construct(){
    $this->model=new Model\ModelArtwork;
  }
  public function view($id){
    $ctlWarehouse = new ControllerWarehouse;
    $params=[
      'title'=>$this->model->selectById($id)->title,
      'artwork'=>$this->model->selectById($id),
      'warehouses'=>$ctlWarehouse->model->selectAll()
      ];
    
    $this->render('artwork/newArtwork.html',$params);
  }
  public function new(){
    $params=[
      'title'=>'New artwork'
    ];
    if(empty($_POST)){
    }else{
      $this->model->insertInto($_POST);
    }

   
    $this->render('artwork/newArtwork.html',$params); 
  }

  public function edit($id){
    $ctlWarehouse = new ControllerWarehouse;
    if(empty($_POST)){
      $params=[
        'title'=>$this->model->selectById($id)->title,
        'current'=>$this->model->selectById($id),
        'warehouses'=>$ctlWarehouse->model->selectAll()
        ];
      
        $this->render('artwork/newArtwork.html',$params);
      }else{
        $params=[
          'title'=>'Update Artwork',
          ];
         $this->model->update($_POST,$id);
        }
      $this->render('artwork/newArtwork.html',$params);
  }

  public function delete($id){
    $ctlWarehouse = new ControllerWarehouse;
    $this->model->delete($id);
    $params=[
      'title'=>'Accueil Oselo',
      'artworks'=>$this->model->selectAll(),
      'warehouses'=>$ctlWarehouse->model->selectAll()
    ];
    $this->render('home.html',$params);
  }

}
