import { Component, OnInit, Output, Input,EventEmitter, ViewChild} from '@angular/core';
import { Router } from '@angular/router';

import { User } from './../model/user';
import {UserDataService} from './../services/user-data.service';

@Component({
  selector: 'user-management',
  styleUrls: ['./../css/general.css'],
  templateUrl: './../views/user-management.view.html',
  providers: [UserDataService]
})

export class UserManagementComponent implements OnInit {
  userNew: User;
  userOptions: number = 1;
  userImageFile: File;
  validFile: boolean = false;
  passControl: string;
  roleArray: string[]=[];

  @Input() userDetails : User;
  @Input() userAction : number;
  @Input() user : User;
  //@Input() userOption : number;

  @ViewChild('useManagementForm') useManagementForm: HTMLFormElement;

  @Output() goBack:EventEmitter<number>
              = new EventEmitter<number>();




  constructor(private router: Router,
          private userDataService: UserDataService
  ) { }


  ngOnInit(): void {
      console.log(this.userOptions);
      this.userNew = new User();
      this.userOptions = this.userAction;
      if(this.userOptions==2){
        this.userNew = this.userDetails;
      }if(this.userOptions==1){
        this.userNew.role = "user";
      }
      if(this.user!=undefined){
        if(this.user.role == "master"){
          this.roleArray = ["admin","user","master",];
        }else{
          this.roleArray = ["admin","user"];
        }
      }
  }

  checkPassword(): void {
    if(this.userNew.getPassword()!=this.passControl)
    {
      this.useManagementForm.controls["password2"].setErrors({incorrect:true});
    } else {
      this.useManagementForm.controls["password2"].setErrors(null);
    }
  }

  getFiles(event): void{
    if (event.target.files.length> 0)
    {
      this.userImageFile = event.target.files[0];
      this.validFile = true;
    }
    else {
      this.validFile = false;
    }
  }

  registeruserNew (): void {
    console.log(this.userAction);
    if(this.userAction==3){
      this.userNew.role = "user";
      console.log(this.userNew);
      this.userDataService.createUser(this.userNew).subscribe(
        outPutData => {
          if(Array.isArray(outPutData) && outPutData.length > 0){
            if(outPutData[0]=== true){
                alert("Usuario Registrado Correctamente");
            }
          } else {
            alert("There has been an error, try later");
            console.log("Error in UserManagementComponent (registerUser ): outPutData is not array"
                    + JSON.stringify(outPutData));
          }
        },
        error => {
          alert("There has been an error, try later");
          console.log("Error in UserManagementComponent (registerUser): "
                      +JSON.stringify(error));
        }
      );
    }else{
      //modify User
      this.userDataService.modifyUser(this.userNew).subscribe(
        outPutData =>{
          if(Array.isArray(outPutData) && outPutData.length > 0){
            if(outPutData[0]===true){
              alert("Data Correctly modified");
              console.log(outPutData[1]);
            }
          }else {
            alert("There has been an error, try later");
            console.log("Error in UserManagementComponent (Modify): outPutData is not array"
                    + JSON.stringify(outPutData));
          }
        },
        error => {
          alert("There has been an error, try later");
          console.log("Error in UserManagementComponent (registerUser - uploadFiles): "
                      +JSON.stringify(error));
        }
      );
    }

  }
}
