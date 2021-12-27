import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CapturadorService {

  API:string = "/ProyectoSICAS/DB_PHP/Escaner.Service.php";

  constructor(private clienteHttp: HttpClient) { }

  verficar(escaneo:string){
    return this.clienteHttp.post<any>(this.API, escaneo);
  }
}