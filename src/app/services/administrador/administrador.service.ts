import { HttpClient, HttpHeaders, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class AdministradorService {

  API_Administrador:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';

  constructor(private clienteHttp: HttpClient) { }

  obtenerAfectados(afectados:FormGroup){
    let datos = JSON.stringify({accion:"obtenerAfectados", contenido: afectados});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  alertar(grupos:any, usuarios:any){
    let datos = JSON.stringify({accion:"alertaCOVID", grupos: grupos, usuarios: usuarios});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  obtenerCapacidadActual(){
    let datos = JSON.stringify({accion: "recuperarPorcentaje"});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  guardarCapacidadFacultdad(datosCapacidad:FormGroup){
    let datos = JSON.stringify({accion:"actualizarPorcentaje", contenido: datosCapacidad});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  subirBDSicei(datos:any){
    const formData = new FormData();
    let numArchivos:number = 0;
    for (let index = 0; index < datos.archivos.length; index++) {
      numArchivos++;
      formData.append('archivo' + [index], datos.archivos[index]);
    }
    formData.append('numArchivos', numArchivos + "");
    return this.clienteHttp.post<any>(this.API_Administrador, formData);
  }

  obtenerEdificios(){
    let datos = JSON.stringify({accion: "recuperarEdificios"});
    return this.clienteHttp.post(this.API_Administrador, datos);
  }

  obtenerOficinas(){
    let datos = JSON.stringify({accion: "recuperarOficinas"});
    return this.clienteHttp.post(this.API_Administrador, datos);
  }

  guardarOficina(datosOficina:any){
    let datos = JSON.stringify({accion: "agregarOficina", contenido: datosOficina});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  eliminarOficina(idOficina:any){
    let datos = JSON.stringify({accion: "eliminarOficina", contenido: idOficina});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  obtenerAulas(){
    let datos = JSON.stringify({accion:"recuperarSalones"});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  guardarAula(datosAula:any){
    let datos = JSON.stringify({accion:"actualizarSalon", contenido: datosAula});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  eliminarAula(id:any){
    return this.clienteHttp.post<any>(this.API_Administrador, id);
  }

  restaurarBD(datos:FormGroup){
    const formData = new FormData();
    formData.append('archivo', datos.get('archivo').value);
    formData.append('accion', 'restaurarSICAS');
    return this.clienteHttp.post<any>(this.API_Administrador, formData);
  }

  eliminarBD(){
    let datos = JSON.stringify({accion:"eliminarSICAS"});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  respaldarBD(){
    const formData = new FormData();
    formData.append('accion', 'respaldarSICAS');
    const someHeaders = new HttpHeaders().set('Content-Type', 'application/json');
    return this.clienteHttp.post<any>(this.API_Administrador, formData, {headers:someHeaders, responseType: 'blob' as 'json'});
  }

  obtenerProgramas(){
    return this.clienteHttp.get(this.API_Administrador);
  }

  obtenerEstadisticas(filtros:any){
    let datos = JSON.stringify({accion:"recuperarEstadisticaAlumno", filtros: filtros});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  obtenerRoles(){
    let datos = JSON.stringify({accion:"recuperarRoles"});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  registrarUsuario(datosUsuario:any){
    let datos = JSON.stringify({accion:"agregarUsuario", contenido: datosUsuario});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  obtenerPreguntas(){
    let datos = JSON.stringify({accion:"recuperarPreguntas"});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  guardarPreguntas(pregunta:any){
    let datos = JSON.stringify({accion:"agregarPregunta", contenido:pregunta});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }

  eliminarPregunta(id:any){
    let datos = JSON.stringify({accion:"eliminarPregunta", contenido: id});
    return this.clienteHttp.post<any>(this.API_Administrador, datos);
  }
}