import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';

import {Observable} from 'rxjs/Rx';

import { Products } from './../model/products';

@Injectable()
export class ProductDataService {

  private mainUrl : string = "http://localhost/food4fitness/src/app/shopApp/php/controllers/MainController.php";

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

  getAllProducts(): Observable<any[]> {
    this.body = {
         action: "10020",
         jsonData: ""
    }

    return this.accessServer();
  }

  insertProducts(Products : Products) : Observable<any[]> {
      this.body = {
        action: '10010',
        jsonData: JSON.stringify(Products)
      }

      return this.accessServer();
  }

  modifyProducts(Products:Products): Observable<any[]> {
    this.body = {
          action: "10030",
          jsonData: JSON.stringify(Products)
    }

    return this.accessServer();
  }

  removeProducts(Products:Products): Observable<any[]> {
    this.body = {
          action: "10040",
          jsonData: JSON.stringify(Products)
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
