<?php
namespace Controller;

use Model;


class ControllerArtwork extends Controller{
  public function __construct(){
    $this->model=new Model\ModelArtwork;
  }
  public function view($id){
    $params=[
      'title'=>$this->model->selectById($id)->title,
      'artwork'=>$this->model->selectById($id)
      ];
    
    $this->render('artwork/artwork.html',$params);
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
    
      $params=[
        'title'=>$this->model->selectById($id)->title,
        'current'=>$this->model->selectById($id)
        ];
    
    $this->render('artwork/newArtwork.html',$params);
  }
}
