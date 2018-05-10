<?php
/** Reservation.php
* Entity Reservation
* autor  Roberto Plana
* version 2012/09
*/
require_once "BDRestaurant.php";
require_once "EntityInterfaceADO.php";
require_once "TablePreferenceADO.php";
require_once "ReservationTimeADO.php";
require_once "ReservationsSpecialRequestsADO.php";
require_once "SpecialRequestADO.php";

require_once "../model/Reservation.php";
require_once "../model/TablePreference.php";
require_once "../model/ReservationTime.php";
require_once "../model/ReservationsSpecialRequests.php";
require_once "../model/SpecialRequest.php";



class ReservationADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "reservations";
  private static $colNameId = "id";
  private static $colNameName = "name";
  private static $colNameSurname = "surname";
  private static $colNameEmail = "email";
  private static $colNameReservationDate = "reservationDate";
  private static $colNameReservationTimeId = "reservationTimeId";
  private static $colNameTotalPrice = "totalPrice";
  private static $colNameTablePreferenceId = "tablePreferenceId";
  private static $colNameTelephone = "telephone";

  //---Databese management section-----------------------
  /**
  * fromResultSetList()
  * this function runs a query and returns an array with all the result transformed into an object
  * @param res query to execute
  * @return objects collection
  */
  public static function fromResultSetList( $res ) {

    $entityList = array();
    $i=0;
    //while ( ($row = $res->fetch_array(MYSQLI_BOTH)) != NULL ) {
    foreach ( $res as $row)
    {
      //We get all the values an add into the array
      $entity = ReservationADO::fromResultSet( $row );

      $entityList[$i]= $entity;
      $i++;
    }
    return $entityList;
  }

  /**
  * fromResultSet()
  * the query result is transformed into an object
  * @param res ResultSet del qual obtenir dades
  * @return object
  */
  public static function fromResultSet( $row ) {

    //We get all the values form the query
    $id = $row[ ReservationADO::$colNameId];
    $name = $row[ ReservationADO::$colNameName ];
    $surname = $row[ ReservationADO::$colNameSurname ];
    $email = $row[ ReservationADO::$colNameEmail ];
    $reservationDate = $row[ ReservationADO::$colNameReservationDate ];
    $reservationTimeId = $row[ ReservationADO::$colNameReservationTimeId ];
    $totalPrice = $row[ ReservationADO::$colNameTotalPrice ];
    $tablePreferenceId = $row[ ReservationADO::$colNameTablePreferenceId ];
    $telephone = $row[ ReservationADO::$colNameTelephone ];

    //Object construction
    $entity = new Reservation();
    $entity->setId($id);
    $entity->setName($name);
    $entity->setSurname($surname);
    $entity->setEmail($email);
    $entity->setReservationDate($reservationDate);

    $reservationTime = new ReservationTime();
    $reservationTime->setId($reservationTimeId) ;
    $reservationTimeList  = ReservationTimeADO::findById($reservationTime);

    $entity->setReservationTime($reservationTimeList[0]);
    $entity->setTotalPrice($totalPrice);

    $tablePreference = new TablePreference();
    $tablePreference->setId($tablePreferenceId) ;
    $tablePreferenceList  = TablePreferenceADO::findById($tablePreference);

    //$entity->setTablePreference($tablePreference);
    $entity->setTablePreference($tablePreferenceList[0]);

    $specialRequests=array();

    $reservationsSpecialRequests = new ReservationsSpecialRequests();
    $reservationsSpecialRequests->setReservationId($id) ;
    $reservationsSpecialRequestsList  = ReservationsSpecialRequestsADO::findByReservationId($reservationsSpecialRequests);

    foreach ($reservationsSpecialRequestsList as $reservationsSpecialRequests)  {
      $specialRequest = new SpecialRequest();
      $specialRequest->setId($reservationsSpecialRequests->getSpecialRequestId());
      $specialRequestList  = SpecialRequestADO::findById($specialRequest);

      $specialRequests[]=$specialRequestList[0];
    }

    $entity->setSpecialRequests($specialRequests);

    $entity->setTelephone($telephone);


    return $entity;
  }

  /**
  * findByQuery()
  * It runs a particular query and returns the result
  * @param cons query to run
  * @return objects collection
  */
  public static function findByQuery( $cons, $vector ) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      echo "Error executing query.";
      error_log("Error executing query in ReservationADO: " . $e->getMessage() . " ");
      die();
    }

    $res = $conn->execution($cons, $vector);

    return ReservationADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $reservation ) {
    $cons = "select * from `".ReservationADO::$tableName."` where ".ReservationADO::$colNameId." = ?";
    $arrayValues = [$reservation->getId()];

    return ReservationADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findlikeName( $reservation ) {
    $cons = "select * from `".ReservationADO::$tableName."` where ".ReservationADO::$colNameName." like ?";
    $arrayValues = ["%".$reservation->getName()."%"];

    return ReservationADO::findByQuery($cons,$arrayValues);
  }



  /**
  * findByName()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByName( $reservation ) {
    $cons = "select * from `".ReservationADO::$tableName."` where ".ReservationADO::$colNameName." = ?";
    $arrayValues = [$reservation->getName()];

    return ReservationADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByEmail()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByEmail( $reservation ) {
    $cons = "select * from `".ReservationADO::$tableName."` where ".ReservationADO::$colNameEmail." = ?";
    $arrayValues = [$reservation->getEmail()];

    return ReservationADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByEmailAndPass()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByEmailAndPass( $reservation ) {
    //$cons = "select * from `".ReservationADO::$tableName."` where ".ReservationADO::$colNameEmail." = \"".$reservation->getEmail()."\" and ".ReservationADO::$colNameReservationDate." = \"".$reservation->getReservationDate()."\"";
    $cons = "select * from `".ReservationADO::$tableName."` where ".ReservationADO::$colNameEmail." = ? and ".ReservationADO::$colNameReservationDate." = ?";
    $arrayValues = [$reservation->getEmail(),$reservation->getReservationDate()];

    return ReservationADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll( ) {
    $cons = "select * from `".ReservationADO::$tableName."`";
    $arrayValues = [];

    return ReservationADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($reservation) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".ReservationADO::$tableName." (`name`,`surname`,`email`,`reservationDate`,`reservationTimeId`,`totalPrice`,`tablePreferenceId`,`telephone`) values (?, ?, ?, ?, ?, ?, ?, ?)";
    $arrayValues= [$reservation->getName(),$reservation->getSurname(), $reservation->getEmail(), $reservation->getReservationDate()->format('Y-m-d'), $reservation->getReservationTime()->getId(), $reservation->getTotalPrice(),
                  $reservation->getTablePreference()->getId(), $reservation->getTelephone()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $reservation->setId($id);

    return $reservation->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($reservation) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".ReservationADO::$tableName."` where ".ReservationADO::$colNameId." = ?";
    $arrayValues= [$reservation->getId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */
  public function update($reservation) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="update `".ReservationADO::$tableName."` set "
                    .ReservationADO::$colNameName." = ?, "
                    .ReservationADO::$colNameSurname." = ?, "
                    .ReservationADO::$colNameEmail." = ?, "
                    .ReservationADO::$colNameReservationDate." = ?, "
                    .ReservationADO::$colNameReservationTimeId." = ?, "
                    .ReservationADO::$colNameTotalPrice." = ?, "
                    .ReservationADO::$colNameTablePreferenceId." = ?, "
                    .ReservationADO::$colNameTelephone." = ? where "
                    .ReservationADO::$colNameId." = ?" ;
    $arrayValues= [$reservation->getName(),
                   $reservation->getSurname(),
                   $reservation->getEmail(),
                   $reservation->getReservationDate()->format('Y-m-d'),
                   $reservation->getReservationTime()->getId(),
                   $reservation->getTotalPrice(),
                   $reservation->getTablePreference()->getId(),
                   $reservation->getTelephone(),
                   $reservation->getId()];

    $conn->execution($cons, $arrayValues);
  }
}
?>
