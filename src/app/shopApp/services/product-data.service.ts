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
        controller: 'product',
        action: '10000',
        jsonData: ""
      }

      return this.accessServer();
  }

  getAllProducts(): Observable<any[]> {
    this.body = {
         controller: 'product',
         action: "10020",
         jsonData: ""
    }

    return this.accessServer();
  }

  insertProducts(product : Products) : Observable<any[]> {
      this.body = {
        action: '10010',
        jsonData: JSON.stringify(product)
      }

      return this.accessServer();
  }

  modifyProducts(product:Products): Observable<any[]> {
    this.body = {
          action: "10030",
          jsonData: JSON.stringify(product)
    }

    return this.accessServer();
  }

  removeProducts(product:Products): Observable<any[]> {
    this.body = {
          action: "10040",
          jsonData: JSON.stringify(product)
    }

    return this.accessServer();
  }

  uploadFiles (file : File, filesNames: string[]): Observable<any[]> {
    this.httpParams = new HttpParams()
      .append('action', "10050")
      .append('jsonData', JSON.stringify(filesNames));

    let fileFormData : FormData = new FormData();
    fileFormData.append("images[]",file, file.name);

    this.body = fileFormData;

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
