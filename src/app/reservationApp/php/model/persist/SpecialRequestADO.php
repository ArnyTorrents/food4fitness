<?php
/** SpecialRequest.php
* Entity reservationClass
* autor  Roberto Plana
* version 2012/09
*/
require_once "BDRestaurant.php";
require_once "EntityInterfaceADO.php";
require_once "../model/SpecialRequest.php";

class SpecialRequestADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "specialRequests";
  private static $colNameId = "id";
  private static $colNameRequest = "request";
  private static $colNamePrice = "price";

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
      $entity = SpecialRequestADO::fromResultSet( $row );

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
    $id = $res[ SpecialRequestADO::$colNameId];
    $request = $res[ SpecialRequestADO::$colNameRequest ];
    $price = $res[ SpecialRequestADO::$colNamePrice ];


    //Object construction
    $entity = new SpecialRequest();
    $entity->setId($id);
    $entity->setRequest($request);
    $entity->setPrice($price);


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
      error_log("Error executing query in SpecialRequestADO: " . $e->getMessage() . " ");
      die();
    }

    //Run the query
    $res = $conn->execution($cons, $vector);

    return SpecialRequestADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $specialRequest ) {
    $cons = "select * from `".SpecialRequestADO::$tableName."` where ".SpecialRequestADO::$colNameId." = ?";
    $arrayValues = [$specialRequest->getId()];

    return SpecialRequestADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param request
  * @return object with the query results
  */
  public static function findlikeName( $specialRequest ) {
    $cons = "select * from `".SpecialRequestADO::$tableName."` where ".SpecialRequestADO::$colNameRequest." like ?";
    $arrayValues = ["%".$specialRequest->getRequest()."%"];

    return SpecialRequestADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * findByName()
  * It runs a query and returns an object array
  * @param request
  * @return object with the query results
  */
  public static function findByName( $specialRequest ) {
    $cons = "select * from `".SpecialRequestADO::$tableName."` where ".SpecialRequestADO::$colNameRequest." = ?";
    $arrayValues = [$specialRequest->getRequest()];

    return SpecialRequestADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll() {
    $cons = "select * from `".SpecialRequestADO::$tableName."`";
    $arrayValues = [];

    return SpecialRequestADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($specialRequest) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".SpecialRequestADO::$tableName." values (?,?)";
    $arrayValues= [$specialRequest->getRequest(), $specialRequest->getPrice()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $specialRequest->setId($id);

    return $specialRequest->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($specialRequest) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".SpecialRequestADO::$tableName."` where ".SpecialRequestADO::$colNameId." = ?";
    $arrayValues= [$specialRequest->getId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */
  public function update($specialRequest) {
    //Connection with the database

    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="update `".SpecialRequestADO::$tableName."` set ".SpecialRequestADO::$colNameRequest." = ?,".SpecialRequestADO::$colNamePrice." = ? where ".SpecialRequestADO::$colNameId." = ?";
    $arrayValues= [$specialRequest->getRequest(),  $specialRequest->getPrice(), $specialRequest->getId()];

    $conn->execution($cons, $arrayValues);

  }
}
?>
