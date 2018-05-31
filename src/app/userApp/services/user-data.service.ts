import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';

import {Observable} from 'rxjs/Rx';

import {User} from '../model/user';

@Injectable()
export class UserDataService {

  // private mainUrl : string = "http://provenapps.cat/~daw1801/food4fitness/src/app/userApp/php/controllers/MainController.php";
  private mainUrl : string = "http://localhost/food4fitness/src/app/userApp/php/controllers/MainController.php";

  private httpParams: HttpParams;
  private body: any;

  constructor(private httpClient: HttpClient) { }

  userConnection (user:User) : Observable<any[]> {
      this.body = {
        action: '10000',
        jsonData: JSON.stringify(user)
      }

      return this.accessServer();
  }

  createUser(user:User): Observable<any[]> {
      this.body = {
        action: '10010',
        jsonData: JSON.stringify(user)
      }

      return this.accessServer();
  }

  sessionControl (): Observable<any[]> {
      this.body = {
        action: '10030',
        jsonData: ''
      }

      return this.accessServer();
  }

  logOut (): Observable<any[]> {
      this.body = {
        action: '10040',
        jsonData: ''
      }

      return this.accessServer();
  }

  downloadInitData():Observable<any[]> {
      this.body = {
        action: '10070',
        jsonData: ''
      }

      return this.accessServer();
  }

  modifyUser(user:User):Observable<any[]>{
    this.body = {
      action: '10020',
      jsonData: JSON.stringify(user)
    }
    return this.accessServer();
  }

  deleteUser(user:User):Observable<any[]>{
    this.body = {
      action: '10080',
      jsonData: JSON.stringify(user)
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
