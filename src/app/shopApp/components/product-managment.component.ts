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
  product: Products;

  productsFiltered: Products[]=[];

  arrayAux: Products[]=[];
  productsFiltered1: Products[]=[];
  productsFiltered2: Products[]=[];

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

  productsLength: number=0;

  //Filter properties
  priceFilter: number;
  nameFilter:string;
  typefilter:ProductType;

  //@Input() means this variables come from another component
  productsType : ProductType[]=[];

  // We'll use
  //setShopAction.emit(variable Content to comunicate)
  @Output() setShopAction:EventEmitter<number>
              = new EventEmitter<number>();


  constructor(private router: Router,
              private productDataService: ProductDataService,
              private cookieService: CookieService ) { }

  ngOnInit() {
    this.downloadInitData();
    this.comandaProducts = [];
    this.productsFiltered = [];
    //this.products = [];
    this.typeView = 0;
    let contFilter = 0;
    // this.shopAction = 0;
    this.productDataService.getAllProducts().subscribe(
      outPutData => {
         if(outPutData.length > 0 && Array.isArray(outPutData) && JSON.parse(outPutData[0]) == true) {
           for (let productJSON of outPutData[1]) {
             let product = new Products();
             Object.assign(product,productJSON);
             this.product = product;
             let productType = new ProductType();
             productType = this.productsType.find(productType =>
             productType.getId()==product.getProductType().id);
             product.setProductType(product.getProductType());

             this.products.push(this.product);

             contFilter += 1;
           }
           this.arrayAux = this.products;
           for(let i=0;i<this.arrayAux.length/2;i++){
             this.productsFiltered1.push(this.arrayAux[i]);
           }
           let number =  0;
           number = this.arrayAux.length /2;
           for(let j=number;j<this.arrayAux.length;j++){
             this.productsFiltered2.push(this.arrayAux[j]);
           }


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
   this.priceFilter = 100;
   this.productsFiltered = this.products;



   this.shopAction = 0;
   //console.log(this.arrayAux);


   if(sessionStorage.getItem('connectedUser')){
     let cookieObj:any =   JSON.parse(sessionStorage.getItem("connectedUser"));
     let userConnected = new User();
     Object.assign(userConnected,cookieObj);
     this.roleUser = cookieObj.role;
   }


  if(this.cookieService.check("cart")){
    this.cartCont = 0;
     let cart:any =
           JSON.parse(this.cookieService.get("cart"));
     for(let i=0;i<cart.length;i++){
        this.cartCont++;
        let comandaProducts = new ComandaProducts();
        Object.assign(comandaProducts,cart[i]);
        this.comandaProducts.push(comandaProducts);
     }

     let cartCont:any =
           JSON.parse(this.cookieService.get("cartCont"));

     //Object.assign(this.cartCont,cartCont);
     this.cartCont = cartCont;
   }


   ///CREATE COMANDA OBJECT
   this.comanda = new Comanda();
   this.comanda.setId(0);
   this.comanda.setIdUser(0);
   let date = new Date();
   this.comanda.setDate(date);
   this.comanda.setStatus("To Delivery");

}

private downloadInitData  () : void {
  this.productDataService.downloadInitData().subscribe(
   outPutData => {
     if(Array.isArray(outPutData) && outPutData.length > 0)
     {
       if(outPutData[0]=== true)
       {
         this.productsType =[];
         // this.productsType = [];
         for (let i:number = 0; i < outPutData[1].length; i++) {
             let productType = new ProductType();
             Object.assign(productType,outPutData[1][i]);
             // console.log(productType);
             this.productsType.push(productType);

         }
         //console.log(this.productsType);
       } else {
         alert("There has been an error, try later");
         console.log("Error in ProductsMainComponent (downloadInitData): outPutData is false: "
                 + JSON.stringify(outPutData));
         this.router.navigate(["userApp"]);
       }
     } else {
       alert("There has been an error, try later");
       console.log("Error in ProductsMainComponent (downloadInitData): outPutData is not array"
               + JSON.stringify(outPutData));
       this.router.navigate(["userApp"]);
     }
   }
 );
 //console.log(this.productsType);

}

  filter (): void {
   this.productsFiltered = this.products.filter( product => {
       let priceValid = false;
       let nameValid = false;
       let typeValid = false;

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

<<<<<<< HEAD
       if(this.typefilter != undefined) {
         if(product.getProductType().name.indexOf(this.typefilter.name)!= -1) {
=======
       if(this.typefilter != "" && this.typefilter != undefined) {
         /*if(productTypr.getName().toLowerCase().indexOf(this.typefilter.toLowerCase())!= -1) {
>>>>>>> 549ac73ece91c15f7440f227945c3d1ba0f23588
           typeValid = true;
         } else {typeValid = false;}*/
       }
       // console.log(this.typefilter.name);
       return (nameValid && priceValid && typeValid);
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
        if(error.error.text.includes("Error executing query")){
          alert("Sorry, This product can not be removed for you to order, try later");
        }
        else{
          alert("Sorry, there has been an error, try later");
          console.log("ProductManagmentComponent (removeProduct). Error happened: " + JSON.stringify(error));
          this.router.navigate(["products"]);
        }
      }
    );
  }

  goToDetail (product : Products) : void {
    this.productDetail = product;
    this.shopAction = 1;
  }



  setShopActionManagement(action:number): void{
    this.shopAction=action;
    this.ngOnInit();
  }

  addCart(product: Products):void{
    this.comandaPs = new ComandaProducts();
    let flag = false;

    //cart cont items
    this.cartCont++;
    this.cookieService.set('cartCont',JSON.stringify(this.cartCont));
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
          this.cookieService.set('cart',JSON.stringify(this.comandaProducts));
          break;
        }else{
          this.comandaPs.setQuantitat(1);
          this.comandaPs.setIdProducto(product.id);
          flag = true;
        }
      }
      if(flag){

        this.comandaProducts.push(this.comandaPs);
        this.comanda.setProductsComanda(this.comandaProducts);
        this.cookieService.set('cart',JSON.stringify(this.comandaProducts));
      }
    }else{
      this.comandaPs.setQuantitat(1);
      this.comandaPs.setIdProducto(product.id);
      this.comandaProducts.push(this.comandaPs);
      this.comanda.setProductsComanda(this.comandaProducts);
      this.cookieService.set('cart',JSON.stringify(this.comandaProducts));
    }
  }

  calculateTotalPrice(){
    let totalPrice = 0;

    return totalPrice;
  }

  goToCommand():void{
    this.shopAction = 2;
  }
}
