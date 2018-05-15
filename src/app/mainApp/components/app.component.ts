import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { User } from './../../userApp/model/user';

import {UserDataService} from './../../userApp/services/user-data.service';
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

  constructor(private cookieService: CookieService,
              private router : Router,
              private userDataService : UserDataService
  ) { }

  ngOnInit(): void {
    if(this.cookieService.check("user")){
      let cookieObj:any =
            JSON.parse(this.cookieService.get("user"));
      let userConnected = new User();
      Object.assign(userConnected,cookieObj);
      console.log(cookieObj.name);
      //this.user.id = cookieObj.id;
      //this.user.setName(cookieObj.name);
      this.userConnected = userConnected;
      this.userLogged = 1;
    }else{
      this.userLogged = 0;
    }
  }

  logOut(): void {
    this.userDataService.logOut().subscribe(
      outPutData => {
        if(Array.isArray(outPutData) && outPutData.length > 0)
        {
          //outPutData[0] = true;
          if(outPutData[0]=== true)
          {
            location.reload();
            this.router.navigate(["userApp"]);
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
    this.cookieService.deleteAll();
  }
  logIn():void{
    this.router.navigate(["userApp"]);
  }

  usersCrud():void{
    this.router.navigate(["userApp"]);
  }
}
