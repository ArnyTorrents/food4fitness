import {ProductsComanda} from "./productsComanda"
export class Comanda {
  id:number;
  idUser: number;
  productsComanda: ProductsComanda;
  totalPrice: number;
  date: any;
  status: string;
  //constructor
  constructor (id?:number,idUser?:number,productsComanda?:ProductsComanda ,totalPrice?:number,date?:any,status?:string) {
    this.setId(id);
    this.setIdUser(idUser);
    this.setTotalPrice(totalPrice);
    this.setDate(date);
    this.setStatus(status);
  }
  //getters
  getId() : number {
    return this.id;
  }
  getIdUser() : number {
    return this.idUser;
  }
  getProductsComanda():ProductsComanda{
    return this.productsComanda;
  }
  getTotalPrice() : number {
    return this.totalPrice;
  }
  getDate():any{
    return this.date;
  }
  getStatus():string{
    return this.status
  }
  //setters
  setId(id:number) : void {
    this.id = id;
  }
  setIdUser(idUser:number) : void {
    this.idUser = idUser;
  }
  setProductsComanda(productsComanda:ProductsComanda):void{
    this.productsComanda = productsComanda;
  }
  setTotalPrice(totalPrice:number) : void {
    this.totalPrice = totalPrice;
  }
  setDate(date:any):void{
    this.date = date;
  }
  setStatus(status:string): void{
    this.status = status;
  }
}
