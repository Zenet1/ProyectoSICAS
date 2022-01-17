import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AlumnoService {

  constructor(private clienteHttp: HttpClient) { }
  API_Alumnos: string = '/ProyectoSICAS/DB_PHP/refactor/API/Alumnos.Ruta.php';

  enviarAsistencia(datosClases:any):Observable<any>{
    let datos = JSON.stringify({accion: "insertarReservasAlumno", contenido: datosClases});
    return this.clienteHttp.post<any>(this.API_Alumnos, datos);
  }

  enviarCorreo():Observable<any>{
    let datos = JSON.stringify({accion:"enviarQRAlumno"});
    return this.clienteHttp.post<any>(this.API_Alumnos, datos);
  }

  obtenerClases(){
    let datos = JSON.stringify({accion: "obtenerClases"})
    return this.clienteHttp.post<any>(this.API_Alumnos, datos);
  }

  combrobarReservacion(){
    let datos = JSON.stringify({accion: "validacionReservasAlumno"});
    return this.clienteHttp.post(this.API_Alumnos, datos);
  }
}
