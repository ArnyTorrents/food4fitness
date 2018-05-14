import { Component, OnInit, Output, EventEmitter, ViewChild, Input} from '@angular/core';

import { Router } from '@angular/router';

import { User } from './../model/user';
import {UserDataService} from './../services/user-data.service';

@Component({
  selector: 'user-crud',
  styleUrls: ['./../css/general.css'],
  templateUrl: './../views/user-crud.view.html',
  providers: [UserDataService]
})

export class UsersCrudComponent implements OnInit {

  constructor(private router: Router,
          private userDataService: UserDataService) { }

  @Input() user : User;
  usersArray: User[]=[];
  userDetails: User;
  actionUser:number=0;
  userOption:number=0;
  ngOnInit(): void {
    this.userDataService.downloadInitData().subscribe(
     outPutData => {
      if(Array.isArray(outPutData) && outPutData.length > 0){
        if(outPutData[0]=== true){
          for (let i:number = 0; i < outPutData[1].length; i++) {
              let user = new User();
              Object.assign(user,outPutData[1][i]);
              this.usersArray.push(user);

          }
          console.log(this.usersArray);
        } else {
          alert("There has been an error, try later");
          console.log("Error in Login Crud Component (downloadInitData): outPutData is false: "
                  + JSON.stringify(outPutData));
        }
      } else {
        alert("There has been an error, try later");
        console.log("Error in Login Crud Component (downloadInitData): outPutData is not array"
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

  delete(userDelete: User): void{
    if(confirm("are you sure you want to delete this user?: "+userDelete.name)){
      console.log("delete");
    };
  }

  details(userDetails: User): void{
    console.log("xd");
    this.userDetails = userDetails;
    this.actionUser = 1;
    this.userOption = 2;
  }

}
