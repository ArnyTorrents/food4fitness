<?php
/**
 * toDoClass class
 * it controls the hole server part of the application
*/
require_once "ControllerInterface.php";
require_once "../model/products.php";
require_once "../model/productType.php";
require_once "../model/productsComanda.php";
require_once "../model/comanda.php";
require_once "../model/persist/ProductADO.php";
require_once "../model/persist/ProductTypeADO.php";

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
			$ProductType = array();


			$outPutData[]=true;

			$ProductTypeList = ProductTypeADO::findAll();

			if (count($ProductTypeList)!=0)
			{

				foreach ($ProductTypeList as $PType)
				{
					$ProductType[]=$PType->getAll();
				}
			} else {
				$outPutData[0] = false;
				$errors[]="No ProductType found in the data base";
				error_log("ProductControllerClass (downloadInitData): No ProductType found in the data base");
			}

			if($outPutData[0])
			{
				$outPutData[]=$ProductType;
			} else {
				$outPutData[]=$errors;
			}

			return $outPutData;
	}

	private function insertProduct () {
		//We get all data from client
		$ProductObj = json_decode(stripslashes($this->getJsonData()));

		$product = new Products();

		$productType = new ProductType();
		$productType->setAll(
			$ProductObj->productType->id,
			$ProductObj->productType->name,
			$ProductObj->productType->description);

		$product->setAll(0, $ProductObj->id,
									$productType,
									$ProductObj->name,
									$ProductObj->price,
									$ProductObj->description,
									$ProductObj->calories,
									$ProductObj->proteins,
									$ProductObj->carbohydrates,
									$ProductObj->totalFat,
									$ProductObj->stock,
									$ProductObj->goodFor,
									$ProductObj->img
		);

		$product->setId(ProductADO::create($product));

		// foreach ($product->getSpecialRequests() as $specialRequest) {
		// 	$ProductsSpecialRequests = new ProductsSpecialRequests();
		// 	$ProductsSpecialRequests->setAll(0,
		// 		$Product->getId(),
		// 		$specialRequest->getId()
		// 	);
		//
		// 	ProductsSpecialRequestsADO::create($ProductsSpecialRequests);
		// }

		$outPutData = array();
		$outPutData[]= true;
		$outPutData[]= array($product->getAll());

		return $outPutData;
	}

	private function modifyProduct()
	{
		//Films modification
		$outPutData = array();

		$ProductObj = json_decode(stripslashes($this->getJsonData()));

		$ProductType = new ProductType();
		$ProductType->setAll($ProductObj->ProductType->id, $ProductObj->ProductType->name,$ProductObj->ProductType->description);

		$product = new Products();
		$product->setAll(0, $ProductObj->id,
											$ProductType,
											$ProductObj->name,
											$ProductObj->price,
											$ProductObj->description,
											$ProductObj->calories,
											$ProductObj->proteins,
											$ProductObj->carbohydrates,
											$ProductObj->totalFat,
											$ProductObj->stock,
											$ProductObj->goodFor,
											$ProductObj->img);

		ProductADO::update($product);

		//the senetnce returns de id of the Product inserted
		$outPutData[]= "true";
		$outPutData[]= $product->getAll();

		return $outPutData;
	}

	// private function removeProduct()
	// {
	// 	//Product modification
	// 	$outPutData = array();
	//
	// 	$ProductObj = json_decode(stripslashes($this->getJsonData()));
	// 	try {
	//
	// 		$ProductType = new ProductType();
	// 		$ProductType->setAll($ProductObj->ProductType->id, $ProductObj->ProductType->name,$ProductObj->ProductType->description);
	//
	// 		$outPutData[]= "true";
	// 		$product = new Products();
	//
	// 		$product->setId($ProductObj->id);
	// 		$product->setProductType($ProductType);
	// 		$product->setName($ProductObj->name);
	// 		$product->setPrice($ProductObj->price);
	// 		$product->setDescription($ProductObj->description);
	// 		$product->setCalories($ProductObj->calories);
	// 		$product->setProteins($ProductObj->proteins);
	// 		$product->setCarbohydrates($ProductObj->carbohydrates);
	// 		$product->setTotalFat($ProductObj->totalFat);
	// 		$product->setStock($ProductObj->stock);
	// 		$product->setGoodFor($ProductObj->goodFor);
	// 		$product->setImg($ProductObj->img);
	//
	// 		$outPutData[1] = ProductADO::delete($product);
	//
	//
	// 	} catch (Exception $e) {
	// 		$outPutData[]= "false";
	// 		echo 'ProductControllerClass(removeProduct) Caught exception: ',  $e->getMessage(), "\n";
	// 	}
	//
	// 	return $outPutData;
	// }

	private function getAllProducts()
	{
		$outPutData = array();
		$products = array();

		$ProductsList = ProductADO::findAll();

		if (count($ProductsList)!=0)
		{
			foreach ($ProductsList as $product)
			{
				$products[]=$product->getAll();
			}
		}
		$outPutData[] = "true";
		//$outPutData[]=count($ProductsList);
		$outPutData[] = $products;

		return $outPutData;
	}

	private function removeProduct()
	{
		//Product modification
		$outPutData = array();

		$ProductObj = json_decode(stripslashes($this->getJsonData()));
		try {

			$productType = new ProductType();

			$productType->setId($ProductObj->ProductType->id);
			$productType->setName($ProductObj->ProductType->name);
			$productType->setDescription($ProductObj->ProductType->description);


			// $productType->setAll($ProductObj->ProductType->id,
			// 										 $ProductObj->ProductType->name,
			// 										 $ProductObj->ProductType->description);


			$product = new Products();
			$product->setAll( $ProductObj->id,
												$productType,
												$ProductObj->name,
												$ProductObj->price,
												$ProductObj->description,
												$ProductObj->calories,
												$ProductObj->proteins,
												$ProductObj->carbohydrates,
												$ProductObj->totalFat,
												$ProductObj->stock,
												$ProductObj->goodFor,
												$ProductObj->img);

			ProductADO::delete($product);

			//the senetnce returns de id of the Product inserted
			$outPutData[]= "true";
			$outPutData[]= $product->getAll();

		} catch (Exception $e) {
			$outPutData[]= "false";
			echo 'ProductControllerClass(removeProduct) Caught exception: ',  $e->getMessage(), "\n";
		}

		return $outPutData;
	}
}
?>
