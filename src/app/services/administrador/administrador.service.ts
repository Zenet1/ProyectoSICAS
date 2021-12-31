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
  API_Capacidad:string = '';
  API_BD_Sicei:string = '';
  constructor(private clienteHttp: HttpClient) { }

  obtenerAfectados(datos:FormGroup){
    return this.clienteHttp.post<any>(this.API_Alerta, datos);
  }

  alertar(afectados:any){
    return this.clienteHttp.post<any>(this.API_Email, afectados);
  }

  guardarCapacidadFacultdad(capacidad:any){
    let datos = JSON.stringify({capacidadFacultad: capacidad, accion: 'capacidad'});
    return this.clienteHttp.post<any>(this.API_Capacidad, datos);
  }

  subirBDSicei(datos:any){
    const formData = new FormData();
    formData.append('archivos', datos);
    return this.clienteHttp.post<any>(this.API_BD_Sicei, datos);
  }

  obtenerEdificios(){
    return this.clienteHttp.get(this.API_GestionBD);
  }

  obtenerOficinas(){
    return this.clienteHttp.get(this.API_GestionBD);
  }

  guardarOficina(datos:any){
    return this.clienteHttp.post<any>(this.API_GestionBD, datos);
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