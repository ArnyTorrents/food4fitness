import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';

import {Observable} from 'rxjs/Rx';

//import {Reservation} from '../model/reservation';

@Injectable()
export class ReservationDataService {

  private mainUrl : string = "http://localhost/food4fitness2/src/app/reservationApp/php/controllers/MainController.php";

  private httpParams: HttpParams;
  private body: any;

  constructor(private httpClient: HttpClient) { }

  downloadInitData() : Observable<any[]> {
      this.body = {
        action: '10000',
        jsonData: ""
      }

      return this.accessServer();
  }

  /*insertReservation(reservation : Reservation) : Observable<any[]> {
      this.body = {
        action: '10010',
        jsonData: JSON.stringify(reservation)
      }

      return this.accessServer();
  }

  getAllReservations(): Observable<any[]> {
    this.body = {
         action: "10020",
         jsonData: ""
    }

    return this.accessServer();
  }

  modifyReservation(reservation:Reservation): Observable<any[]> {
    this.body = {
          action: "10030",
          jsonData: JSON.stringify(reservation)
    }

    return this.accessServer();
  }

  removeReservation(reservation:Reservation): Observable<any[]> {
    this.body = {
          action: "10040",
          jsonData: JSON.stringify(reservation)
    }

    return this.accessServer();
  }*/

  private accessServer() : Observable<any[]> {

    let httpHeaders : HttpHeaders = new HttpHeaders();

    httpHeaders.set('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');

    return this.httpClient.post<any[]>(this.mainUrl,
                this.body,
                {headers:httpHeaders,
                 params:this.httpParams});
  }
}
