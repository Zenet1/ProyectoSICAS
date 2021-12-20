import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CuestionarioService {

  API: string = '/ProyectoSICAS/DB_PHP/Preguntas.Servicio.php';

  constructor(private clienteHttp: HttpClient) { }

  obtenerPreguntas(){
    return this.clienteHttp.get(this.API);
  }
}
