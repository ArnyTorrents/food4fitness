<?php
require_once "EntityInterface.php";
class ProductType implements EntityInterface {
  private $id;
  private $name;
  private $description;

  function __construct() {
  }
  //getters
  public function getId(){
    return $this->id;
  }
  public function getName(){
    return $this->name;
  }
  public function getDescription(){
    return $this->description;
  }
  //setters
  public function setId($id){
    $this->id= $id;
  }
  public function setName($name){
    $this->name = $name;
  }
  public function setDescription($description){
    $this->description = $description;
  }
  //getAllFunction
  public function getAll(){
    $data = array();
    $data["id"] = $this->id;
    $data["name"] = $this->name;
    $data["description"] = $this->description;

    return $data;
  }
  public function setAll($id,$name,$description){
    $this->setId($id);
    $this->setName($name);
    $this->setDescription($description);
  }

}

?>
