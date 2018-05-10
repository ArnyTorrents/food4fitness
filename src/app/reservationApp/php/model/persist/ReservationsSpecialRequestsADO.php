<?php
/** TableReservationId.php
* Entity reservationClass
* autor  Roberto Plana
* version 2012/09
*/
require_once "BDRestaurant.php";
require_once "EntityInterfaceADO.php";
require_once "../model/ReservationsSpecialRequests.php";

class ReservationsSpecialRequestsADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "reservationsSpecialRequests";
  private static $colNameId = "id";
  private static $colNameReservationId = "reservationId";
  private static $colNameSpecialRequestId = "specialRequestId";

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
      $entity = ReservationsSpecialRequestsADO::fromResultSet( $row );

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
  public static function fromResultSet( $res ) {
    //We get all the values form the query
    $id = $res[ ReservationsSpecialRequestsADO::$colNameId];
    $reservationId = $res[ ReservationsSpecialRequestsADO::$colNameReservationId ];
    $specialRequestId = $res[ ReservationsSpecialRequestsADO::$colNameSpecialRequestId ];


    //Object construction
    $entity = new ReservationsSpecialRequests();
    $entity->setId($id);
    $entity->setReservationId($reservationId);
    $entity->setSpecialRequestId($specialRequestId);


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
      error_log("Error executing query in ReservationsSpecialRequestsADO: " . $e->getMessage() . " ");
      die();
    }

    //Run the query
    $res = $conn->execution($cons, $vector);

    return ReservationsSpecialRequestsADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $reservationsSpecialRequests ) {
    $cons = "select * from `".ReservationsSpecialRequestsADO::$tableName."` where ".ReservationsSpecialRequestsADO::$colNameId." = ?";
    $arrayValues = [$reservationsSpecialRequests->getId()];

    return ReservationsSpecialRequestsADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param reservationId
  * @return object with the query results
  */
  public static function findlikeName( $reservationsSpecialRequests ) {
    $cons = "select * from `".ReservationsSpecialRequestsADO::$tableName."` where ".ReservationsSpecialRequestsADO::$colNameReservationId." like ?";
    $arrayValues = ["%".$reservationsSpecialRequests->getReservationId()."%"];

    return ReservationsSpecialRequestsADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * findByName()
  * It runs a query and returns an object array
  * @param reservationId
  * @return object with the query results
  */
  public static function findByReservationId( $reservationsSpecialRequests ) {
    $cons = "select * from `".ReservationsSpecialRequestsADO::$tableName."` where ".ReservationsSpecialRequestsADO::$colNameReservationId." = ?";
    $arrayValues = [$reservationsSpecialRequests->getReservationId()];

    return ReservationsSpecialRequestsADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll() {
    $cons = "select * from `".ReservationsSpecialRequestsADO::$tableName."`";
    $arrayValues = [];

    return ReservationsSpecialRequestsADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($reservationsSpecialRequests) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".ReservationsSpecialRequestsADO::$tableName." (`reservationId`,	`specialRequestId`) values (?,?)";
    $arrayValues= [$reservationsSpecialRequests->getReservationId(), $reservationsSpecialRequests->getSpecialRequestId()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $reservationsSpecialRequests->setId($id);

    return $reservationsSpecialRequests->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($reservationsSpecialRequests) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".ReservationsSpecialRequestsADO::$tableName."` where ".ReservationsSpecialRequestsADO::$colNameId." = ?";
    $arrayValues= [$reservationsSpecialRequests->getId()];

    $conn->execution($cons, $arrayValues);
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function deleteByReservationId($reservationsSpecialRequests) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".ReservationsSpecialRequestsADO::$tableName."` where ".ReservationsSpecialRequestsADO::$colNameReservationId." = ?";
    $arrayValues= [$reservationsSpecialRequests->getReservationId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */
  public function update($reservationsSpecialRequests) {
    //Connection with the database

    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="update `".ReservationsSpecialRequestsADO::$tableName."` set ".ReservationsSpecialRequestsADO::$colNameReservationId." = ?,".ReservationsSpecialRequestsADO::$colNameSpecialRequestId." = ? where ".ReservationsSpecialRequestsADO::$colNameId." = ?";
    $arrayValues= [$reservationsSpecialRequests->getReservationId(),  $reservationsSpecialRequests->getSpecialRequestId(), $reservationsSpecialRequests->getId()];

    $conn->execution($cons, $arrayValues);

  }
}
?>
