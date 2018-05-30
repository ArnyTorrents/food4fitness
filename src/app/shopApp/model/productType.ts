export class ProductType {

  id: number;
  name: string;
  description: string;

  constructor(id?:number,name?:string,description?:string){
    this.setId(id);
    this.setName(name);
    this.setDescription(description);
  }
  //getters
  getId():number{
    return this.id;
  }
  getName():string{
    return this.name;
  }
  getDescription():string{
    return this.description;
  }
  //setters
  setId(id:number):void{
    this.id = id;
  }
  setName(name:string):void{
    this.name = name;
  }
  setDescription(description:string):void{
    this.description = description;
  }

}
