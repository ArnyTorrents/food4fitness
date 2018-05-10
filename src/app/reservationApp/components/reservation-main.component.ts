import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

//Model
import {Comanda} from "./../model/comanda"

//Servicies
//import {ReservationDataService} from './../services/reservation-data.service';
import {UserDataService} from './../../userApp/services/user-data.service';


@Component({
  selector: 'restaurant-main',
  templateUrl: './../views/restaurant-main.view.html',
  styleUrls: ['./../css/restaurant-main.style.css'],
  providers: [UserDataService]
})
export class ReservationMainComponent implements OnInit {

  //Properties
  restaurantAction: number;

  constructor(private userDataService : UserDataService,
              private router : Router) { }

  ngOnInit() {
    this.restaurantAction=0;

    /*this.userDataService.sessionControl().subscribe(
      outPutData => {
        if(Array.isArray(outPutData) && outPutData.length > 0)
        {
          outPutData[0] = true;
          if(outPutData[0]=== true)
          {
            this.downloadInitData();
          } else {
            this.router.navigate(["userApp"]);
          }
        } else {
          alert("There has been an error, try later");
          console.log("Error in ReservationMainComponent (ngOnInit): outPutData is not array"
                  + JSON.stringify(outPutData));
        }
      },
      error => {
        alert("There has been an error, try later");
        console.log("Error in ReservationMainComponent (ngOnInit): "
                    +JSON.stringify(error));
      }
    );*/
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
