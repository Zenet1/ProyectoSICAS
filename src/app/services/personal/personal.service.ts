import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PersonalService {
  API_Personal: string = '';

  constructor(private clienteHttp: HttpClient) { }
  
  enviarAsistencia(datosPersonal:any):Observable<any>{
    let datos = JSON.stringify({accion: "insertarReservaPersonal", contenido: datosPersonal});
    return this.clienteHttp.post<any>(this.API_Personal, datos);
  }

  combrobarReservacion(){
    let datos = JSON.stringify({accion: "validacionReservaPersonal"});
    return this.clienteHttp.post(this.API_Personal, datos);
  }
}