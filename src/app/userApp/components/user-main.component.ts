import { Component, OnInit, Input } from '@angular/core';

import { User } from './../model/user';

import { UserLoginComponent } from './user-login.component';

@Component({
  selector: 'user-main',
  styleUrls: ['./../css/general.css'],
  templateUrl: './../views/user-main.view.html',
  providers: []
})

export class UserMainComponent implements OnInit {
  user: User;
  userAction: number = 0;

  constructor(
  ) { }

  ngOnInit(): void {

  }

  goBack(userAction: number) {
    this.userAction = userAction;
  }
}
