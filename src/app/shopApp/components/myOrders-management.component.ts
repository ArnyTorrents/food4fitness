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
  import { ComandaDataService } from './../services/comanda-data.service';
  import { ComandaProductsDataService } from './../services/comandaProducts-data.service';
  import { ProductDataService } from './../services/product-data.service';
  
  //Cookie
  import { CookieService } from 'ngx-cookie-service';
  
  @Component({
    selector: 'my-orders',
    templateUrl: './../views/myOrders-management.view.html',
    styleUrls: ['./../css/comanda.component.css'],
    providers: [ComandaDataService,ComandaProductsDataService,ProductDataService]
  })
  export class MyOrdersManagement implements OnInit {

    constructor(private router: Router,
        private comandaDataService: ComandaDataService,
        private productDataService: ProductDataService,
        private cookieService: CookieService ) { }


    myOrders: Comanda[]=[];
    user: User;

    ngOnInit() {

      let cookieObj:any =   JSON.parse(sessionStorage.getItem("connectedUser"));
      this.user = cookieObj;
      let userConnected = new User();
      Object.assign(userConnected,cookieObj);
      this.user = userConnected;

      this.comandaDataService.listComanda(this.user).subscribe(
        outPutData => {
          //console.log(this.outPutData[1]);
          if(Array.isArray(outPutData) && outPutData.length > 0){
            if(outPutData[0]=== true){
              this.myOrders = [];
              for (let i:number = 0; i < outPutData[1].length; i++) {
                  let comanda = new Comanda();
                  Object.assign(comanda,outPutData[1][i]);
                  this.myOrders.push(comanda);
              }
              console.log("true");
            }
          } else {
            alert("There has been an error, try later");
            console.log("Error in Comanda-details (insert ): outPutData is not array"
                    + JSON.stringify(outPutData));
          }
        },
        error => {
          alert("There has been an error, try later");
          console.log("Error in Comanda-details (insert): "
                      +JSON.stringify(error));
        }        
      );
    }


  }