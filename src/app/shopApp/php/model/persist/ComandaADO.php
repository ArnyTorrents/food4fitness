<?php
/** Product.php
* Entity:  Product
* autors:   Arnau T &  Julian M
* version v1
* date:  2018/05
*/
require_once "BDfood4fitness.php";

require_once "../model/comanda.php";




class ComandaADO{

  //----------Data base Values---------------------------------------
  private static $tableName = "Comanda";
  private static $colNameId = "id";
  private static $colNameIdUser = "idUser";
  private static $colNameTotalPrice = "totalPrice";
  private static $colNameDate = "date";
  private static $colNameMethodOfPayment = "methodOfPayment";
  private static $colNamePaid = "paid";
  private static $colNameStatus = "status";

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
      $entity = ComandaADO::fromResultSet( $row );
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
    $id = $row[ ComandaADO::$colNameId];
    $idUser = $row[ ComandaADO::$colNameIdUser ];
    $totalPrice = $row[ ComandaADO::$colNameTotalPrice ];
    $date = $row[ ComandaADO::$colNameDate ];
    $methodOfPayment = $row[ ComandaADO::$colNameMethodOfPayment ];
    $paid = $row[ ComandaADO::$colNamePaid ];
    $status = $row[ ComandaADO::$colNameStatus ];

    //Object construction
    $entity = new Comanda();
    $entity->setId($id);
    $entity->setIdUser($idUser);
    $entity->setTotalPrice($totalPrice);
    $entity->setDate($date);
    $entity->setMethodOfPayment($methodOfPayment);
    $entity->setPaid($paid);
    $entity->setStatus($status);

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
      error_log("Error executing query in ComandaADO: " . $e->getMessage() . " ");
      die();
    }

    $res = $conn->execution($cons, $vector);

    return ComandaADO::fromResultSetList( $res );
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

    $cons="insert into ".ComandaADO::$tableName." (`idUser`, `totalPrice`, `date`, `methodOfPayment`, `paid`, `status`) values (?, ?, ?, ?, ?, ?)";
    $arrayValues= [$comanda->getIdUser(),
                   $comanda->getTotalPrice(),
                   $comanda->getDate(),
                   $comanda->getMethodOfPayment(),
                   $comanda->getPaid(),
                   $comanda->getStatus() ];

    $id = $conn->executionInsert($cons, $arrayValues);

    $comanda->setId($id);

    return $comanda->getId();
  }

  public function findAll($id){
    $cons = "select * from `".ComandaADO::$tableName."` WHERE idUser  = ?";
    $arrayValues = [$id];

    return ComandaADO::findByQuery( $cons, $arrayValues );
  }



}
?>
