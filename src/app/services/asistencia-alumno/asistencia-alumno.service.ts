import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AsistenciaAlumnoService {

  API:string = "/ProyectoSICAS/DB_PHP/Reservas.Service.php";
  constructor(private clienteHttp: HttpClient) { }

  enviarAsistencia(datos:any):Observable<any>{
    return this.clienteHttp.post<any>(this.API, datos);
  }

  obtenerClases(accion:any){
    return this.clienteHttp.post<any>(this.API, accion);
  }
}
