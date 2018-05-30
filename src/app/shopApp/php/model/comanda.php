<?php
require_once "EntityInterface.php";
class Comanda implements EntityInterface {
  private $id;
  private $idUser;
  //private $productsComanda;
  private $totalPrice;
  private $date;
  private $methodsOfPayment;
  private $paid;
  private $status;

  function __construct() {
  }
  //getters
  public function getId(){
    return $this->id;
  }
  public function getIdUser(){
    return $this->idUser;
  }
  /*public function getProductsComanda(){
    return $this->productsComanda;
  }*/
  public function getTotalPrice(){
    return $this->totalPrice;
  }
  public function getDate(){
    return $this->date;
  }
  public function getMethodOfPayment(){
    return $this->methodsOfPayment;
  }
  public function getPaid(){
    return $this->paid;
  }
  public function getStatus(){
    return $this->status;
  }
  //setters
  public function setId($id){
    $this->id = $id;
  }
  public function setIdUser($idUser){
    $this->idUser = $idUser;
  }
  /*public function setProductsComanda($productsComanda){
    $this->prorductsComanda = $productsComanda;
  }*/
  public function setTotalPrice($totalPrice){
    $this->totalPrice = $totalPrice;
  }
  public function setDate($date){
    $this->date = $date;
  }
  public function setMethodOfPayment($methodsOfPayment){
    $this->methodsOfPayment = $methodsOfPayment;
  }
  public function setPaid($paid){
    $this->paid = $paid;
  }
  public function setStatus($status){
    $this->status = $status;
  }
  //getAllFunction
  public function getAll() {
    $data = array();
    $data["id"] = $this->id;
    $data["idUser"] = $this->idUser;
    //$data["productsComanda"] = $this->productsComanda;
    $data["setTotalPrice"] = $this->totalPrice;
    $data["setDate"] = $this->date;
    $data["methodsOfPayment"] = $this->methodsOfPayment;
    $data["paid"] = $this->paid;
    $data["status"] = $this->status;

    return $data;
  }
  //setAllFunction
  public function setAll($id, $idUser,$totalPrice,$date,$methodsOfPayment,$paid,$status) {
    $this->setId($id);
    $this->setIdUser($idUser);
    //$this->setProductsComanda($productsComanda);
    $this->setTotalPrice($totalPrice);
    $this->setDate($date);
    $this->setMethodOfPayment($methodsOfPayment);
    $this->setPaid($paid);
    $this->setStatus($status);
  }


}


?>
