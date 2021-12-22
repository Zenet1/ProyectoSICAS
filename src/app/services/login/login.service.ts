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
      
      let token = JSON.stringify(Users);
      console.log(Users);
      if(Users!=null){
        this.setToken(token);
        this.getLoggedInName.emit(true);
        return Users;
      }
    }));
  }

  getUsuario(){
    return JSON.parse(localStorage.getItem('usuario')).Cuenta;
  }

  getRol(){
    return JSON.parse(localStorage.getItem('usuario')).Rol;
  }  
  setToken(token:string) {
    localStorage.setItem('usuario', token);
  }
  
  getToken() {
    return localStorage.getItem('usuario');
  }
  
  deleteToken() {
    localStorage.removeItem('usuario');
  }
  
  isLoggedIn() {
    const usertoken = this.getToken();
    if (usertoken != null) {
      return true
    }
    return false;
  }
}