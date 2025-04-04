<?php
namespace Controller;

use Model,Manager;


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
  public function viewALL(){
    $params=[
      'title'=>'',
      'artworks'=>$this->model->join()
    ];
    $this->render('artwork/artworks.html',$params);
  }

  public function new(){
    $ctlWarehouse = new ControllerWarehouse;
    $params=[
      'title'=>'New artwork',
      'warehouses'=>$ctlWarehouse->model->selectAll()
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
      }else{
        $params=[
          'title'=>'Update Artwork',
          ];
         $this->model->update($_POST,$id);
         header("Location:".Manager\Config::URL."artwork/viewALL");
         exit;
        }
      $this->render('artwork/newArtwork.html',$params);
  }

}
