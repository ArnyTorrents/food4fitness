<?php
/** User.php
* Entity User
* autor  Roberto Plana
* version 2012/09
*/
require_once "BDRestaurant.php";
require_once "EntityInterfaceADO.php";
require_once "../model/User.php";

class UserADO implements EntityInterfaceADO {

  //----------Data base Values---------------------------------------
  private static $tableName = "User";
  private static $colNameId = "id";
  private static $colNameName = "name";
  private static $colNameSurname = "surname";
  private static $colNameAdress = "address";
  private static $colNameRole = "role";
  private static $colNameCountry = "country";
  private static $colNameProvince = "province";
  private static $colNameDoor = "door";
  private static $colNamePhone = "phone";
  private static $colNameNickName = "nickName";
  private static $colNamePassword = "password";
  private static $colNameImg = "img";

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
      $entity = UserADO::fromResultSet( $row );

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
    $id = $row[ UserADO::$colNameId];
    $name = $row[ UserADO::$colNameName ];
    $surname = $row[ UserADO::$colNameSurname ];
    $adress = $row[ UserADO::$colNameAdress ];
    $role = $row[ UserADO::$colNameRole];
    $country = $row[ UserADO::$colNameCountry];
    $province = $row[ UserADO::$colNameProvince];
    $door = $row[ UserADO::$colNameDoor];
    $phone = $row[ UserADO::$colNamePhone];
    $nickName = $row[ UserADO::$colNameNickName ];
    $password = $row[ UserADO::$colNamePassword ];
    $img = $row[ UserADO::$colNameImg ];

    //Object construction
    $entity = new User();
    $entity->setId($id);
    $entity->setName($name);
    $entity->setSurname($surname);
    $entity->setAddress($adress);
    $entity->setRole($role);
    $entity->setCountry($country);
    $entity->setProvince($province);
    $entity->setDoor($door);
    $entity->setPhone($phone);
    $entity->setNickName($nickName);
    $entity->setPassword($password);
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
      error_log("Error executing query in UserADO: " . $e->getMessage() . " ");
      die();
    }

    $res = $conn->execution($cons, $vector);

    return UserADO::fromResultSetList( $res );
  }

  /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
  */
  public static function findById( $user ) {
    $cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameId." = ?";
    $arrayValues = [$user->getId()];

    return UserADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findlikeName()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findlikeName( $user ) {
    $cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameName." like ?";
    $arrayValues = ["%".$user->getName()."%"];

    return UserADO::findByQuery($cons,$arrayValues);
  }



  /**
  * findByName()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByName( $user ) {
    $cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameName." = ?";
    $arrayValues = [$user->getName()];

    return UserADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByNick()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByNick( $user ) {
    $cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameNickName." = ?";
    $arrayValues = [$user->getNickName()];

    return UserADO::findByQuery($cons,$arrayValues);
  }

  /**
  * findByNickAndPass()
  * It runs a query and returns an object array
  * @param name
  * @return object with the query results
  */
  public static function findByNickAndPass( $user ) {
    //$cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameNick." = \"".$user->getNick()."\" and ".UserADO::$colNamePassword." = \"".$user->getPassword()."\"";
    $cons = "select * from `".UserADO::$tableName."` where ".UserADO::$colNameNickName." = ? and ".UserADO::$colNamePassword." = ?";
    $arrayValues = [$user->getNickName(),$user->getPassword()];

    return UserADO::findByQuery( $cons, $arrayValues );
  }

  /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
  */
  public static function findAll( ) {
    $cons = "select * from `".UserADO::$tableName."`";
    $arrayValues = [];

    return UserADO::findByQuery( $cons, $arrayValues );
  }


  /**
  * create()
  * insert a new row into the database
  */
  public function create($user) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons="insert into ".UserADO::$tableName." (`name`,`surname`,`address`,`role`,`country`,`province`,`door`,`phone`,`nickName`,`password`,`img`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $arrayValues= [$user->getName(),$user->getSurname(),$user->getAddress(),$user->getRole(),$user->getCountry(),$user->getProvince(),$user->getDoor(),$user->getPhone() ,$user->getNickName(), $user->getPassword(),$user->getimg()];

    $id = $conn->executionInsert($cons, $arrayValues);

    $user->setId($id);

    return $user->getId();
  }

  /**
  * delete()
  * it deletes a row from the database
  */
  public function delete($user) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }


    $cons="delete from `".UserADO::$tableName."` where ".UserADO::$colNameId." = ?";
    $arrayValues= [$user->getId()];

    $conn->execution($cons, $arrayValues);
  }


  /**
  * update()
  * it updates a row of the database
  */

  public function update($user) {
    //Connection with the database
    try {
      $conn = DBConnect::getInstance();
    }
    catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
    }

    $cons  = "update `".UserADO::$tableName."` set ".UserADO::$colNameName." = ?,";
    $cons .= UserADO::$colNameSurname." = ?,".UserADO::$colNameAdress." = ?,";
    $cons .= UserADO::$colNameRole." = ?,".UserADO::$colNameCountry." = ?,";
    $cons .= UserADO::$colNameProvince." = ?,".UserADO::$colNameDoor." = ?,";
    $cons .= UserADO::$colNamePhone." = ?,".UserADO::$colNameNickName." = ?,";
    $cons .= UserADO::$colNamePassword." = ?,".UserADO::$colNameImg." = ?";
    $cons .= " where ".UserADO::$colNameId." = ?" ;
    $arrayValues= [$user->getName(),
                   $user->getSurname(),
                   $user->getAddress(),
                   $user->getRole(),
                   $user->getCountry(),
                   $user->getProvince(),
                   $user->getDoor(),
                   $user->getPhone() ,
                   $user->getNickName(),
                   $user->getPassword(),
                   $user->getimg(),
                   $user->getId()];

    $result = $conn->execution($cons, $arrayValues);
    return $result;
  }

}
?>
