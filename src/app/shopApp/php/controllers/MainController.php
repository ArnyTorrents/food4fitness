<?php
	require_once "ProductControllerClass.php";
	require_once "ComandaControllerClass.php";
	require_once "ComandaProductsControllerClass.php";
	function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}

	if ( is_session_started() === FALSE) session_start();

	if ($_SERVER['REQUEST_METHOD']!='OPTIONS')
	{
		$inputData = json_decode(file_get_contents("php://input"));

		if(isset($inputData->controller)) {$controller = $inputData->controller;}
		else{$action = $_REQUEST['controller'];}

		if(isset($inputData->action)) {$action = $inputData->action;}
		else {$action = $_REQUEST['action'];}

		if(isset($inputData->jsonData)) {$jsonData = $inputData->jsonData;}
		else {$jsonData = $_REQUEST['jsonData'];}

		if($controller=="product"){
			$productController = new ProductControllerClass( $action, $jsonData);
			$outPutData = $productController->doAction();
		}
		if($controller=="comanda"){
			$comandaController = new ComandaControllerClass( $action, $jsonData);
			$outPutData = $comandaController->doAction();
		}
		if($controller=="comandaProducts"){
			$comandaController = new ComandaControllerClass( $action, $jsonData);
			$outPutData = $comandaController->doAction();
		}

		echo json_encode($outPutData);
	}
?>
