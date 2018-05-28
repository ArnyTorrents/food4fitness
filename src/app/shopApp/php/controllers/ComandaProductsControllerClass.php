<?php
/**
 * toDoClass class
 * it controls the hole server part of the application
*/
require_once "ControllerInterface.php";
//clases
require_once "../model/products.php";
require_once "../model/productType.php";
require_once "../model/productsComanda.php";
require_once "../model/comanda.php";
//ados
require_once "../model/persist/ComandaProductADO.php";

class ComandaProductsControllerClass implements ControllerInterface {
	private $action;
	private $jsonData;

	function __construct($action, $jsonData) {
		$this->setAction($action);
		$this->setJsonData($jsonData);
    }

    public function getAction() {
        return $this->action;
    }

    public function getJsonData() {
        return $this->jsonData;
    }

    public function setAction($action) {
        $this->action = $action;
    }
    public function setJsonData($jsonData) {
        $this->jsonData = $jsonData;
    }

	public function doAction()
	{
		$outPutData = array();

		switch ( $this->getAction() ){
			case 10010:
				$outPutData = $this->insertComanda();
				break;
			default:
				echo "There has been an error in the server";
				error_log("Action not correct in Comanda Product Controller, value: ".$this->getAction());
				break;
		}

		return $outPutData;
	}

	private function insertComanda () {
		//We get all data from client
		$comandaProduct = json_decode(stripslashes($this->getJsonData()));

		$comandaProduct = new ProductsComanda();

		$comanda->setAll(
                  $comandaProduct->idComanda,
									$comandaProduct->idUser,
									$comandaProduct->quantitat
		);

		$comanda->setId(ComandaProductADO::create($comanda));

		$outPutData = array();
		$outPutData[]= true;
		$outPutData[]= array($comanda->getAll());

		return $outPutData;
	}
}
?>
