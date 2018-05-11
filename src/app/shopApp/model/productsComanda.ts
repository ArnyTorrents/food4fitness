export class ProductsComanda{
  idComanda:number;
  idProducto:number;
  quantitat:number;

  constructor(idComanda?:number,idProducto?:number,quantitat?:number){
    this.setIdComanda(idComanda);
    this.setIdProducto(idProducto);
    this.setQuantitat(quantitat);
  }
  //GETTERS
  getIdComanda():number{
    return this.idComanda;
  }
  getIdProducto():number{
    return this.idProducto;
  }
  getQuantitat():number{
    return this.quantitat;
  }
  //SETTERS
  setIdComanda(idComanda:number):void{
    this.idComanda = idComanda;
  }
  setIdProducto(idProducto:number):void{
    this.idProducto = idProducto;
  }
  setQuantitat(quantitat:number):void{
    this.quantitat = quantitat;
  }

}
