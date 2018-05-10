<?php
/** TablePreference.php
* Entity reservationClass
* autor  Roberto Plana
* version 2012/09
*/
require_once "BDRestaurant.php";
require_once "EntityInterfaceADO.php";
require_once "../model/TablePreference.php";

class TablePreferenceADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "tablePreferences";
  private static $colNameId = "id";
  private static $colNamePreference = "preference";
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
      $entity = TablePreferenceADO::fromResultSet( $row );

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
    $id = $res[ TablePreferenceADO::$colNameId];
    $preference = $res[ TablePreferenceADO::$colNamePreference ];
    $price = $res[ TablePreferenceADO::$colNamePrice ];


    //Object construction
    $entity = new TablePreference();
    $entity->setId($id);
    $entity->setPreference($preference);
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
      error_log("Error executing query in TablePreferenceADO: " . $e->getMessage() . " ");
      die();
    }

    //Run the query
    $res = $conn->execution($cons, $vector);

    return TablePreferenceADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $tablePreference ) {
    $cons = "select * from `".TablePreferenceADO::$tableName."` where ".TablePreferenceADO::$colNameId." = ?";
    $arrayValues = [$tablePreference->getId()];

    return TablePreferenceADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param preference
  * @return object with the query results
  */
  public static function findlikeName( $tablePreference ) {
    $cons = "select * from `".TablePreferenceADO::$tableName."` where ".TablePreferenceADO::$colNamePreference." like ?";
    $arrayValues = ["%".$tablePreference->getPreference()."%"];

    return TablePreferenceADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * findByName()
  * It runs a query and returns an object array
  * @param preference
  * @return object with the query results
  */
  public static function findByName( $tablePreference ) {
    $cons = "select * from `".TablePreferenceADO::$tableName."` where ".TablePreferenceADO::$colNamePreference." = ?";
    $arrayValues = [$tablePreference->getPreference()];

    return TablePreferenceADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll() {
    $cons = "select * from `".TablePreferenceADO::$tableName."`";
    $arrayValues = [];

    return TablePreferenceADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($tablePreference) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".TablePreferenceADO::$tableName." values (?,?)";
    $arrayValues= [$tablePreference->getPreference(), $tablePreference->getPrice()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $tablePreference->setId($id);

    return $tablePreference->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($tablePreference) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".TablePreferenceADO::$tableName."` where ".TablePreferenceADO::$colNameId." = ?";
    $arrayValues= [$tablePreference->getId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */
  public function update($tablePreference) {
    //Connection with the database

    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="update `".TablePreferenceADO::$tableName."` set ".TablePreferenceADO::$colNamePreference." = ?,".TablePreferenceADO::$colNamePrice." = ? where ".TablePreferenceADO::$colNameId." = ?";
    $arrayValues= [$tablePreference->getPreference(),  $tablePreference->getPrice(), $tablePreference->getId()];

    $conn->execution($cons, $arrayValues);

  }
}
?>
