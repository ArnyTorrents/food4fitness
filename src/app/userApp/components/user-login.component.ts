import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';

import { User } from './../model/user';
import {UserDataService} from './../services/user-data.service';
import { CookieService } from 'ngx-cookie-service';

@Component({
  selector: 'user-login',
  styleUrls: ['./../css/general.css'],
  templateUrl: './../views/user-login.view.html',
  providers: [UserDataService]
})

export class UserLoginComponent implements OnInit {
  users: User[];
  userConnected: User;
  validUserData = true;

  @Output() goBack = new EventEmitter<number>();


  constructor(private cookieService: CookieService,
              private router: Router,
              private userDataService: UserDataService
  ) { }


  ngOnInit(): void {
      this.userConnected = new User();

      this.userDataService.sessionControl().subscribe(
        outPutData => {
          if(Array.isArray(outPutData) && outPutData.length > 0)
          {
            if(outPutData[0]=== true)
            {
              //console.log("log");
              //console.log(outPutData[1]);
              //this.router.navigate(["shopApp"]);
            }
          } else {
            alert("There has been an error, try later");
            console.log("Error in UserLoginComponent (ngOnInit): outPutData is not array"
                    + JSON.stringify(outPutData));
          }
        },
        error => {
          alert("There has been an error, try later");
          console.log("Error in UserLoginComponent (ngOnInit): "
                      +JSON.stringify(error));
        }
      );
  }

  connection(): void {
    this.userDataService.userConnection(this.userConnected)
        .subscribe(
          outPutData => {
            if(Array.isArray(outPutData) && outPutData.length > 0)
            {
              if(outPutData[0]=== true)
              {
                sessionStorage.setItem("connectedUser",
                          JSON.stringify(outPutData[1][0]));
                //console.log(outPutData[1][0]);
                this.cookieService.set('user',
                JSON.stringify(outPutData[1][0]));

                location.reload();
                this.router.navigate(["shopApp"]);

              } else {
                this.validUserData = false;
              }
            } else {
              alert("There has been an error, try later");
              console.log("Error in UserLoginComponent (connection): outPutData is not array"
                      + JSON.stringify(outPutData));
            }
          },
          error => {
            alert("There has been an error, try later");
            console.log("Error in UserLoginComponent (connection): "
                        +JSON.stringify(error));
          }
        );

  }
}
