import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class AdministradorService {
  API:string = "/ProyectoSICAS/DB_PHP/BDControl.Service.php";
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

  restaurarBD(datos:FormGroup){
    const formData = new FormData();
    formData.append('archivo', datos.get('archivo').value);
    formData.append('accion', 'restaurar');
    return this.clienteHttp.post<any>(this.API, formData);
  }

  eliminarBD(){
    const formData = new FormData();
    formData.append('accion', "eliminar");
    return this.clienteHttp.post<any>(this.API, formData);
  }

  respaldarBD(){
    const formData = new FormData();
    formData.append('accion', "respaldar");
    return this.clienteHttp.post<any>(this.API, formData);
  }
}