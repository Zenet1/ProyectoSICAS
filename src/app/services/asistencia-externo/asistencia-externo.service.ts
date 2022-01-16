import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AsistenciaExternoService {
  API_Externo:string = '/ProyectoSICAS/DB_PHP/refactor/API/Externos.Ruta.php';
  API_Administrador:string = '/ProyectoSICAS/DB_PHP/refactor/API/Administrador.Ruta.php';
  API_ReservaExterno:string = "/ProyectoSICAS/DB_PHP/ReservasExternos.Service.php";
  API_EnviarCorreo: string = '/ProyectoSICAS/DB_PHP/Email.Service.php';
  API_ObtenerOficinas:string = "/ProyectoSICAS/DB_PHP/DevolverOficinas.Service.php";
  constructor(private clienteHttp: HttpClient) { }

  enviarAsistencia(datos:any):Observable<any>{
    return this.clienteHttp.post<any>(this.API_Externo, JSON.stringify({accion: "insertarReservaExterno", datosReservaExterno: datos}));
  }

  enviarCorreo(datos:any):Observable<any>{
    return this.clienteHttp.post<any>(this.API_EnviarCorreo, datos);
  }

  obtenerOficinas(){
    let accion = JSON.stringify({accion:"obtenerOficinas"})
    return this.clienteHttp.post<any>(this.API_Administrador, JSON.stringify({accion: "recuperarOficinas"}));
  }
}
