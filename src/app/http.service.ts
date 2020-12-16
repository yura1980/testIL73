import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {DatePipe} from '@angular/common';

// сервис HTTP запросов к API
@Injectable({
  providedIn: 'root',
})
export class HttpService {
  private readonly baseUrl = 'http://medosmotr-plus.ru/test_api.php/';
  private readonly header = {headers: new HttpHeaders().set('Content-Type', 'application/json')};

  constructor(private http: HttpClient) {
  }

  getData(table: string) {
    return this.http.get(this.baseUrl + table);
  }

  postDataId(table: string, body: any) {
    return this.http.post(this.baseUrl + table, body, {
      headers: new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
    });
  }

  transformDate(date: Date, format: string = 'yyyy-MM-dd') {
    return new DatePipe('en-US').transform(date, format);
  }

  GD(date: Date, format: string = 'yyyy-MM-dd HH:mm:ss') {
    return this.transformDate(date, format);
  }

}
