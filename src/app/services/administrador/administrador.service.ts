import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class AdministradorService {
  API:string = "/";
  constructor(private clienteHttp: HttpClient) { }

  alertar(datos:FormGroup){
    return this.clienteHttp.post<any>(this.API, datos);
  }

  obtenerEdificios(){
    return this.clienteHttp.get(this.API);
  }

  obtenerOficinas(){
    return this.clienteHttp.get(this.API);
  }

  restaurarBD(archivo:FormGroup){
    const formData = new FormData();
    formData.append('archivo', archivo.get('archivo').value);
    return this.clienteHttp.post<any>(this.API, formData);
  }

  eliminarBD(){
    return this.clienteHttp.get(this.API);
  }

  respaldarBD(){
    return this.clienteHttp.get(this.API);
  }
}