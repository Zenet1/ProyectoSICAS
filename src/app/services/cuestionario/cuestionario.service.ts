import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CuestionarioService {

  API: string = '';

  constructor(private clienteHttp: HttpClient) { }

  obtenerPreguntas(){
    return this.clienteHttp.get(this.API);
  }
}
