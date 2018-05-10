import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { User } from './../../userApp/model/user';

import {UserDataService} from './../../userApp/services/user-data.service';
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

  constructor(private router : Router,
    private userDataService : UserDataService
  ) { }

  ngOnInit(): void {

  }

  logOut(): void {
    this.userDataService.logOut().subscribe(
      outPutData => {
        if(Array.isArray(outPutData) && outPutData.length > 0)
        {
          //outPutData[0] = true;
          if(outPutData[0]=== true)
          {
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
  }
}
