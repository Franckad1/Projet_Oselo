<?php
namespace Controller;
use Model;
class ControllerWarehouse extends Controller{
public function __construct(){
  $this->model=new Model\ModelWarehouse;
}
public function view($id){
$params=[
  'title'=>$this->model->selectById($id)->name ,
  'warehouse'=>$this->model->selectById($id) 
];

$this->render('warehouse/newWarehouse.html',$params);
}

public function new(){
  $params=[
    'title'=>'New warehouse'
  ];
  if(empty($_POST)){
  }else{
    $this->model->insertInto($_POST);
  }

 
  $this->render('warehouse/newWarehouse.html',$params);
 
   
}
public function edit($id){
    
if(empty($_POST)){
$params=[
  'title'=>$this->model->selectById($id)->name,
  'current'=>$this->model->selectById($id)
  ];

  $this->render('warehouse/newWarehouse.html',$params);
}else{
  $params=[
    'title'=>'Update warehouse',
    ];
   $this->model->update($_POST,$id);
  }
$this->render('warehouse/newWarehouse.html',$params);
}
public function delete($id){
  $ctlArtwork = new ControllerArtwork;
$this->model->delete($id);
$params=[
  'title'=>'Accueil Oselo',
  'artworks'=>$ctlArtwork->model->selectAll(),
  'warehouses'=>$this->model->selectAll()
];
$this->render('home.html',$params);
}
}