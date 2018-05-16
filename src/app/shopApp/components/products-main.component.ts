import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

//Model
import { Comanda } from "./../model/comanda";
import { Products } from './../model/products';
import { ProductType } from './../model/productType';


import { ProductDataService } from './../services/product-data.service';

@Component({
  selector: 'products-main',
  templateUrl: './../views/products-main.view.html',
  styleUrls: ['./../css/products-main.style.css'],
  providers: [ProductDataService]
})
export class ProductsMainComponent implements OnInit {

  shopAction: number;
  productsType:ProductType[];
  products: Products[] = [];

  constructor(private productDataService : ProductDataService,
              private router : Router) { }

  ngOnInit() {
    this.shopAction=0;
    this.downloadInitData();
  }

  private downloadInitData  () : void {
    this.productDataService.downloadInitData().subscribe(
     outPutData => {
       if(Array.isArray(outPutData) && outPutData.length > 0)
       {
         if(outPutData[0]=== true)
         {
           this.productsType = [];
           for (let i:number = 0; i < outPutData[1].length; i++) {
               let productType = new ProductType();
               Object.assign(productType,outPutData[1][i]);
               //console.log(productType);
               this.productsType.push(productType);
           }

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

  }

  setShopAction(action:number): void
   {
     this.shopAction=action;
   }

}
