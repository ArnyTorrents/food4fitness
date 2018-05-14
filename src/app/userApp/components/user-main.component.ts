import { Component, OnInit, Input } from '@angular/core';

import { User } from './../model/user';

import { UserLoginComponent } from './user-login.component';

import { CookieService } from 'ngx-cookie-service';
@Component({
  selector: 'user-main',
  styleUrls: ['./../css/general.css'],
  templateUrl: './../views/user-main.view.html',
  providers: []
})

export class UserMainComponent implements OnInit {
  user: User;
  userAction: number = 0;

  constructor(private cookieService: CookieService,
  ) { }

  ngOnInit(): void {
    
    if(this.cookieService.check("user")){
      this.userAction = 0;
      let cookieObj:any =
            JSON.parse(this.cookieService.get("user"));
      let userConnected = new User();
      Object.assign(userConnected,cookieObj);
      console.log(userConnected);
      this.user = userConnected;
      this.userAction = 2;
    }else{
      let userConnected = new User();
      this.userAction = 1;
      this.user = userConnected;
    }
  }

  goBack(userAction: number) {
    this.userAction = userAction;
  }
}
