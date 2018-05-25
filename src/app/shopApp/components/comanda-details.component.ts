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

//Cookie
import { CookieService } from 'ngx-cookie-service';

@Component({
  selector: 'comanda-details',
  templateUrl: './../views/comanda-details.component.html',
  styleUrls: ['./../css/comanda-details.component.css'],
  providers: [ComandaDataService,ComandaProductsDataService]
})
export class ComandaDetails implements OnInit {


  @ViewChild('comandaDetails') comandaDetails: HTMLFormElement;

  @Input() comanda: Comanda;
  user: User;
  cont: number;
  methodsOfPayment: any[]=[];
  creditCard: string;
  validCard: boolean;

  //method: string;

  constructor(private cookieService: CookieService,
              private comandaDataService: ComandaDataService,
              private comandaProductsService: ComandaProductsDataService) { }

  ngOnInit() {
      console.log(this.comanda.productsComanda);
      this.methodsOfPayment = ["Credit Card","Cash on delivery"];

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

  addRemoveSpecialRequest(method: string): void {
    console.log(this.comanda);
    this.comanda.setPaid(1);
  }


  cardValidation(input: string):void {
    /*This example goes one step futher and also checks that the number entered is valid according to the Luhn algorithm
    (also known as the "mod 10" algorithm).*/
    //valid NUMBER= 4111111111111111
    if(input.length==16){
      let sum = 0;
      let numdigits = input.length;
      let parity = numdigits % 2;
      for(let i=0; i < numdigits; i++) {
        let digit = parseInt(input.charAt(i))
        if(i % 2 == parity) digit *= 2;
        if(digit > 9) digit -= 9;
        sum += digit;
      }
      let xd = (sum % 10) == 0;
      this.validCard = xd;
      console.log(this.validCard);
    }else{
      this.validCard = false;
    }
  }

  confirm(){
    let flag = false
    this.comandaDataService.insertComanda(this.comanda).subscribe(
      outPutData => {
        if(Array.isArray(outPutData) && outPutData.length > 0){
          if(outPutData[0]=== true){
              /*alert("Comanda Insertada Correctamente");
              console.log(outPutData[1]);*/
              let flag = this.insertComandaProducts();
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

  insertComandaProducts():void{
    //this.comandaProductsService.insertComandaProducts()

  }
}
