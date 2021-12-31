import { HttpClient, HttpHeaders, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class AdministradorService {
  API_GestionBD:string = "/ProyectoSICAS/DB_PHP/BDControl.Service.php";
  API_Alerta:string = "/ProyectoSICAS/DB_PHP/Alerta.Service.php";
  API_Email:string = '';
  API_ObtenerEdificios:string = "/ProyectoSICAS/DB_PHP/DevolverEdificios.Service.php";
  API_ObtenerOficinas:string = "/ProyectoSICAS/DB_PHP/DevolverOficinas.Service.php";
  API_RegistrarOficina:string = "/ProyectoSICAS/DB_PHP/RegistrarOficina.Service.php";
  constructor(private clienteHttp: HttpClient) { }

  obtenerAfectados(datos:FormGroup){
    return this.clienteHttp.post<any>(this.API_Alerta, datos);
  }

  alertar(afectados:any){
    return this.clienteHttp.post<any>(this.API_Email, afectados);
  }

  obtenerEdificios(){
    return this.clienteHttp.get(this.API_ObtenerEdificios);
  }

  obtenerOficinas(){
    return this.clienteHttp.get(this.API_ObtenerOficinas);
  }

  guardarOficina(datos:any){
    return this.clienteHttp.post<any>(this.API_RegistrarOficina, datos);
  }

  eliminarOficina(id:any){
    return this.clienteHttp.post<any>(this.API_GestionBD, id);
  }

  restaurarBD(datos:FormGroup){
    const formData = new FormData();
    formData.append('archivo', datos.get('archivo').value);
    formData.append('accion', 'restaurar');
    return this.clienteHttp.post<any>(this.API_GestionBD, formData);
  }

  eliminarBD(){
    const formData = new FormData();
    formData.append('accion', "eliminar");
    return this.clienteHttp.post<any>(this.API_GestionBD, formData);
  }

  respaldarBD(){
    const formData = new FormData();
    formData.append('accion', 'respaldar');
    const someHeaders = new HttpHeaders().set('Content-Type', 'application/json');
    //const req = new HttpRequest('POST', this.API_GestionBD, formData, {headers: someHeaders, responseType: 'blob' as 'json'});
    //return this.clienteHttp.request(req);
    return this.clienteHttp.post<any>("/ProyectoSICAS/DB_PHP/Respaldar.Service.php", formData, {headers:someHeaders, responseType: 'blob' as 'json'});
  }
}