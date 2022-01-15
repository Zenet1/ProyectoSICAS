import { HttpClient, HttpHeaders, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class AdministradorService {
  API_GestionBD:string = "/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php";
  API_Alerta:string = "/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php";
  API_Email:string = '/ProyectoSICAS/DB_PHP/Email.Service.php';
  API_ObtenerEdificios:string = "/ProyectoSICAS/DB_PHP/DevolverEdificios.Service.php";
  API_ObtenerOficinas:string = "/ProyectoSICAS/DB_PHP/DevolverOficinas.Service.php";
  API_RegistrarOficina:string = "/ProyectoSICAS/DB_PHP/RegistrarOficina.Service.php";
  API_EliminarOficina:string = "/ProyectoSICAS/DB_PHP/EliminarOficina.Service.php";
  API_Capacidad:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';
  API_BD_Sicei:string = '/ProyectoSICAS/DB_PHP/SICEI.Service.php';
  API_Roles:string = "/ProyectoSICAS/DB_PHP/Roles.Service.php";
  API_RegistrarUsuario:string = "/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php";
  API_Aulas:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';
  API_Programas:string = "/ProyectoSICAS/DB_PHP/Programas.Service.php";
  API_Estadisticas:string = "/ProyectoSICAS/DB_PHP/Estadistica.Service.php";
  API_Preguntas:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';
  API_GuardarPregunta:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';
  API_EliminarPregunta:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';

  constructor(private clienteHttp: HttpClient) { }

  obtenerAfectados(afectados:FormGroup){
    let datos = JSON.stringify({accion:"no ce aun", contenido: afectados});
    return this.clienteHttp.post<any>(this.API_Alerta, datos);
  }

  alertar(grupos:any, usuarios:any){
    let datos = JSON.stringify({accion:"alertaCOVID", grupos: grupos, usuarios: usuarios});
    return this.clienteHttp.post<any>(this.API_Email, datos);
  }

  obtenerCapacidadActual(){
    let datos = JSON.stringify({accion: "recuperarPorcentaje"});
    return this.clienteHttp.post<any>(this.API_Capacidad, datos);
  }

  guardarCapacidadFacultdad(datosCapacidad:FormGroup){
    let datos = JSON.stringify({accion:"actualizarPorcentaje", contenido: datosCapacidad});
    return this.clienteHttp.post<any>(this.API_Capacidad, datos);
  }

  subirBDSicei(datos:any){
    const formData = new FormData();
    let numArchivos:number = 0;
    for (let index = 0; index < datos.archivos.length; index++) {
      numArchivos++;
      formData.append('archivo' + [index], datos.archivos[index]);
    }
    formData.append('numArchivos', numArchivos + "");
    formData.append('accion', 'restaurarSICEI');
    return this.clienteHttp.post<any>(this.API_BD_Sicei, formData);
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
    return this.clienteHttp.post<any>(this.API_EliminarOficina, id);
  }

  obtenerAulas(){
    return this.clienteHttp.post<any>(this.API_Aulas, JSON.stringify({accion:"recuperarSalones"}));
  }

  guardarAula(datosAula:any){
    let datos = JSON.stringify({accion:"actualizarSalon", contenido: datosAula});
    return this.clienteHttp.post<any>(this.API_Aulas, datos);
  }

  eliminarAula(id:any){
    return this.clienteHttp.post<any>(this.API_Aulas, id);
  }

  restaurarBD(datos:FormGroup){
    const formData = new FormData();
    formData.append('archivo', datos.get('archivo').value);
    formData.append('accion', 'restaurarSICAS');
    return this.clienteHttp.post<any>(this.API_GestionBD, formData);
  }

  eliminarBD(){
    let datos = JSON.stringify({accion:"eliminarSICAS"});
    return this.clienteHttp.post<any>(this.API_GestionBD, datos);
  }

  respaldarBD(){
    const formData = new FormData();
    formData.append('accion', 'respaldarSICAS');
    const someHeaders = new HttpHeaders().set('Content-Type', 'application/json');
    return this.clienteHttp.post<any>("/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php", formData, {headers:someHeaders, responseType: 'blob' as 'json'});
  }

  obtenerProgramas(){
    return this.clienteHttp.get(this.API_Programas);
  }

  obtenerEstadisticas(filtros:any){
    let datos = JSON.stringify({accion:"recuperarEstadisticaAlumno", filtros: filtros});
    return this.clienteHttp.post<any>(this.API_Estadisticas, datos);
  }

  obtenerRoles(){
    return this.clienteHttp.get(this.API_Roles);
  }

  registrarUsuario(datos:any){
    return this.clienteHttp.post<any>(this.API_RegistrarUsuario, datos);
  }

  obtenerPreguntas(){
    let datos = JSON.stringify({accion:"recuperarPreguntas"});
    return this.clienteHttp.post<any>(this.API_Preguntas, datos);
  }

  guardarPreguntas(pregunta:any){
    let datos = JSON.stringify({accion:"agregarPregunta", contenido:pregunta});
    return this.clienteHttp.post<any>(this.API_GuardarPregunta, datos);
  }

  eliminarPregunta(id:any){
    let datos = JSON.stringify({accion:"eliminarPregunta", contenido: id});
    return this.clienteHttp.post<any>(this.API_EliminarPregunta, datos);
  }
}