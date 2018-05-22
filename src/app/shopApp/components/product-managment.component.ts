import { Component, OnInit, ViewChild,
  Input, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';

//Model
import { Comanda } from "./../model/comanda";
import { ComandaProducts} from "./../model/comanda-products";

import { Products } from './../model/products';
import { ProductType} from './../model/productType';

//Service
import { ProductDataService } from './../services/product-data.service';


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

  //Cart
  cartCont:number=0;
  comanda: Comanda;
  //comandaPs: ComandaProducts;
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
              private productDataService: ProductDataService ) { }

  ngOnInit() {
    this.typeView = 0;


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

             console.log(this.products);
           }
         } else {
           alert("Sorry, there has been an error, try later");
           console.log("ProductsMainComponent (ngOnInit): outPutData is false or not array: "
                   + JSON.stringify(outPutData));
           this.router.navigate(["products"]);
         }
       },
       error => {
         alert("Sorry, there has been an error, try later");
         console.log("ProductsMainComponent (ngOnInit). Error happened: " + JSON.stringify(error));
         this.router.navigate(["products"]);
       }
   );
  }

  goToDetail (product : Products) : void {
    this.productDetail = product;
    this.shopAction = 1;
  }

  setShopActionManagement(action:number): void{
    this.shopAction=action;
  }

  addCart(product: Products):void{
    this.cartCont++;
    this.comandaPs.idComanda = 0;
    this.comandaPs.idProducto = product.id;
    this.comandaPs.quantitat = 1;

    //comanda=>id,idUser,productsComanda,totalPrice,date,status
    this.comanda.id = 0;
    this.comanda.idUser = 0;
    this.comanda.productsComanda = this.comandaPs;
    this.comanda.totalPrice = this.calculateTotalPrice();
    this.comanda.date = new Date();
    this.comanda.status = "To Delivery";
    //this.comanda.setId(1);
    this.comandaProducts.push(this.comandaPs);
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
