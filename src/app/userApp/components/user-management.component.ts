import { Component, OnInit, Output, EventEmitter, ViewChild} from '@angular/core';
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
  user: User;
  userOption: number = 1;
  userImageFile: File;
  validFile: boolean = false;
  passControl: string;

  @ViewChild('useManagementForm') useManagementForm: HTMLFormElement;

  @Output() goBack = new EventEmitter<number>();


  constructor(private router: Router,
          private userDataService: UserDataService
  ) { }


  ngOnInit(): void {
      this.user = new User();
  }

  checkPassword(): void {
    if(this.user.getPassword()!=this.passControl)
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

  registerUser (): void {
    let filesNames : string [] = [];
    filesNames.push(this.user.nickName);

    this.userDataService.uploadFiles(this.userImageFile,filesNames).subscribe(
      outPutData => {
        if(Array.isArray(outPutData) && outPutData.length > 0)
        {
          if(outPutData[0]=== true)
          {
              //We will go again to the server in order to
              //insert user details in database
          }
        } else {
          alert("There has been an error, try later");
          console.log("Error in UserManagementComponent (registerUser - uploadFiles): outPutData is not array"
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
