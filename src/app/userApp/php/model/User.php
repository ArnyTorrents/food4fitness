<?php
/** User.php
 * Entity User
 * autor  Roberto Plana
 * version 2012/09
 */
 require_once "EntityInterface.php";
class User implements EntityInterface {
    //variables
    private $id;
    private $name;
    private $surname;
    private $address;
    private $role;
    private $country;
    private $province;
    private $door;
    private $phone;
    private $nickName;
    private $password;
    private $img;
    //constructor
    function __construct() {
    }
    //getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getCountry(){
        return $this->country;
    }

    public function getDoor(){
        return $this->door;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getNickName() {
        return $this->nickName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getImg() {
        return $this->img;
    }
    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }

	  public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setAddress($address){
        $this->address = $address;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public function setCountry($country){
        $this->country = $country;
    }

    public function setProvince($province){
        $this->province = $province;
    }

    public function setDoor($door){
        $this->door = $door;
    }

    public function setPhone($phone){
        $this->phone = $phone;
    }

    public function setNickName($nickName) {
        $this->nickName = $nickName;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setImg($img) {
		$this->img = $img;
    }

    public function getAll() {
		$data = array();
		$data["id"] = $this->id;
		$data["name"] = $this->name;
		$data["surname"] = $this->surname;
    $data["address"] = $this->address;
    $data["role"] = $this->role;
    $data["country"] = $this->country;
    $data["province"] = $this->province;
    $data["door"] = $this->door;
    $data["phone"] = $this->phone;
		$data["nickName"] = $this->nickName;
		$data["password"] = $this->password;
		$data["img"] = $this->img;
		return $data;
    }

    public function setAll($id,$name,$surname,$address,$role,$country,$province,$door,$phone,$nick,$password,$img) {
		$this->setId($id);
		$this->setName($name);
		$this->setSurname($surname);
    $this->setAddress($address);
    $this->setRole($role);
    $this->setCountry($country);
    $this->setProvince($province);
    $this->setDoor($door);
    $this->setPhone($phone);
		$this->setNickName($nick);
		$this->setPassword($password);
		$this->setImg($img);
    }

    public function toString() {
        $toString = "User[id=" . $this->id . "][name=" . $this->getName(). "][surname=" . $this->getSurname() . "][password=" . $this->password . "][email=" . $this->mail . "]";
		    return $toString;

    }
}
?>
