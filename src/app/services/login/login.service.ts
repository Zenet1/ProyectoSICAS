import { HttpClient } from '@angular/common/http';
import { Injectable, Output, EventEmitter } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  API: string = '/SICAS/DB_PHP/Autenticacion.Servicio.php';
  redirectUrl: string;
 
  @Output() getLoggedInName: EventEmitter<any> = new EventEmitter();

  constructor(private httpClient : HttpClient) { }

  public iniciarSesion(datos:FormGroup) {
    return this.httpClient.post<any>(this.API, datos).pipe(map(Users => {
      this.setToken(Users[0].name);
      this.getLoggedInName.emit(true);
      return Users
    }));
  }
  
  setToken(token: string) {
    localStorage.setItem('token', token);
  }
  
  getToken() {
    return localStorage.getItem('token');
  }
  
  deleteToken() {
    localStorage.removeItem('token');
  }
  
  isLoggedIn() {
    const usertoken = this.getToken();
    if (usertoken != null) {
      return true
    }
    return false;
  }
}