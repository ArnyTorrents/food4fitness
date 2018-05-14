<?php
/**
 * toDoClass class
 * it controls the hole server part of the application
*/
require_once "ControllerInterface.php";
require_once "../model/products.php";
require_once "../model/productsType.php";
require_once "../model/productsComanda.php";
require_once "../model/comanda.php";
require_once "../model/persist/ProductADO.php";
require_once "../model/persist/ProductsTypeADO.php";

class ProductControllerClass implements ControllerInterface {
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

		switch ( $this->getAction() )
		{
			case 10000:
				$outPutData = $this->downloadInitData();
				break;
			case 10010:
				$outPutData = $this->insertProduct();
				break;
			case 10020:
				$outPutData = $this->getAllProducts();
				break;
			case 10030:
				$outPutData = $this->modifyProduct();
				break;
			case 10040:
				$outPutData = $this->removeProduct();
				break;
			default:
				echo "There has been an error in the server";
				error_log("Action not correct in ShopControllerClass, value: ".$this->getAction());
				break;
		}

		return $outPutData;
	}


	private function sessionControl()
	{
			$outPutData = array();
			$users=array();

			if(isset($_SESSION['connectedUser']))
			{
				$outPutData[]= true;
				$users[]=$_SESSION['connectedUser']->getAll();

				$outPutData[]=$users;
			}
			else {
				$outPutData[]= false;
			}

			return 	$outPutData;
	}

	private function downloadInitData()
	{
			$outPutData = array();
			$errors = array();
			$ProductTimes = array();
			$tablePreferences = array();
			$specialRequests = array();

			$outPutData[]=true;

			$ProductTimesList = ProductTimeADO::findAll();

			if (count($ProductTimesList)!=0)
			{

				foreach ($ProductTimesList as $ProductTime)
				{
					$ProductTimes[]=$ProductTime->getAll();
				}
			} else {
				$outPutData[0] = false;
				$errors[]="No Product times found in the data base";
				error_log("ProductControllerClass (downloadInitData): No Product times found in the data base");
			}

			$tablePreferencesList = TablePreferenceADO::findAll();

			if (count($tablePreferencesList)!=0)
			{

				foreach ($tablePreferencesList as $tablePreference)
				{
					$tablePreferences[]=$tablePreference->getAll();
				}
			} else {
				$outPutData[0] = false;
				$errors[]="No table preferences found in the data base";
				error_log("ProductControllerClass (downloadInitData): No table preferences found in the data base");
			}

			$specialRequestsList = specialRequestADO::findAll();

			if (count($specialRequestsList)!=0)
			{

				foreach ($specialRequestsList as $specialRequest)
				{
					$specialRequests[]=$specialRequest->getAll();
				}
			} else {
				$outPutData[0] = false;
				$errors[]="No especial requests found in the data base";
				error_log("ProductControllerClass (downloadInitData): No especial requests found in the data base");
			}

			if($outPutData[0])
			{
				$outPutData[]=$ProductTimes;
				$outPutData[]=$tablePreferences;
				$outPutData[]=$specialRequests;
			} else {
				$outPutData[]=$errors;
			}

			return $outPutData;
	}

	private function insertProduct () {
		//We get all data from client
		$ProductObj = json_decode(stripslashes($this->getJsonData()));

		$Product = new Product();

		$ProductDate =date_create(
		$ProductObj->ProductDate->date->year ."-".
		$ProductObj->ProductDate->date->month ."-".
		$ProductObj->ProductDate->date->day);

		$ProductTime = new ProductTime();
		$ProductTime->setAll(
			$ProductObj->ProductTime->id,
			$ProductObj->ProductTime->time);

		$tablePreference = new TablePreference();
		$tablePreference->setAll(
			$ProductObj->tablePreference->id,
			$ProductObj->tablePreference->preference,
			$ProductObj->tablePreference->price);

		$especialrequests = array();
		foreach ($ProductObj->specialRequests as $specialRequestObj) {
			$specialRequest = new SpecialRequest();
			$specialRequest->setAll(
				$specialRequestObj->id,
				$specialRequestObj->request,
				$specialRequestObj->price);

				$especialrequests[] = $specialRequest;
		}

		$Product->setAll(0, $ProductObj->name,
									$ProductObj->surname,
									$ProductObj->email,
									$ProductDate,
									$ProductTime,
									$ProductObj->totalPrice,
									$tablePreference,
									$especialrequests,
									$ProductObj->phone
		);

		$Product->setId(ProductADO::create($Product));

		foreach ($Product->getSpecialRequests() as $specialRequest) {
			$ProductsSpecialRequests = new ProductsSpecialRequests();
			$ProductsSpecialRequests->setAll(0,
				$Product->getId(),
				$specialRequest->getId()
			);

			ProductsSpecialRequestsADO::create($ProductsSpecialRequests);
		}

		$outPutData = array();
		$outPutData[]= true;
		$outPutData[]= array($Product->getAll());

		return $outPutData;
	}

	private function modifyProduct()
	{
		//Films modification
		$outPutData = array();

		$ProductObj = json_decode(stripslashes($this->getJsonData()));
		$ProductDate=date_create($ProductObj->ProductDate->date->year."-".$ProductObj->ProductDate->date->month."-".$ProductObj->ProductDate->date->day);

		$ProductTime = new ProductTime();
		$ProductTime->setAll($ProductObj->ProductTime->id, $ProductObj->ProductTime->time);

		$tablePreference = new TablePreference();
		$tablePreference->setAll($ProductObj->tablePreference->id, $ProductObj->tablePreference->preference, $ProductObj->tablePreference->price);

		$specialRequests = array();
		foreach($ProductObj->specialRequests as $specialRequestObj)
		{
			$specialRequest = new SpecialRequest();
			$specialRequest->setAll($specialRequestObj->id, $specialRequestObj->request, $specialRequestObj->price);

			$specialRequests[] = $specialRequest;
		}

		$Product = new Product();
		$Product->setAll($ProductObj->id, $ProductObj->name, $ProductObj->surname, $ProductObj->email, $ProductDate, $ProductTime, $ProductObj->totalPrice, $tablePreference, $specialRequests, $ProductObj->telephone);

		ProductADO::update($Product);

		$ProductsSpecialRequests= new ProductsSpecialRequests();
		$ProductsSpecialRequests->setProductId($Product->getId());
		ProductsSpecialRequestsADO::deleteByProductId($ProductsSpecialRequests);


		$i = 0;
		foreach($Product->getSpecialRequests() as $specialRequest)
		{
			$ProductsSpecialRequests= new ProductsSpecialRequests();
			$ProductsSpecialRequests->setAll(0,$Product->getId(), $Product->getSpecialRequests()[$i]->getId());

			ProductsSpecialRequestsADO::create($ProductsSpecialRequests);
			$i++;
		}


		//the senetnce returns de id of the Product inserted
		$outPutData[]= "true";
		$outPutData[]= $Product->getAll();

		return $outPutData;
	}

	private function removeProduct()
	{
		//Films modification
		$outPutData = array();

		$ProductObj = json_decode(stripslashes($this->getJsonData()));

		try {
			$ProductDate=date_create($ProductObj->ProductDate->date->year."-".$ProductObj->ProductDate->date->month."-".$ProductObj->ProductDate->date->day);

			$ProductTime = new ProductTime();
			$ProductTime->setAll($ProductObj->ProductTime->id, $ProductObj->ProductTime->time);

			$tablePreference = new TablePreference();
			$tablePreference->setAll($ProductObj->tablePreference->id, $ProductObj->tablePreference->preference, $ProductObj->tablePreference->price);

			$specialRequests = array();
			foreach($ProductObj->specialRequests as $specialRequestObj)
			{
				$specialRequest = new SpecialRequest();
				$specialRequest->setAll($specialRequestObj->id, $specialRequestObj->request, $specialRequestObj->price);

				$specialRequests[] = $specialRequest;
			}

			$Product = new Product();
			$Product->setAll($ProductObj->id, $ProductObj->name, $ProductObj->surname, $ProductObj->email, $ProductDate, $ProductTime, $ProductObj->totalPrice, $tablePreference, $specialRequests, $ProductObj->telephone);

			ProductADO::delete($Product);

			//the senetnce returns de id of the Product inserted
			$outPutData[]= "true";
			$outPutData[]= $Product->getAll();

		} catch (Exception $e) {
			$outPutData[]= "false";
			echo 'ProductControllerClass(removeProduct) Caught exception: ',  $e->getMessage(), "\n";
		}

		return $outPutData;
	}

	private function getAllProducts()
	{
		$outPutData = array();
		$Products = array();

		$ProductsList = ProductADO::findAll();

		if (count($ProductsList)!=0)
		{

			foreach ($ProductsList as $Product)
			{
				$Products[]=$Product->getAll();
			}
		}
		$outPutData[] = "true";
		$outPutData[] = $Products;

		return $outPutData;
	}
}
?>
