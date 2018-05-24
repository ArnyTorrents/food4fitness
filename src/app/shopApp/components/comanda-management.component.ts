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
  selector: 'main-comanda',
  templateUrl: './../views/comanda.component.html',
  styleUrls: ['./../css/comanda.component.css']
})
export class ComandaManagement implements OnInit {

  @Input() comandaProducts : ComandaProducts[]=[];
  @Input() products:  Products[]=[];
  @Input() comanda: Comanda;

  @Output() setShopActionManagement:EventEmitter<number>
              = new EventEmitter<number>();

  productsSelected: any[]=[];
  product: any;
  shopAction:number;
  cartCont: number=0;

  constructor(private cookieService: CookieService) { }

  ngOnInit() {

    this.productsSelected = [];
    this.shopAction = 1;
    let total = 0;
    let finalPrice = 0;
    if(this.comandaProducts.length>0){
      for(let i=0;i<this.comandaProducts.length;i++){
        for(let j=0;j<this.products.length;j++){
          if(this.comandaProducts[i].idProducto == this.products[j].id){
            let price = this.products[j].price;
            let quantity = this.comandaProducts[i].quantitat;
            total = price*quantity;
            finalPrice = finalPrice+total;
            this.productsSelected.push(this.products[j]);
            this.comanda.setTotalPrice(finalPrice);
          }
        }
      }
    }else{
      this.shopAction = 3;
    }

  }

  calculateTotalPrice():void{
    let total = 0;
    let finalPrice = 0;
    for(let i=0;i<this.comandaProducts.length;i++){
      for(let j=0;j<this.products.length;j++){
        if(this.comandaProducts[i].idProducto == this.products[j].id){
          let price = this.products[j].price;
          let quantity = this.comandaProducts[i].quantitat;
          total = price*quantity;
          finalPrice = finalPrice+total;
          this.comanda.setTotalPrice(finalPrice);
        }
      }
    }
  }

  checkandPay():void{
    if(sessionStorage.getItem('connectedUser')){
      let cookieObj:any =   JSON.parse(sessionStorage.getItem("connectedUser"));
      this.shopAction = 2;
      this.comanda.setIdUser(cookieObj.id);
      this.comanda.setProductsComanda(this.comandaProducts);

      for(let j=0;j<this.comandaProducts.length;j++){
        this.cartCont = this.cartCont+this.comandaProducts[j].quantitat;
      }

      this.cookieService.set('cartCont',JSON.stringify(this.cartCont));

      /*let cartCont:any =
            JSON.parse(this.cookieService.get("cartCont"));

      console.log(cartCont);*/
    }else{
      alert("You Must Be Logged to Make the payment");
    }
  }

  deleteProduct(product: Products):void{
    let cont=0;
    for(let i=0;i<this.comandaProducts.length;i++){
      if(this.comandaProducts[i].idProducto==product.id){
        this.comandaProducts.splice(i,1);
      }
    }

    for(let j=0;j<this.comandaProducts.length;j++){
      this.cartCont = this.cartCont+this.comandaProducts[j].quantitat;
    }

    this.cookieService.set('cart',JSON.stringify(this.comandaProducts));
    this.cookieService.set('cartCont',JSON.stringify(this.cartCont));
    this.ngOnInit();

  }

}
