import { HttpClient } from '@angular/common/http';
import { Injectable, Output, EventEmitter } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  API: string = '/ProyectoSICAS/DB_PHP/refactor/API/Autenticacion.Servicio.php';
  API_Facultades:string = '';
  redirectUrl: string;
 
  @Output() getLoggedInName: EventEmitter<any> = new EventEmitter();

  constructor(private httpClient:HttpClient) { }

  public iniciarSesion(datos:FormGroup) {
    return this.httpClient.post<any>(this.API, datos).pipe(map(Users => {
      let token = JSON.stringify(Users);
      if(Users!=null){
        this.setToken(token);
        this.getLoggedInName.emit(true);
        return Users;
      }
    }));
  }

  obtenerFacultades(){
    let datos = JSON.stringify({accion:"recuperarFacultades"});
    return this.httpClient.post<any>(this.API_Facultades, datos);
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