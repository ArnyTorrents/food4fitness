import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

//Model
import {Comanda} from "./../model/comanda"

//CookieService
import { CookieService } from 'ngx-cookie-service';
//import {ReservationDataService} from './../services/reservation-data.service';
import {UserDataService} from './../../userApp/services/user-data.service';
import {User} from './../model/user'

@Component({
  selector: 'restaurant-main',
  templateUrl: './../views/restaurant-main.view.html',
  styleUrls: ['./../css/restaurant-main.style.css'],
  providers: [UserDataService]
})
export class ReservationMainComponent implements OnInit {

  //Properties
  restaurantAction: number;
  user: User;

  constructor(private cookieService: CookieService,
              private userDataService : UserDataService,
              private router : Router) { }

  ngOnInit() {
    this.restaurantAction=0;

    /*if(this.cookieService.check("user")){
      let cookieObj:any =
            JSON.parse(this.cookieService.get("user"));
      let userConnected = new User();
      Object.assign(userConnected,cookieObj);
      console.log(cookieObj.name);
      //this.user.id = cookieObj.id;
      //this.user.setName(cookieObj.name);
      console.log(userConnected);
      this.user = userConnected;
    }*/
  }

  private downloadInitData () : void {
    // We access to the server in order to get
    // table preferences and reservation times
    // And especial Requests

  }

  //This event will be used in the child components
  setRestaurantAction(action:number): void
  {
    this.restaurantAction=action;
  }
}
