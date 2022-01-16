import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AsistenciaAlumnoService {
  API: string = '/ProyectoSICAS/DB_PHP/refactor/API/Alumnos.Ruta.php';
  API1:string = "/ProyectoSICAS/DB_PHP/Reservas.Service.php";
  API2: string = '/ProyectoSICAS/DB_PHP/Email.Service.php';
  
  constructor(private clienteHttp: HttpClient) { }

  enviarAsistencia(datosClases:any):Observable<any>{
    return this.clienteHttp.post<any>(this.API, JSON.stringify({accion: "insertarReservasAlumno", datos: datosClases}));
  }

  enviarCorreo(datos:any):Observable<any>{
    return this.clienteHttp.post<any>(this.API, datos);
  }

  obtenerClases(accion:any){
    return this.clienteHttp.post<any>(this.API, JSON.stringify({accion: "obtenerClasesAlumno"}));
  }

  combrobarReservacion(){
    return this.clienteHttp.post(this.API, JSON.stringify({accion: "validacionReservasAlumno"}));
  }
}