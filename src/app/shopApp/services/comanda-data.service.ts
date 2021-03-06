import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';

import {Observable} from 'rxjs/Rx';

import { Comanda } from './../model/comanda';

import { User} from './../model/user';

@Injectable()
export class ComandaDataService {

  private mainUrl : string = "http://localhost/food4fitness/src/app/shopApp/php/controllers/MainController.php";
  //private mainUrl : string = "http://provenapps.cat/~daw1801/food4fitness/src/app/shopApp/php/controllers/MainController.php";

  private httpParams: HttpParams;
  private body: any;

  constructor(private httpClient: HttpClient) { }

  insertComanda(comanda : Comanda) : Observable<any[]> {
      this.body = {
        controller: 'comanda',
        action: '10010',
        jsonData: JSON.stringify(comanda)
      }

      return this.accessServer();
  }

  listComanda(user: User):  Observable<any[]> {
    this.body = {
      controller: 'comanda',
      action: '10020',
      jsonData: JSON.stringify(user)
    }

    return this.accessServer();
}

  modifyComanda(comanda:Comanda): Observable<any[]> {
    this.body = {
          controller: 'comanda',
          action: "10030",
          jsonData: JSON.stringify(comanda)
    }

    return this.accessServer();
  }

  removeComanda(comanda:Comanda): Observable<any[]> {
    this.body = {
          action: "10040",
          jsonData: JSON.stringify(comanda)
    }

    return this.accessServer();
  }

  private accessServer() : Observable<any[]> {

    let httpHeaders : HttpHeaders = new HttpHeaders();

    httpHeaders.set('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');

    return this.httpClient.post<any[]>(this.mainUrl,
                this.body,
                {headers:httpHeaders,
                 params:this.httpParams});
  }

}
