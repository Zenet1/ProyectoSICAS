import { HttpClient, HttpHeaders, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Injectable({
  providedIn: 'root'
})
export class AdministradorService {
  API_GestionBD:string = "/ProyectoSICAS/DB_PHP/BDControl.Service.php";
  API_Alerta:string = "/ProyectoSICAS/DB_PHP/Alerta.Service.php";
  API_Email:string = '/ProyectoSICAS/DB_PHP/Email.Service.php';
  API_ObtenerEdificios:string = "/ProyectoSICAS/DB_PHP/DevolverEdificios.Service.php";
  API_ObtenerOficinas:string = "/ProyectoSICAS/DB_PHP/DevolverOficinas.Service.php";
  API_RegistrarOficina:string = "/ProyectoSICAS/DB_PHP/RegistrarOficina.Service.php";
  API_EliminarOficina:string = "/ProyectoSICAS/DB_PHP/EliminarOficina.Service.php";
  API_Capacidad:string = '/ProyectoSICAS/DB_PHP/Capacidad.Service.php';
  API_BD_Sicei:string = '/ProyectoSICAS/DB_PHP/SICEI.Service.php';
  API_Roles:string = "/ProyectoSICAS/DB_PHP/Roles.Service.php";
  API_RegistrarUsuario:string = "/ProyectoSICAS/DB_PHP/RegistroUsuario.Service.php";
<<<<<<< HEAD
  API_Aulas:string = "/ProyectoSICAS/DB_PHP/Salones.Service.php";
=======
  API_Aulas:string = "";
  API_Programas:string = "";
  API_Estadisticas:string = "";
>>>>>>> 2e55becc28a4697e3f2cb060b8b851b336777482

  constructor(private clienteHttp: HttpClient) { }
  //alerta
  obtenerAfectados(datos:FormGroup){
    return this.clienteHttp.post<any>(this.API_Alerta, datos);
  }

  alertar(afectados:any){
    return this.clienteHttp.post<any>(this.API_Email, afectados);
  }

  //capacidad
  obtenerCapacidadActual(){
    let accion = JSON.stringify({accion: "recuperar"});
    return this.clienteHttp.post<any>(this.API_Capacidad,accion);
  }

  guardarCapacidadFacultdad(datos:any){
    return this.clienteHttp.post<any>(this.API_Capacidad, datos);
  }

  //datos sicei
  subirBDSicei(datos:any){
    const formData = new FormData();
    let numArchivos:number = 0;
    for (let index = 0; index < datos.archivos.length; index++) {
      console.log(datos.archivos[index]);
      numArchivos++;
      formData.append('archivo' + [index], datos.archivos[index]);
    }
    formData.append('numArchivos', numArchivos + "");
    return this.clienteHttp.post<any>(this.API_BD_Sicei, formData);
  }

  //oficinas
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

  //aulas
  obtenerAulas(){
    return this.clienteHttp.post<any>(this.API_Aulas, JSON.stringify({accion:"recuperar"}));
  }

  guardarAula(datosAula:any){
    let datos = JSON.stringify({accion:"actualizar",salon: datosAula})
    return this.clienteHttp.post<any>(this.API_Aulas, datos);
  }

  eliminarAula(id:any){
    return this.clienteHttp.post<any>(this.API_Aulas, id);
  }

  //gestion base de datos
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
    return this.clienteHttp.post<any>("/ProyectoSICAS/DB_PHP/Respaldar.Service.php", formData, {headers:someHeaders, responseType: 'blob' as 'json'});
  }

  //estadisticas
  obtenerProgramas(){
    return this.clienteHttp.get(this.API_Programas);
  }

  obtenerEstadisticas(datos:any){
    return this.clienteHttp.post<any>(this.API_Estadisticas, datos);
  }

  //registrar usuarios
  obtenerRoles(){
    return this.clienteHttp.get(this.API_Roles);
  }

  registrarUsuario(datos:any){
    return this.clienteHttp.post<any>(this.API_RegistrarUsuario, datos);
  }
}