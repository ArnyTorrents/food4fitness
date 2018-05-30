<?php
require_once "EntityInterface.php";
class ProductsComanda implements EntityInterface {

  private $idComanda;
  private $idProducto;
  private $quantitat;

  function __construct() {
  }
  //getters
  public function getIdComanda(){
    return $this->idComanda;
  }
  public function getIdProduct(){
    return $this->idProducto;
  }
  public function getQuantitat(){
    return $this->quantitat;
  }
  //setters
  public function setIdComanda($idComanda){
    $this->idComanda = $idComanda;
  }
  public function setIdProducto($idProducto){
    $this->idProducto = $idProducto;
  }
  public function setQuantitat($quantitat){
    $this->quantitat = $quantitat;
  }
  //getAllFunction
  public function getAll(){
    $data = array();
    $data["idComanda"] = $this->idComanda;
    $data["idProducto"] = $this->idProducto;
    $data["quantitat"] = $this->quantitat;
  }
  //setAllFunction
  public function setAll($idComanda,$idProducto,$quantitat){
    $this->setIdComanda($idComanda);
    $this->setIdProducto($idProducto);
    $this->setQuantitat($quantitat);
  }

}
?>
