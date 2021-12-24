import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AsistenciaAlumnoService {

  API:string = "/";
  constructor(private clienteHttp: HttpClient) { }

  enviarAsistencia(datos:FormGroup):Observable<any>{
    return this.clienteHttp.post<any>(this.API, datos);
  }

  obtenerClases(accion:any){
    return this.clienteHttp.post<any>(this.API, accion);
  }
}
