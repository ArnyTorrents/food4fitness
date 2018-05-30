import {ProductType} from "./productType"
export class Products {

  id: number;
  productType: ProductType;
  name: string;
  price: number;
  description: string;
  calories: number;
  proteins: number;
  carbohydrates: number;
  totalFat: number;
  stock: number;
  goodFor: string;
  img: string;

  constructor (id?:number,productType?: ProductType,name?:string,price?:number,description?:string,calories?:number,
              proteins?:number,carbohydrates?:number,totalFat?:number,stock?:number,goodFor?:string,img?:string){
    this.setId(id);
    this.setProductType(productType);
    this.setName(name);
    this.setPrice(price);
    this.setDescription(description);
    this.setCalories(calories);
    this.setProteins(proteins);
    this.setCarbohydrates(carbohydrates);
    this.setTotalFat(totalFat);
    this.setStock(stock);
    this.setGoodFor(goodFor);
    this.setImg(img);
  }
  //GETTERS
  getId(): number{
    return this.id;
  }
  getProductType(): ProductType{
    return this.productType;
  }
  getName():string{
    return this.name;
  }
  getPrice():number{
    return this.price;
  }
  getDescription():string{
    return this.description;
  }
  getCalories():number{
    return this.calories;
  }
  getProteins():number{
    return this.proteins;
  }
  getCarbohydrates():number{
    return this.carbohydrates;
  }
  getTotalFat():number{
    return this.totalFat;
  }
  getStock():number{
    return this.stock;
  }
  getGoodFor():string{
    return this.goodFor;
  }
  getImg():string{
    return this.img;
  }
  //setters
  setId(id:number):void{
    this.id = id;
  }
  setProductType(productType:ProductType):void{
    this.productType = productType;
  }
  setName(name:string):void{
    this.name = name;
  }
  setPrice(price:number):void{
    this.price = price;
  }
  setDescription(description:string):void{
    this.description = description;
  }
  setCalories(calories:number):void{
    this.calories = calories;
  }
  setProteins(proteins:number):void{
    this.proteins = proteins;
  }
  setCarbohydrates(carbohydrates: number):void{
    this.carbohydrates = carbohydrates;
  }
  setTotalFat(totalFat:number):void{
    this.totalFat = totalFat;
  }
  setStock(stock:number):void{
    this.stock = stock;
  }
  setGoodFor(goodFor:string):void{
    this.goodFor = goodFor;
  }
  setImg(img:string):void{
    this.img = img;
  }
}
