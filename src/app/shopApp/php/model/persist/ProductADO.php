<?php
/** Product.php
* Entity:  Product
* autors:   Arnau T &  Julian M
* version v1
* date:  2018/05
*/
require_once "BDfood4fitness.php";

require_once "ProductTypeADO.php";
require_once "../model/products.php";
require_once "../model/productType.php";




class ProductADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "Products";
  private static $colNameId = "id";
  private static $colNameProductTypeId = "productType";
  private static $colNameName = "name";
  private static $colNamePrice = "price";
  private static $colNameDescription = "description";
  private static $colNameCalories = "calories";
  private static $colNameProteines = "proteines";
  private static $colNameCarbohydrates = "carbohydrates";
  private static $colNameTotalFat = "totalFat";
  private static $colNameStock = "stock";
  private static $colNameGoodFor = "goodFor";
  private static $colNameImg = "img";

  //---Databese management section-----------------------
  /**
  * fromResultSetList()
  * this function runs a query and returns an array
  * with all the result transformed into an object
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
      $entity = ProductADO::fromResultSet( $row );
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
    $id = $row[ ProductADO::$colNameId];
    $productTypeId = $row[ ProductADO::$colNameProductTypeId ];
    $name = $row[ ProductADO::$colNameName ];
    $price = $row[ ProductADO::$colNamePrice ];
    $description = $row[ ProductADO::$colNameDescription ];
    $calories = $row[ ProductADO::$colNameCalories ];
    $proteins = $row[ ProductADO::$colNameProteines ];
    $carbohydrates = $row[ ProductADO::$colNameCarbohydrates ];
    $totalFat	 = $row[ ProductADO::$colNameTotalFat ];
    $stock	 = $row[ ProductADO::$colNameStock ];
    $goodFor = $row[ ProductADO::$colNameGoodFor ];
    $img = $row[ ProductADO::$colNameImg];

    //Object construction
    $entity = new Products();
    $entity->setId($id);

    $productType = new ProductType();
    $productType->setId($productTypeId);
    $productTypeName = ProductTypeADO::findById($productType);
    // echo serialize($productTypeName[0]);
    $entity->setProductType($productTypeName[0]);
    $entity->setName($name);
    $entity->setPrice($price);
    $entity->setDescription($description);
    $entity->setCalories($calories);
    $entity->setProteins($proteins);
    $entity->setCarbohydrates($carbohydrates);
    $entity->setTotalFat($totalFat);
    $entity->setStock($stock);
    $entity->setGoodFor($goodFor);
    $entity->setImg($img);

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
      error_log("Error executing query in ProductADO: " . $e->getMessage() . " ");
      die();
    }

    $res = $conn->execution($cons, $vector);

    return ProductADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameId." = ?";
    $arrayValues = [$product->getId()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results$outPutData
  */
  public static function findlikeName( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameName." like ?";
    $arrayValues = ["%".$product->getName()."%"];

    return ProductADO::findByQuery($cons,$arrayValues);
  }



  /**
  * findByName()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByName( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameName." = ?";
    $arrayValues = [$product->getName()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByPrice()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByPrice( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNamePrice." = ?";
    $arrayValues = [$product->getPrice()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByCalories()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByCalories( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameCaloreis." = ?";
    $arrayValues = [$product->getCalories()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByProteines()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByProteines( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameProteines." = ?";
    $arrayValues = [$product->getProteins()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByCarbohydrates()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByCarbohydrates( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameCarbohydrates." = ?";
    $arrayValues = [$product->getCarbohydrates()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByTotalFat()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByTotalFat( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameTotalFat." = ?";
    $arrayValues = [$product->getTotalFat()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByGoodFor()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByGoodFor( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameGoodFor." = ?";
    $arrayValues = [$product->getGoodFor()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findBy()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findBy( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colName." = ?";
    $arrayValues = [$product->get()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByType()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByType( $product ) {
    $cons = "select * from `".ProductADO::$tableName."` where ".ProductADO::$colNameProductType." = ?";
    $arrayValues = [$product->getProductType()];

    return ProductADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll( ) {
    $cons = "select * from `".ProductADO::$tableName."`";
    $arrayValues = [];

    return ProductADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($product) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".ProductADO::$tableName." (`productType`, `name`, `price`, `description`, `calories`, `proteines`, `carbohydrates`, `totalFat`, `stock`, `goodFor`, `img`)
            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $arrayValues= [$product->getProductType()->getId(),
                   $product->getName(),
                   $product->getPrice(),
                   $product->getDescription(),
                   $product->getCalories(),
                   $product->getProteins(),
                   $product->getCarbohydrates(),
                   $product->getTotalFat(),
                   $product->getStock(),
                   $product->getGoodFor(),
                   $product->getImg() ];

    $id = $conn->executionInsert($cons, $arrayValues);

    $product->setId($id);

    return $product->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($product) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".ProductADO::$tableName."` where ".ProductADO::$colNameId." = ?";
    $arrayValues= [$product->getId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */
  public function update($product) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="update `".ProductADO::$tableName."` set "
                    .ProductADO::$colNameProductTypeId." = ?, "
                    .ProductADO::$colNameName." = ?, "
                    .ProductADO::$colNamePrice." = ?, "
                    .ProductADO::$colNameDescription." = ?, "
                    .ProductADO::$colNameCalories." = ?, "
                    .ProductADO::$colNameProteines." = ?, "
                    .ProductADO::$colNameCarbohydrates." = ?, "
                    .ProductADO::$colNameTotalFat." = ?, "
                    .ProductADO::$colNameStock." = ?, "
                    .ProductADO::$colNameGoodFor." = ?, "
                    .ProductADO::$colNameImg." = ? where "
                    .ProductADO::$colNameId." = ?" ;

    $arrayValues= [$product->getProductType()->getId(),
                   $product->getName(),
                   $product->getPrice(),
                   $product->getDescription(),
                   $product->getCalories(),
                   $product->getProteins(),
                   $product->getCarbohydrates(),
                   $product->getTotalFat(),
                   $product->getStock(),
                   $product->getGoodFor(),
                   $product->getImg(),
                   $product->getId()];

    $conn->execution($cons, $arrayValues);
  }
}
?>
