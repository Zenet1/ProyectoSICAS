import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CuestionarioService {

  API_Preguntas:string = '/ProyectoSICAS/DB_PHP/refactor/API/Preguntas.Ruta.php';

  constructor(private clienteHttp: HttpClient) { }

  obtenerPreguntas(){
    let datos  = JSON.stringify({accion: "recuperarPreguntas"});
    return this.clienteHttp.post(this.API_Preguntas, datos);
  }

  rechazado(datosPreguntas:any):Observable<any>{
    let datos  = JSON.stringify({accion: "enviarCorreo", contenido: datosPreguntas});
    return this.clienteHttp.post<any>(this.API_Preguntas, datos);
  }
}