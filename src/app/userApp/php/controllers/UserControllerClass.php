<?php
/**
* toDoClass class
* it controls the hole server part of the application
*/
require_once "ControllerInterface.php";
require_once "../model/User.php";
require_once "../model/persist/UserADO.php";


class UserControllerClass implements ControllerInterface {
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
				$outPutData = $this->userConnection();
				break;
			case 10010:
				$outPutData = $this->entryUser();
				break;
			case 10020:
				$outPutData = $this->modifyUser();
				break;
			case 10030:
				$outPutData = $this->sessionControl();
				break;
			case 10080:
				$outPutData = $this->deleteUser();
				break;
			case 10040:
				//Closing session
				session_unset();
				session_destroy();
				$outPutData[0]=true;
			break;
			case 10050:
				$outPutData = $this->uploadUsersImages();
				break;
			case 10060:
				$outPutData = $this->removeUsersImages();
				break;
			case 10070:
				$outPutData = $this->downloadUsers();
				break;
			default:
				echo "There has been an error in the server";
				error_log("Action not correct in UserControllerClass, value: ".$this->getAction());
				break;
		}

		return $outPutData;
	}

	private function downloadUsers(){
		$outPutData = array();
		$outPutData[]=true;
		$errors = array();

		$listUsers = userADO::findAll();

		if(count($listUsers)==0){
			$outPutData[0]=false;
			$errors[]="No Users found in database";
		}
		else{
			$usersArray=array();

			foreach ($listUsers as $user){
				$usersArray[]=$user->getAll();
			}
		}

		if($outPutData[0]){
			$outPutData[]=$usersArray;
		}
		else{
			$outPutData[]=$errors;
		}

		return $outPutData;
	}


	private function entryUser()
	{
		$usersArray = json_decode(stripslashes($this->getJsonData()));

		$user = new User();
		$user->setId($usersArray->id);
		$user->setName($usersArray->name);
		$user->setSurname($usersArray->surname);
		$user->setAddress($usersArray->address);
		$user->setRole($usersArray->role);
		$user->setCountry($usersArray->country);
		$user->setProvince($usersArray->province);
		$user->setDoor($usersArray->door);
		$user->setPhone($usersArray->phone);
		$user->setNickName($usersArray->nickName);
		$user->setPassword($usersArray->password);
		$user->setImg($usersArray->img);

		$outPutData = array();
		$outPutData[]= true;
		$user->setId(userADO::create($user));

		//the senetnce returns de id of the user inserted
		$outPutData[]= array($user->getAll());

		return $outPutData;
	}

	private function modifyUser()
	{
		//Films modification
		$usersArray = json_decode(stripslashes($this->getJsonData()));
		$outPutData = array();
		$outPutData[]= true;
			$user = new User();
			$user->setId($usersArray->id);
			$user->setName($usersArray->name);
			$user->setSurname($usersArray->surname);
			$user->setAddress($usersArray->address);
			$user->setRole($usersArray->role);
			$user->setCountry($usersArray->country);
			$user->setProvince($usersArray->province);
			$user->setDoor($usersArray->door);
			$user->setPhone($usersArray->phone);
			$user->setNickName($usersArray->nickName);
			$user->setPassword($usersArray->password);
			$user->setImg($usersArray->img);
			$outPutData[1] = userADO::update($user);
		return $outPutData;
	}

	private function deleteUser(){
		$usersArray = json_decode(stripslashes($this->getJsonData()));
		$outPutData = array();
		$outPutData[]= true;
			$user = new User();
			$user->setId($usersArray->id);
			$user->setName($usersArray->name);
			$user->setSurname($usersArray->surname);
			$user->setAddress($usersArray->address);
			$user->setRole($usersArray->role);
			$user->setCountry($usersArray->country);
			$user->setProvince($usersArray->province);
			$user->setDoor($usersArray->door);
			$user->setPhone($usersArray->phone);
			$user->setNickName($usersArray->nickName);
			$user->setPassword($usersArray->password);
			$user->setImg($usersArray->img);
			$outPutData[1] = userADO::delete($user);
		return $outPutData;
	}
	private function userConnection()
	{
		$userObj = json_decode(stripslashes($this->getJsonData()));

		$outPutData = array();
		$outPutData[]= true;

		$users = array();


		$user = new User();
		$user->setNickName($userObj->nickName);
		$user->setPassword($userObj->password);


		//$outPutData = UserADO::findByNickAndPass($user);
		$userList = UserADO::findByNickAndPass($user);


		if (count($userList)!=0)
		{
			$usersArray=array();

			foreach ($userList as $user)
			{
				$users[]=$user->getAll();
			}

			$_SESSION['connectedUser'] = $userList[0];

			$outPutData[]=$users;
		}
		else {
			$outPutData[0] = false;
			$errors[] = "Either user nick or password is not correcte, try again";
			$outPutData[]=$errors;
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

	private function uploadUsersImages()
	{
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
					move_uploaded_file($_FILES['images']['tmp_name'][$key], '../../images/usersImages/' . $newFileName);

					$newFilesName[]='images/usersImages/'.$newFileName;
				}
			}
		} catch (PDOException $e) {
			error_log("UserControllerClass (uploadUsersImages): error uploading files: " . $e->getMessage() . " ");
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
