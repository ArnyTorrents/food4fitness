<?php
require_once "EntityInterface.php";
class ProductsComanda implements EntityInterface {

  private $idComanda;
  private $idUser;
  private $quantitat;

  function __construct() {
  }
  //getters
  public function getIdComanda(){
    return $this->idComanda;
  }
  public function getIdUser(){
    return $this->idUser;
  }
  public function getQuantitat(){
    return $this->quantitat;
  }
  //setters
  public function setIdComanda($idComanda){
    $this->idComanda = $idComanda;
  }
  public function setIdUser($idUser){
    $this->idUser = $idUser;
  }
  public function setQuantitat($quantitat){
    $this->quantitat = $quantitat;
  }
  //getAllFunction
  public function getAll(){
    $data = array();
    $data["idComanda"] = $this->idComanda;
    $data["idUser"] = $this->idUser;
    $data["quantitat"] = $this->quantitat;
  }
  //setAllFunction
  public function setAll($idComanda,$idUser,$quantitat){
    $this->setIdComanda($idComanda);
    $this->setIdUser($idUser);
    $this->setQuantitat($quantitat);
  }

}
?>
