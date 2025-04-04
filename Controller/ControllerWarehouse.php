<?php
namespace Controller;
use Model,Manager;
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
}else{
  $params=[
    'title'=>'Update warehouse',
    ];
   $this->model->update($_POST,$id);
   header("Location:".Manager\Config::URL);
   exit;
  }
$this->render('warehouse/newWarehouse.html',$params);
}

}