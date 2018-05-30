import {ComandaProducts} from "./comanda-products"
export class Comanda {
  id:number;
  idUser: number;
  productsComanda: ComandaProducts[]=[];
  totalPrice: number;
  date: any;
  methodsOfPayment: string;
  paid: number;
  status: string;
  //constructor
  constructor (id?:number,idUser?:number,productsComanda?:ComandaProducts[] ,totalPrice?:number,
                date?:any,methodsOfPayment?:string,paid?:number ,status?:string) {
    this.setId(id);
    this.setIdUser(idUser);
    this.setProductsComanda(productsComanda);
    this.setTotalPrice(totalPrice);
    this.setDate(date);
    this.setMethodOfPayment(methodsOfPayment);
    this.setPaid(paid);
    this.setStatus(status);
  }
  //getters
  getId() : number {
    return this.id;
  }
  getIdUser() : number {
    return this.idUser;
  }
  getProductsComanda():ComandaProducts[]{
    return this.productsComanda;
  }
  getTotalPrice() : number {
    return this.totalPrice;
  }
  getDate():any{
    return this.date;
  }
  getMethodOfPayment(){
    return this.methodsOfPayment;
  }
  getPaid(){
    return this.paid;
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
  setProductsComanda(productsComanda:ComandaProducts[]):void{
    this.productsComanda = productsComanda;
  }
  setTotalPrice(totalPrice:number) : void {
    this.totalPrice = totalPrice;
  }
  setDate(date:any):void{
    this.date = date;
  }
  setMethodOfPayment(methodsOfPayment:string){
    this.methodsOfPayment = methodsOfPayment;
  }
  setPaid(paid:number){
    this.paid = paid;
  }
  setStatus(status:string): void{
    this.status = status;
  }
}
