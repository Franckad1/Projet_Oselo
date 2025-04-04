<?php
namespace Controller;

use Model,Manager;
use PDOException;
use ErrorManager;

class ControllerArtwork extends Controller{
  public function __construct(){
    $this->model=new Model\ModelArtwork;
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
    if(!empty($_POST)){
     try{
        if($this->model->insertInto($_POST)) $_SESSION['Message']="L'oeuvre a été ajouter avec succes";
        else  $_SESSION['Message']="Oups une erreur c'est produite";}
      catch(PDOException $e){
        Manager\ErrorManager::interceptionErreur(date('Y-m-d H:i ').$e->getMessage());
        var_dump($e);
      }
      
      // header("Location:".Manager\Config::URL."artwork/viewALL");
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
