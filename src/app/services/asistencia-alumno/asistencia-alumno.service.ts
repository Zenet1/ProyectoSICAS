import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AsistenciaAlumnoService {

  API:string = "/";
  constructor(private clienteHttp: HttpClient) { }

  enviarAsistencia(clases:any):Observable<any>{
    return this.clienteHttp.post<any>(this.API, clases);
  }

  obtenerClases(accion:any){
    return this.clienteHttp.post<any>(this.API, accion);
  }
}
