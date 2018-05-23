import { Component, OnInit, ViewChild,
  Input, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';

//Model
import { Comanda } from "./../model/comanda";
import { ComandaProducts} from "./../model/comanda-products";
import { Products } from './../model/products';
import { ProductType} from './../model/productType';
import { User } from './../model/user';

//Service
import { ProductDataService } from './../services/product-data.service';

//Cookie
import { CookieService } from 'ngx-cookie-service';


@Component({
  selector: 'product-managment',
  templateUrl: './../views/product-managment.view.html',
  styleUrls: ['./../css/product-managment.style.css'],
  providers: [ProductDataService]
})
export class ProductManagmentComponent implements OnInit {

  //properties
  pageTitle: string = "Products"
  productDetail: Products;
  products: Products[]=[];
  productsFiltered: Products[]=[];
  shopAction: number;
  typeView: number = 0 ;
  roleUser: string;


  quantitat: number=0;
  //Cart
  cartCont:number=0;
  comanda: Comanda;
  comandaPs: ComandaProducts;
  comandaProducts: ComandaProducts[]=[];

  //Pagination properties
  itemsPerPage: number;
  currentPage: number;
  totalItems: number;

  //Filter properties
  priceFilter: number;
  nameFilter:string;

  //@Input() means this variables come from another component
  @Input() productsType : ProductType[];

  // We'll use
  //setShopAction.emit(variable Content to comunicate)
  @Output() setShopAction:EventEmitter<number>
              = new EventEmitter<number>();


  constructor(private router: Router,
              private productDataService: ProductDataService,
              private cookieService: CookieService ) { }

  ngOnInit() {
    this.typeView = 0;
    // this.shopAction = 0;
    this.productDataService.getAllProducts().subscribe(
      outPutData => {
         if(outPutData.length > 0 && Array.isArray(outPutData) && JSON.parse(outPutData[0]) == true) {
           for (let productJSON of outPutData[1]) {
             let product = new Products();

             Object.assign(product,productJSON);

             // console.log(product.getProductType());
             // let productType = new ProductType();
             // productType = this.productsType.find(productType =>
             //   productType.getId()==product.getProductType().id);

             product.setProductType(product.getProductType());
             this.products.push(product);

           }
           console.log(this.products);
         } else {
           alert("Sorry, there has been an error, try later");
           console.log("ProductManagmentComponent (ngOnInit): outPutData is false or not array: "
                   + JSON.stringify(outPutData));
           this.router.navigate(["products"]);
         }
       },
       error => {
         alert("Sorry, there has been an error, try later");
         console.log("ProductManagmentComponent (ngOnInit). Error happened: " + JSON.stringify(error));
         this.router.navigate(["products"]);
       }
   );

   this.itemsPerPage = 4;
   this.currentPage = 1;
   this.totalItems= this.products.length;
   this.priceFilter = 500;
   this.productsFiltered = this.products;
   this.shopAction = 0;

   if(this.cookieService.check("user")){
     let cookieObj:any =
           JSON.parse(this.cookieService.get("user"));
     let userConnected = new User();
     Object.assign(userConnected,cookieObj);
     this.roleUser = cookieObj.role;
   }else{
     console.log("No sessio Conectada")
   }


   ///CREATE COMANDA OBJECT
   this.comanda = new Comanda();
   this.comanda.setId(0);
   this.comanda.setIdUser(0);
   let date = new Date();
   this.comanda.setDate(date);
   this.comanda.setStatus("To Delivery");

}

  filter (): void {
   this.productsFiltered = this.products.filter( product => {
       let priceValid = false;
       let nameValid = false;

       if(product.getPrice()<= this.priceFilter) {
         priceValid = true;
       } else {
         priceValid = false;
       }

       if(this.nameFilter != "" && this.nameFilter != undefined) {
         if(product.getName().toLowerCase().indexOf(this.nameFilter.toLowerCase())!= -1) {
           nameValid = true;
         } else {nameValid = false;}
       } else {
         nameValid = true;
       }

       return (nameValid && priceValid);
     }
   );
 }

  removeProduct(product: Products): void {
    this.productDataService.removeProducts(product).subscribe(
       outPutData => {
        if(outPutData.length > 0 && Array.isArray(outPutData) && JSON.parse(outPutData[0]) == true) {
          alert("Product correctly eliminated");
          this.products.splice(this.products.indexOf(product),1);
          this.filter();
        } else {
          alert("Sorry, there has been an error, try later");
          console.log("ProductManagmentComponent (removeProduct): some error happened in the server area, check server logs");
          this.router.navigate(["products"]);
        }
      },
      error => {
        // if(error.text=="Error executing query"){
        //   console.log("Prova");
        // }
        alert("Sorry, there has been an error, try later");
        console.log("ProductManagmentComponent (removeProduct). Error happened: " + JSON.stringify(error));
        this.router.navigate(["products"]);
      }
    );
  }

  goToDetail (product : Products) : void {
    this.productDetail = product;
    this.shopAction = 1;
    console.log("Detail");

  }



  setShopActionManagement(action:number): void{

    this.shopAction=action;
  }

  addCart(product: Products):void{
    this.comandaPs = new ComandaProducts();
    let flag = false;

    //cart cont items
    this.cartCont++;
    //select the values of the comanda values
    this.comandaPs.setIdComanda(0);
    //comprove if the product its in the comanda
    if(this.comandaProducts.length>0){
      for(let i = 0;i<this.comandaProducts.length;i++){
        if(this.comandaProducts[i].idProducto == product.id){
          this.quantitat = this.comandaProducts[i].quantitat;
          this.quantitat = this.quantitat + 1;
          this.comandaProducts[i].setQuantitat(this.quantitat);
          flag = false;
          break;
        }else{
          this.comandaPs.setQuantitat(1);
          this.comandaPs.setIdProducto(product.id);
          //comanda=>id,idUser,productsComanda,totalPrice,date,status
          //this.comanda.setProductsComanda(this.comandaPs);
          /*let totalPrice = this.calculateTotalPrice();
          this.comanda.setTotalPrice(totalPrice);*/
          //this.comandaProducts.push(this.comandaPs);
          flag = true;
        }
      }
      if(flag){
        /*let contArr = 0;
        for(let j = 0;j<this.comandaProducts.length;j++){
          if(this.comandaProducts[j].idProducto == product.id){
            contArr++;
          }
        }*/


        console.log(flag);
        this.comanda.setProductsComanda(this.comandaPs);
        this.comandaProducts.push(this.comandaPs);
      }
    }else{
      this.comandaPs.setQuantitat(1);
      this.comandaPs.setIdProducto(product.id);
      this.comanda.setProductsComanda(this.comandaPs);

      this.comandaProducts.push(this.comandaPs);
    }









    console.log(this.comandaProducts);
  }

  calculateTotalPrice(){
    let totalPrice = 0;

    return totalPrice;
  }

  goToCommand():void{
    this.shopAction = 2;
  }
}
