  export class User {
  id: number;
  name: string;
  surname: string;
  adress: string;
  role: string;
  country: string;
  province: string;
  door: string;
  phone:string;
  nickName: string;
  password: string;
  img: string;
  //constructor
  constructor(id?: number, name?: string, surname?: string, adress?: string, role?: string, country?: string,province?:string,door?:string,phone?:string,nickName?:string,password?:string,img?:string) {
        this.setId(id);
        this.setName(name);
        this.setSurname(surname);
        this.setAdress(adress);
        this.setRole(role);
        this.setCountry(country);
        this.setProvince(province);
        this.setDoor(door);
        this.setPhone(phone);
        this.setNickName(nickName);
        this.setPassword(password);
        this.setImg(img);
  }
  //getters
  getId(): number {
    return this.id;
  }

  getName(): string {
    return this.name;
  }

  getSurname(): string {
    return this.surname;
  }

  getAdress(): string {
    return this.adress;
  }

  getRole():string{
    return this.role;
  }

  getCountry():string{
    return this.country;
  }

  getProvince():string{
    return this.province;
  }

  getDoor():string{
    return this.door;
  }

  getPhone():string{
    return this.phone;
  }

  getNickName():string{
    return this.nickName;
  }

  getPassword(): string {
    return this.password;
  }

  getImg(): string {
    return this.img;
  }
  //setters
  setId(id): void {
    this.id = id;
  }

  setName(name): void {
    this.name = name;
  }

  setSurname(surname): void {
    this.surname = surname;
  }

  setAdress(adress):void{
    this.adress = adress;
  }

  setRole(role):void{
    this.role = role;
  }

  setCountry(country):void{
    this.country = country;
  }

  setProvince(province):void{
    this.province = province
  }

  setDoor(door):void{
    this.door = door;
  }

  setPhone(phone):void{
    this.phone = phone;
  }

  setNickName(nickName): void {
    this.nickName = nickName;
  }

  setPassword(password): void {
    this.password = password;
  }

  setImg(img: string): void {
    this.img= img;
  }
}
