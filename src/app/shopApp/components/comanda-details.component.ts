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
  selector: 'comanda-details',
  templateUrl: './../views/comanda-details.component.html',
  styleUrls: ['./../css/comanda-details.component.css']
})
export class ComandaDetails implements OnInit {

  @Input() comanda: Comanda;
  user: User;
  cont: number;
  methodsOfPayment: any[]=[];

  constructor(private cookieService: CookieService ) { }

  ngOnInit() {

      this.methodsOfPayment = ["Paypal","Credit Card","Cash on delivery"];

      let cookieObj:any =   JSON.parse(sessionStorage.getItem("connectedUser"));
      let cartCont:any =
            JSON.parse(this.cookieService.get("cartCont"));
      this.user = cookieObj;
      this.cont = cartCont;


      let userConnected = new User();
      Object.assign(userConnected,cookieObj);
      this.user = userConnected;
      console.log(this.comanda);

  }

  addRemoveSpecialRequest(id: number): void {
    console.log(id);
  }



}
