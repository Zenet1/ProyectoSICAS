import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CuestionarioService {

  API: string = '/ProyectoSICAS/DB_PHP/Preguntas.Servicio.php';
  API2: string = '/ProyectoSICAS/DB_PHP/Email.Service.php';

  constructor(private clienteHttp: HttpClient) { }

  obtenerPreguntas(){
    return this.clienteHttp.get(this.API);
  }

  rechazado(datos:FormGroup):Observable<any>{
    return this.clienteHttp.post<any>(this.API2, datos);
  }
}
