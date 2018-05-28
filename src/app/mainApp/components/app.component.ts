import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { User } from './../../userApp/model/user';

import {UserDataService} from './../../userApp/services/user-data.service';

//
import {ComandaProducts} from './../../shopApp/model/comanda-products';
//CookieService
import { CookieService } from 'ngx-cookie-service';

//123456
@Component({
  selector: 'app-main',
  styleUrls: ['./../css/app.component.css'],
  templateUrl: './../views/app.component.html',
  providers: [UserDataService]
})

export class AppComponent implements OnInit {
  title = 'Welcome to the best resturant ever';

  userConnected:User;
  userLogged: number;
  comandaProducts: ComandaProducts[]=[];

  constructor(private cookieService: CookieService,
              private router : Router,
              private userDataService : UserDataService
  ) { }

  ngOnInit(): void {
    if(this.cookieService.check("cart")){
      let cookieObj:any =
            JSON.parse(this.cookieService.get("cart"));
      let comanda = new ComandaProducts();
      Object.assign(comanda,cookieObj);
      console.log(cookieObj);
    }else{
      console.log("no cart");
    }

    if(sessionStorage.getItem('connectedUser')){
        let cookieObj:any =   JSON.parse(sessionStorage.getItem("connectedUser"));
        //console.log(cookieObj);
        let userConnected = new User();
        Object.assign(userConnected,cookieObj);
        //this.roleUser = cookieObj.role;
      this.userConnected = userConnected;
      this.userLogged = 1;
    }else{
      this.userLogged = 0;
    }
  }

  logOut(): void {
    this.userLogged = 0;
    this.userDataService.logOut().subscribe(
      outPutData => {
        if(Array.isArray(outPutData) && outPutData.length > 0)
        {
          //outPutData[0] = true;
          if(outPutData[0]=== true)
          {
            location.reload();
            this.router.navigate(["userApp"]);
            sessionStorage.removeItem("connectedUser");
          }
        } else {
          alert("There has been an error, try later");
          console.log("Error in AppComponent (logOut): outPutData is not array"
                  + JSON.stringify(outPutData));
        }
      },
      error => {
        alert("There has been an error, try later");
        console.log("Error in AppComponent (logOut): "
                    +JSON.stringify(error));
      }
    );
    this.userLogged = 0;
    //this.cookieService.deleteAll();
  }
  logIn():void{
    this.router.navigate(["userApp"]);
  }

  productManagment():void {
    this.router.navigate(["products"]);

  }

  home():void{
    this.router.navigate(["shopApp"]);
  }

  usersCrud():void{
    this.router.navigate(["userApp"]);
  }
}
