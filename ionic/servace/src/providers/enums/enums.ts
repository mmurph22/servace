import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

/*
  Generated class for the EnumsProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/

//@Injectable()
export enum LoginRole {
  Administrator=1,
  Volunteer,
  Coordinator
}

/*
@Injectable()
export class EnumsProvider {

  constructor(public http: HttpClient) {
    console.log('Hello EnumsProvider Provider');
  }
}
*/
