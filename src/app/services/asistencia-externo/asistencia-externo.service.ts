import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AsistenciaExternoService {
  API:string = "/";
  API_ObtenerOficinas:string = "/ProyectoSICAS/DB_PHP/DevolverOficinas.Service.php";
  constructor(private clienteHttp: HttpClient) { }

  enviarAsistencia(datos:any):Observable<any>{
    return this.clienteHttp.post<any>(this.API, datos);
  }

  obtenerOficinas(){
    let accion = JSON.stringify({accion:"obtenerOficinas"})
    return this.clienteHttp.post<any>(this.API_ObtenerOficinas, accion);
  }
}
