<?php
/**
 * toDoClass class
 * it controls the hole server part of the application
*/
require_once "ControllerInterface.php";
require_once "../model/ReservationTime.php";
require_once "../model/Reservation.php";
require_once "../model/TablePreference.php";
require_once "../model/persist/ReservationADO.php";
require_once "../model/persist/ReservationTimeADO.php";
require_once "../model/persist/TablePreferenceADO.php";
require_once "../model/persist/SpecialRequestADO.php";
require_once "../model/persist/ReservationsSpecialRequestsADO.php";


class ReservationControllerClass implements ControllerInterface {
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
				$outPutData = $this->insertReservation();
				break;
			case 10020:
				$outPutData = $this->getAllReservations();
				break;
			case 10030:
				$outPutData = $this->modifyReservation();
				break;
			case 10040:
				$outPutData = $this->removeReservation();
				break;
			default:
				echo "There has been an error in the server";
				error_log("Action not correct in UserControllerClass, value: ".$this->getAction());
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
			$reservationTimes = array();
			$tablePreferences = array();
			$specialRequests = array();

			$outPutData[]=true;

			$reservationTimesList = ReservationTimeADO::findAll();

			if (count($reservationTimesList)!=0)
			{

				foreach ($reservationTimesList as $reservationTime)
				{
					$reservationTimes[]=$reservationTime->getAll();
				}
			} else {
				$outPutData[0] = false;
				$errors[]="No reservation times found in the data base";
				error_log("ReservationControllerClass (downloadInitData): No reservation times found in the data base");
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
				error_log("ReservationControllerClass (downloadInitData): No table preferences found in the data base");
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
				error_log("ReservationControllerClass (downloadInitData): No especial requests found in the data base");
			}

			if($outPutData[0])
			{
				$outPutData[]=$reservationTimes;
				$outPutData[]=$tablePreferences;
				$outPutData[]=$specialRequests;
			} else {
				$outPutData[]=$errors;
			}

			return $outPutData;
	}

	private function insertReservation () {
		//We get all data from client
		$reservationObj = json_decode(stripslashes($this->getJsonData()));

		$reservation = new Reservation();

		$reservationDate =date_create(
		$reservationObj->reservationDate->date->year ."-".
		$reservationObj->reservationDate->date->month ."-".
		$reservationObj->reservationDate->date->day);

		$reservationTime = new ReservationTime();
		$reservationTime->setAll(
			$reservationObj->reservationTime->id,
			$reservationObj->reservationTime->time);

		$tablePreference = new TablePreference();
		$tablePreference->setAll(
			$reservationObj->tablePreference->id,
			$reservationObj->tablePreference->preference,
			$reservationObj->tablePreference->price);

		$especialrequests = array();
		foreach ($reservationObj->specialRequests as $specialRequestObj) {
			$specialRequest = new SpecialRequest();
			$specialRequest->setAll(
				$specialRequestObj->id,
				$specialRequestObj->request,
				$specialRequestObj->price);

				$especialrequests[] = $specialRequest;
		}

		$reservation->setAll(0, $reservationObj->name,
									$reservationObj->surname,
									$reservationObj->email,
									$reservationDate,
									$reservationTime,
									$reservationObj->totalPrice,
									$tablePreference,
									$especialrequests,
									$reservationObj->phone
		);

		$reservation->setId(reservationADO::create($reservation));

		foreach ($reservation->getSpecialRequests() as $specialRequest) {
			$reservationsSpecialRequests = new ReservationsSpecialRequests();
			$reservationsSpecialRequests->setAll(0,
				$reservation->getId(),
				$specialRequest->getId()
			);

			reservationsSpecialRequestsADO::create($reservationsSpecialRequests);
		}

		$outPutData = array();
		$outPutData[]= true;
		$outPutData[]= array($reservation->getAll());

		return $outPutData;
	}

	private function modifyReservation()
	{
		//Films modification
		$outPutData = array();

		$reservationObj = json_decode(stripslashes($this->getJsonData()));
		$reservationDate=date_create($reservationObj->reservationDate->date->year."-".$reservationObj->reservationDate->date->month."-".$reservationObj->reservationDate->date->day);

		$reservationTime = new ReservationTime();
		$reservationTime->setAll($reservationObj->reservationTime->id, $reservationObj->reservationTime->time);

		$tablePreference = new TablePreference();
		$tablePreference->setAll($reservationObj->tablePreference->id, $reservationObj->tablePreference->preference, $reservationObj->tablePreference->price);

		$specialRequests = array();
		foreach($reservationObj->specialRequests as $specialRequestObj)
		{
			$specialRequest = new SpecialRequest();
			$specialRequest->setAll($specialRequestObj->id, $specialRequestObj->request, $specialRequestObj->price);

			$specialRequests[] = $specialRequest;
		}

		$reservation = new Reservation();
		$reservation->setAll($reservationObj->id, $reservationObj->name, $reservationObj->surname, $reservationObj->email, $reservationDate, $reservationTime, $reservationObj->totalPrice, $tablePreference, $specialRequests, $reservationObj->telephone);

		reservationADO::update($reservation);

		$reservationsSpecialRequests= new ReservationsSpecialRequests();
		$reservationsSpecialRequests->setReservationId($reservation->getId());
		ReservationsSpecialRequestsADO::deleteByReservationId($reservationsSpecialRequests);


		$i = 0;
		foreach($reservation->getSpecialRequests() as $specialRequest)
		{
			$reservationsSpecialRequests= new ReservationsSpecialRequests();
			$reservationsSpecialRequests->setAll(0,$reservation->getId(), $reservation->getSpecialRequests()[$i]->getId());

			ReservationsSpecialRequestsADO::create($reservationsSpecialRequests);
			$i++;
		}


		//the senetnce returns de id of the reservation inserted
		$outPutData[]= "true";
		$outPutData[]= $reservation->getAll();

		return $outPutData;
	}

	private function removeReservation()
	{
		//Films modification
		$outPutData = array();

		$reservationObj = json_decode(stripslashes($this->getJsonData()));

		try {
			$reservationDate=date_create($reservationObj->reservationDate->date->year."-".$reservationObj->reservationDate->date->month."-".$reservationObj->reservationDate->date->day);

			$reservationTime = new ReservationTime();
			$reservationTime->setAll($reservationObj->reservationTime->id, $reservationObj->reservationTime->time);

			$tablePreference = new TablePreference();
			$tablePreference->setAll($reservationObj->tablePreference->id, $reservationObj->tablePreference->preference, $reservationObj->tablePreference->price);

			$specialRequests = array();
			foreach($reservationObj->specialRequests as $specialRequestObj)
			{
				$specialRequest = new SpecialRequest();
				$specialRequest->setAll($specialRequestObj->id, $specialRequestObj->request, $specialRequestObj->price);

				$specialRequests[] = $specialRequest;
			}

			$reservation = new Reservation();
			$reservation->setAll($reservationObj->id, $reservationObj->name, $reservationObj->surname, $reservationObj->email, $reservationDate, $reservationTime, $reservationObj->totalPrice, $tablePreference, $specialRequests, $reservationObj->telephone);

			reservationADO::delete($reservation);

			//the senetnce returns de id of the reservation inserted
			$outPutData[]= "true";
			$outPutData[]= $reservation->getAll();

		} catch (Exception $e) {
			$outPutData[]= "false";
			echo 'ReservationControllerClass(removeReservation) Caught exception: ',  $e->getMessage(), "\n";
		}

		return $outPutData;
	}

	private function getAllReservations()
	{
		$outPutData = array();
		$reservations = array();

		$reservationsList = ReservationADO::findAll();

		if (count($reservationsList)!=0)
		{

			foreach ($reservationsList as $reservation)
			{
				$reservations[]=$reservation->getAll();
			}
		}
		$outPutData[] = "true";
		$outPutData[] = $reservations;

		return $outPutData;
	}
}
?>
