<?php
/** ReservationTime.php
* Entity reservationClass
* autor  Roberto Plana
* version 2012/09
*/
require_once "BDRestaurant.php";
require_once "EntityInterfaceADO.php";
require_once "../model/ReservationTime.php";

class ReservationTimeADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "reservationTimes";
  private static $colNameId = "id";
  private static $colNameTime = "time";

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
      $entity = ReservationTimeADO::fromResultSet( $row );

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
    $id = $res[ ReservationTimeADO::$colNameId];
    $time = $res[ ReservationTimeADO::$colNameTime ];


    //Object construction
    $entity = new ReservationTime();
    $entity->setId($id);
    $entity->setTime($time);


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
      error_log("Error executing query in ReservationTimeADO: " . $e->getMessage() . " ");
      die();
    }

    //Run the query
    $res = $conn->execution($cons, $vector);

    return ReservationTimeADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $reservationTime ) {
    $cons = "select * from `".ReservationTimeADO::$tableName."` where ".ReservationTimeADO::$colNameId." = ?";
    $arrayValues = [$reservationTime->getId()];

    return ReservationTimeADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param time
  * @return object with the query results
  */
  public static function findlikeTime( $reservationTime ) {
    $cons = "select * from `".ReservationTimeADO::$tableName."` where ".ReservationTimeADO::$colNameTime." like ?";
    $arrayValues = ["%".$reservationTime->getTime()."%"];

    return ReservationTimeADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * findByName()
  * It runs a query and returns an object array
  * @param time
  * @return object with the query results
  */
  public static function findByTime( $reservationTime ) {
    $cons = "select * from `".ReservationTimeADO::$tableName."` where ".ReservationTimeADO::$colNameTime." = ?";
    $arrayValues = [$reservationTime->getTime()];

    return ReservationTimeADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll() {
    $cons = "select * from `".ReservationTimeADO::$tableName."`";
    $arrayValues = [];

    return ReservationTimeADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($reservationTime) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".ReservationTimeADO::$tableName." values (?)";
    $arrayValues= [$reservationTime->getTime()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $reservationTime->setId($id);

    return $reservationTime->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($reservationTime) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".ReservationTimeADO::$tableName."` where ".ReservationTimeADO::$colNameId." = ?";
    $arrayValues= [$reservationTime->getId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */
  public function update($reservationTime) {
    //Connection with the database

    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="update `".ReservationTimeADO::$tableName."` set ".ReservationTimeADO::$colNameTime." = ? where ".ReservationTimeADO::$colNameId." = ?";
    $arrayValues= [$reservationTime->getTime(), $reservationTime->getId()];

    $conn->execution($cons, $arrayValues);

  }
}
?>
