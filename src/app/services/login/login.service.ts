import { HttpClient } from '@angular/common/http';
import { Injectable, Output, EventEmitter } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  API: string = '/ProyectoSICAS/DB_PHP/Autenticacion.Servicio.php';
  redirectUrl: string;
 
  @Output() getLoggedInName: EventEmitter<any> = new EventEmitter();

  constructor(private httpClient : HttpClient) { }

  usuario:any;

  public iniciarSesion(datos:FormGroup) {
    return this.httpClient.post<any>(this.API, datos).pipe(map(Users => {
      //console.log(Users["Rol"]);
      console.log(Users["Cuenta"]);
      this.setToken(Users["Rol"]);
      this.getLoggedInName.emit(true);
      return Users;
    }));
  }

  getUsuario(){
    return localStorage.getItem('token');
  }
  
  setToken(token:string) {
    console.log(token);
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