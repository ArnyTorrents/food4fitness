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
			case 10050:
				$outPutData = $this->uploadProductImages();
				break;
			case 10060:
				$otuPutData = $this->removeUsersImages();
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
				//error_log("ProductControllerClass (downloadInitData): No ProductType found in the data base");
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
		$outPutData = array();
		$ProductObj = json_decode(stripslashes($this->getJsonData()));

		try {

			$product = new Products();

			$productType = new ProductType();
			$productType->setAll(
				$ProductObj->productType->id,
				$ProductObj->productType->name,
				$ProductObj->productType->description);

			$product->setAll($ProductObj->id,
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

			$outPutData[]= true;
			$outPutData[]= array($product->getAll());

		} catch (Exception $e) {
			$outPutData[]= "false";
			echo 'ProductControllerClass(InsertProduct) Caught exception: ',  $e->getMessage(), "\n";
		}

		return $outPutData;
	}

	private function modifyProduct()
	{
		//Films modification
		$outPutData = array();

		$ProductObj = json_decode(stripslashes($this->getJsonData()));
		try {
			$ProductType = new ProductType();
			$ProductType->setAll($ProductObj->productType->id,
			 										 $ProductObj->productType->name,
													 $ProductObj->productType->description);

			$product = new Products();
			$product->setAll($ProductObj->id,
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
		} catch (Exception $e) {
			$outPutData[]= "false";
			echo 'ProductControllerClass(modifyProduct) Caught exception: ',  $e->getMessage(), "\n";
		}

		return $outPutData;
	}

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

	private function uploadProductImages() {

	$filesNames = json_decode(stripslashes($this->getJsonData()));

	$outPutData = array();
	$outPutData[]= true;
	$newFilesName = array();

	$i=0;

	try {
		foreach($_FILES['images']['error'] as $key => $error){
			if($error == UPLOAD_ERR_OK){
				$name = $_FILES['images']['name'][$key];
				$fileNameParts = explode(".", $name);
				$nameWithoutExtension = $fileNameParts[0];
				$extension = end($fileNameParts);
				$newFileName = $filesNames[$i].".".$extension;
				move_uploaded_file($_FILES['images']['tmp_name'][$key], '../../images/' . $newFileName);

				$newFilesName[]='images/'.$newFileName;
			}
		}
	} catch (PDOException $e) {
		error_log("ProductControllerClass (uploadProductImages): error uploading files: " . $e->getMessage() . " ");
		$errors = array();
		$outPutData[]=false;
		$errors[]="Sorry, there has been an error. Try later";
		$outPutData[]=$errors;
	}
	$outPutData[]=$newFilesName;
	return $outPutData;

}

private function removeUsersImages()
{
	$outPutData = array();

	$filesToDeleteArray = json_decode(stripslashes($this->getJsonData()));

	foreach($filesToDeleteArray as $filename){
		if(file_exists('../../'.$filename)) unlink('../../'.$filename);
	}

	$outPutData[]=true;

	return $outPutData;
}


}
?>
