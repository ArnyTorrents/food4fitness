export class ComandaProducts {

  idComanda: number;
  idProducto: number;
  quantitat: number;

  constructor (idComanda?: number,idProducto?:number,quantitat?:number){
    this.setIdComanda(idComanda);
    this.setIdProducto(idProducto);
    this.setQuantitat(quantitat);
  }
  //getters
  getIdComanda():number{
    return this.idComanda;
  }
  getIdProducto():number{
    return this.idProducto;
  }
  getQuantitat():number{
    return this.quantitat;
  }
  //setters
  setIdComanda(idComanda:number){
    this.idComanda = idComanda;
  }
  setIdProducto(idProducto:number){
    this.idProducto = idProducto;
  }
  setQuantitat(quantitat:number){
    this.quantitat = quantitat
  }

}
