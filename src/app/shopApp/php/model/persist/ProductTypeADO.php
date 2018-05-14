<?php
/** ProductTypeADO.php
* Entity:  ProductType
* autors:   Arnau T & Julian M
* version 2012/09
*/
require_once "BDRestaurant.php";
require_once "EntityInterfaceADO.php";
require_once "../model/ProductType.php";

class ProductTypeADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "ProductType";
  private static $colNameId = "id";
  private static $colNameName = "name";
  private static $colNameDescription = "description";

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
      $entity = ProductTypeADO::fromResultSet( $row );

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
    $id = $res[ ProductTypeADO::$colNameId];
    $name = $res[ ProductTypeADO::$colNameName ];
    $description = $res[ ProductTypeADO::$colNameDescription ];


    //Object construction
    $entity = new ProductType();
    $entity->setId($id);
    $entity->setName($name);
    $entity->setDescription($description);


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
      error_log("Error executing query in ProductTypeADO: " . $e->getMessage() . " ");
      die();
    }

    //Run the query
    $res = $conn->execution($cons, $vector);

    return ProductTypeADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $productType ) {
    $cons = "select * from `".ProductTypeADO::$tableName."` where ".ProductTypeADO::$colNameId." = ?";
    $arrayValues = [$productType->getId()];

    return ProductTypeADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param preference
  * @return object with the query results
  */
  public static function findlikeName( $productType ) {
    $cons = "select * from `".ProductTypeADO::$tableName."` where ".ProductTypeADO::$colNameName." like ?";
    $arrayValues = ["%".$productType->getName()."%"];

    return ProductTypeADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * findByName()
  * It runs a query and returns an object array
  * @param preference
  * @return object with the query results
  */
  public static function findByName( $productType ) {
    $cons = "select * from `".ProductTypeADO::$tableName."` where ".ProductTypeADO::$colNameName." = ?";
    $arrayValues = [$productType->getName()];

    return ProductTypeADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll() {
    $cons = "select * from `".ProductTypeADO::$tableName."`";
    $arrayValues = [];

    return ProductTypeADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($productType) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".ProductTypeADO::$tableName." values (?,?)";
    $arrayValues= [$productType->getName(), $productType->getDescription()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $productType->setId($id);

    return $productType->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($productType) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".ProductTypeADO::$tableName."` where ".ProductTypeADO::$colNameId." = ?";
    $arrayValues= [$productType->getId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */
  public function update($productType) {
    //Connection with the database

    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="update `".ProductTypeADO::$tableName."` set ".ProductTypeADO::$colNameName." = ?,".ProductTypeADO::$colNameDescription." = ? where ".ProductTypeADO::$colNameId." = ?";
    $arrayValues= [$productType->getName(),
                   $productType->getDescription(),
                   $productType->getId()];

    $conn->execution($cons, $arrayValues);

  }
}
?>
