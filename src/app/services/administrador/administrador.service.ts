import { HttpClient, HttpHeaders, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class AdministradorService {
  API:string = "/ProyectoSICAS/DB_PHP/BDControl.Service.php";
  API2:string = "/ProyectoSICAS/DB_PHP/Alerta.Service.php";
  constructor(private clienteHttp: HttpClient) { }

  alertar(datos:FormGroup){
    return this.clienteHttp.post<any>(this.API2, datos);
  }

  obtenerEdificios(){
    return this.clienteHttp.get(this.API);
  }

  obtenerOficinas(){
    return this.clienteHttp.get(this.API);
  }

  guardarOficina(datos:any){
    return this.clienteHttp.post<any>(this.API, datos);
  }

  eliminarOficina(id:any){
    return this.clienteHttp.post<any>(this.API, id);
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
    formData.append('accion', 'respaldar');
    const someHeaders = new HttpHeaders().set('Content-Type', 'application/json');
    //const req = new HttpRequest('POST', this.API, formData, {headers: someHeaders, responseType: 'blob' as 'json'});
    //return this.clienteHttp.request(req);
    return this.clienteHttp.post<any>("/ProyectoSICAS/DB_PHP/Respaldar.Service.php", formData, {headers:someHeaders, responseType: 'blob' as 'json'});
  }
}