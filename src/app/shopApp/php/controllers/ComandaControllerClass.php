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
require_once "../model/User.php";
//ados
require_once "../model/persist/ComandaADO.php";

class ComandaControllerClass implements ControllerInterface {
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
			case 10020:
				$outPutData = $this->listComandas();
				break;
			case 10030:
				$outPutData = $this->modifyComanda();
				break;
			default:
				echo "There has been an error in the server";
				error_log("Action not correct in Comanda Controller, value: ".$this->getAction());
				break;
		}

		return $outPutData;
	}

	private function insertComanda () {
		//We get all data from client
		$comandaObj = json_decode(stripslashes($this->getJsonData()));

		$comanda = new Comanda();

		$comanda->setAll(
                  $comandaObj->id,
									$comandaObj->idUser,
									$comandaObj->totalPrice,
									$comandaObj->date,
									$comandaObj->methodsOfPayment,
									$comandaObj->paid,
									$comandaObj->status
		);

		$comanda->setId(ComandaADO::create($comanda));

		$outPutData = array();
		$outPutData[]= true;
		$outPutData[]= $comanda->getId();

		return $outPutData;
	}

	private function listComandas(){
		$userObj = json_decode(stripslashes($this->getJsonData()));
		//$comanda = new Comanda();
		$id = $userObj->id;

		$outPutData = array();
		$comandas = array();

		$comandaList = ComandaADO::findAll($id);

		if (count($comandaList)!=0)
		{
			foreach ($comandaList as $comanda)
			{
				$comandas[]=$comanda->getAll();
			}
		}
		$outPutData[] = "true";
		//$outPutData[]=count($ProductsList);
		$outPutData[] = $comandas;

		return $outPutData;
	}

	private function modifyComanda(){
		$outPutData = array();
		$comandaObj = json_decode(stripslashes($this->getJsonData()));
		try {
			$comanda = new Comanda();
			$comanda->setAll($comandaObj->id,
											 $comandaObj->idUser,
											 $comandaObj->totalPrice,
											 $comandaObj->date,
											 $comandaObj->methodOfPayment,
											 $comandaObj->paid,
										   $comandaObj->status);

			ComandaADO::update($comanda);

			//the senetnce returns de id of the Product inserted
			$outPutData[]= "true";
			$outPutData[]= $comanda->getAll();
		} catch (Exception $e) {
			$outPutData[]= "false";
			echo 'ComandaControler Class(modifyProduct) Caught exception: ',  $e->getMessage(), "\n";
		}

		return $outPutData;
	}
}
?>
