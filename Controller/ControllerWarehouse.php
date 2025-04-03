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

$this->render('warehouse/warehouse.html',$params);
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

}