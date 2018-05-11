<?php
require_once "EntityInterface.php";
class Products implements EntityInterface {

  private $id;
  private $productType;
  private $name;
  private $price;
  private $description;
  private $calories;
  private $proteins;
  private $carbohydrates;
  private $totalFat;
  private $stock;
  private $goodFor;
  //constructor
  function __construct() {
  }
  //getters
  public function getId(){
    return $this->id;
  }
  public function getProductType(){
    return $this->productType;
  }
  public function getName(){
    return $this->name;
  }
  public function getPrice(){
    return $this->price;
  }
  public function getDescription(){
    return $this->description;
  }
  public function getCalories(){
    return $this->calories;
  }
  public function getProteins(){
    return $this->proteins;
  }
  public function getCarbohydrates(){
    return $this->carbohydrates;
  }
  public function getTotalFat(){
    return $this->totalFat;
  }
  public function getStock(){
    return $this->$stock;
  }
  public function getGoodFor(){
    return $this->goodFor;
  }
  //setters
  public function setId($id){
    $this->id = $id;
  }
  public function setProductType($productType){
    $this->productType = $productsType;
  }
  public function setName($name){
    $this->name = $name;
  }
  public function setPrice($price){
    $this->price = $price;
  }
  public function setDescription($description){
    $this->description = $description;
  }
  public function setCalories($calories){
    $this->calories = $calories;
  }
  public function setProteins($proteins){
    $this->proteins = $proteins;
  }
  public function setCarbohydrates($carbohydrates){
    $this->carbohydrates = $carbohydrates;
  }
  public function setTotalFat($totalFat){
    $this->totalFat = $totalFat;
  }
  public function setStock($stock){
    $this->stock = $stock;
  }
  public function setGoodFor($goodFor){
    $this->goodFor = $goodFor;
  }
  //getAllFunction
  public function getAll(){
    $data = array();
    $data["id"] = $this->id;
    $data["productType"] = $this->productType;
    $data["name"] = $this->name;
    $data["price"] = $this->price;
    $data["description"] = $this->description;
    $data["calories"] = $this->calories;
    $data["proteins"] = $this->proteins;
    $data["carbohydrates"] = $this->carbohydrates;
    $data["totalFat"] = $this->totalFat;
    $data["stock"] = $this->stock;
    $data["goodFor"] = $this->goodFor;
    return $data;
  }
  //setAllFunction
  public function setAll($id,$productType,$name,$price,$description,$calories,$proteins,$carbohydrates,$totalFat,$stock,$goodFor){
    $this->setId($id);
    $this->setProductType($productType);
    $this->setName($name);
    $this->setPrice($price);
    $this->setDescription($description);
    $this->setCalories($calories);
    $this->setProteins($proteins);
    $this->setCarbohydrates($carbohydrates);
    $this->setTotalFat($totalFat);
    $this->setStock($stock);
    $this->setGoodFor($goodFor);
  }


}
?>
