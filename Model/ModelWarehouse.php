<?php
namespace Model;
class ModelWarehouse extends Model{
public function __construct() {
  Parent::__construct();
  $this->IDTable='id_warehouse';
  $this->nomTable='warehouse';
  $this->propriete=['name','adress'];
}

}