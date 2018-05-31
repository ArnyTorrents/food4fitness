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
  userAction:number=0;
  userOptions:number=0;

  ngOnInit(): void {
      this.usersArray = [];
      this.userDataService.downloadInitData().subscribe(
       outPutData => {
        if(Array.isArray(outPutData) && outPutData.length > 0){
          if(outPutData[0]=== true){
            for (let i:number = 0; i < outPutData[1].length; i++) {
                let user = new User();
                Object.assign(user,outPutData[1][i]);
                if(this.user.role=="master"){
                  this.usersArray.push(user);
                }else if(user.role!="master"){
                  this.usersArray.push(user);
                }
            }
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
    let userId = userDelete.id;
    if(confirm("are you sure you want to delete this user?: "+userDelete.name)){
      this.userDataService.deleteUser(userDelete).subscribe(
        outPutData =>{
          if(Array.isArray(outPutData) && outPutData.length>0){
            if(outPutData[0]===true){
              alert("User Correctly Deleted");
              this.usersArray.splice(userId,1);
              this.ngOnInit();
            }
          }else {
            alert("There has been an error, try later");
            console.log("Error in User Crud Component (Delete): outPutData is false: "
                    + JSON.stringify(outPutData));
          }
        },
        error => {
          alert("There has been an error, try later");
          console.log("Error in User CrudComponent (delete): "
                      +JSON.stringify(error));
        }
      );
    };
  }

  details(userDetails: User): void{
    this.userDetails = userDetails;
    this.actionUser = 1;
    this.userAction = 2;
    this.userOptions = 2;
    //console.log(this.userOptions);
  }

  goBack(userAction: number) {
    this.actionUser = userAction;
  }

}
