import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RegistroExternoService {

  API: string = '/ProyectoSICAS/DB_PHP/RegistroExternos.Servicio.php';
  
  constructor(private clienteHttp: HttpClient) {}

  guardarExterno(datos:FormGroup):Observable<any>{
    return this.clienteHttp.post(this.API, datos);
  }
}