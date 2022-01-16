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
  API:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';
  API_BD_Sicei:string = '/ProyectoSICAS/DB_PHP/SICEI.Service.php';
  API_Roles:string = "/ProyectoSICAS/DB_PHP/Roles.Service.php";
  API_RegistrarUsuario:string = "/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php";
  API_Aulas:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';
  API_Programas:string = "/ProyectoSICAS/DB_PHP/Programas.Service.php";
  API_Estadisticas:string = "/ProyectoSICAS/DB_PHP/Estadistica.Service.php";
  API_Preguntas:string = '/ProyectoSICAS/DB_PHP/Preguntas.Servicio.php';
  API_GuardarPregunta:string = '/ProyectoSICAS/DB_PHP/GuardarPreguntas.Service.php';
  API_EliminarPregunta:string = '/ProyectoSICAS/DB_PHP/EliminarPreguntas.Service.php';

  constructor(private clienteHttp: HttpClient) { }

  obtenerAfectados(datos:FormGroup){
    return this.clienteHttp.post<any>(this.API, datos);
  }

  alertar(afectados:any){
    return this.clienteHttp.post<any>(this.API, afectados);
  }

  obtenerCapacidadActual(){
    let accion = JSON.stringify({accion: "recuperar"});
    return this.clienteHttp.post<any>(this.API, accion);
  }

  guardarCapacidadFacultdad(datos:any){
    return this.clienteHttp.post<any>(this.API, datos);
  }
  subirBDSicei(datos:any){
    const formData = new FormData();
    let numArchivos:number = 0;
    for (let index = 0; index < datos.archivos.length; index++) {
      numArchivos++;
      formData.append('archivo' + [index], datos.archivos[index]);
    }
    formData.append('numArchivos', numArchivos + "");
    return this.clienteHttp.post<any>(this.API, formData);
  }

  obtenerEdificios(){
    return this.clienteHttp.post(this.API, JSON.stringify({accion: "recuperarEdificios"}));
  }

  obtenerOficinas(){
    return this.clienteHttp.post(this.API, JSON.stringify({accion: "recuperarOficinas"}));
  }

  guardarOficina(datos:any){
    return this.clienteHttp.post<any>(this.API, JSON.stringify({accion: "agregarOficina", datosOficina: datos}));
  }

  eliminarOficina(idOficina:any){
    return this.clienteHttp.post<any>(this.API, JSON.stringify({accion: "eliminarOficina", IDOficina: idOficina}));
  }

  obtenerAulas(){
    return this.clienteHttp.post<any>(this.API, JSON.stringify({accion:"recuperar"}));
  }

  guardarAula(datosAula:any){
    let datos = JSON.stringify({accion:"actualizar",salon: datosAula})
    return this.clienteHttp.post<any>(this.API, datos);
  }

  eliminarAula(id:any){
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
    return this.clienteHttp.post<any>(this.API, formData, {headers:someHeaders, responseType: 'blob' as 'json'});
  }

  obtenerProgramas(){
    return this.clienteHttp.get(this.API);
  }

  obtenerEstadisticas(datos:any){
    return this.clienteHttp.post<any>(this.API, datos);
  }

  obtenerRoles(){
    return this.clienteHttp.get(this.API);
  }

  registrarUsuario(datos:any){
    return this.clienteHttp.post<any>(this.API, datos);
  }

  obtenerPreguntas(){
    return this.clienteHttp.post(this.API, JSON.stringify({accion: "recuperarPreguntas"}));
  }

  guardarPreguntas(datosPregunta){
    return this.clienteHttp.post<any>(this.API, JSON.stringify({accion: "agregarPregunta", pregunta: datosPregunta}));
  }

  eliminarPregunta(idPregunta:any){
    return this.clienteHttp.post<any>(this.API, JSON.stringify({accion: "eliminarPregunta", IDPregunta: idPregunta}));
  }

}