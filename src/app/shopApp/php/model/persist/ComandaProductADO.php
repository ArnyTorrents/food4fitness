<?php
/** Product.php
* Entity:  Product
* autors:   Arnau T &  Julian M
* version v1
* date:  2018/05
*/
require_once "BDfood4fitness.php";

require_once "../model/productsComanda.php";




class ComandaProductADO{

  //----------Data base Values---------------------------------------
  private static $tableName = "Comanda-Products";
  private static $colNameIdComanda = "idComanda";
  private static $colNameIdProducto = "idProduct";
  private static $colNameQuantitat = "quantitat";

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
      $entity = ComandaProductADO::fromResultSet( $row );
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
    $idComanda = $row[ ComandaProductADO::$colNameIdComanda];
    $idUser = $row[ ComandaProductADO::$colNameIdProducto ];
    $quantitat = $row[ ComandaProductADO::$colNameQuantitat ];

    //Object construction
    $entity = new ProductsComanda();
    $entity->setIdComanda($idComanda);
    $entity->setIdUser($idUser);
    $entity->setQuantitat($quantitat);

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
      error_log("Error executing query in ComandaProductADO: " . $e->getMessage() . " ");
      die();
    }

    $res = $conn->execution($cons, $vector);

    return ComandaProductADO::fromResultSetList( $res );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($comanda) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".ComandaProductADO::$tableName." (`idComanda`, `idUser`, `quantitat`) values (?, ?, ?)";
    $arrayValues= [$comanda->getIdComanda(),
                   $comanda->getIdUser(),
                   $comanda->getQuantitat()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $comanda->setId($id);

    return $comanda->getId();
  }



}
?>
