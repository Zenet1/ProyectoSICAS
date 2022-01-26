import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class ExternoService {
  API_Oficinas:string = '/ProyectoSICAS/DB_PHP/refactor/API/Oficinas.Ruta.php';
  API_RegistroExterno:string = '/ProyectoSICAS/DB_PHP/refactor/API/RegistroExternos.Ruta.php';
  API_Externo:string = '/ProyectoSICAS/DB_PHP/refactor/API/Externos.Ruta.php';

  constructor(private clienteHttp: HttpClient) { }

  enviarAsistencia(oficinas:any, fecha:any):Observable<any>{
    let datos = JSON.stringify({accion: "insertarReservaExterno", oficinas: oficinas, fecha: fecha});
    return this.clienteHttp.post<any>(this.API_Externo, datos);
  }

  enviarCorreo(oficinas:any, fecha:any):Observable<any>{
    let datos = JSON.stringify({accion:"enviarQRExterno", oficinas: oficinas, fecha: fecha});
    return this.clienteHttp.post<any>(this.API_Externo, datos);
  }

  obtenerOficinas(){
    let datos = JSON.stringify({accion:"recuperarOficinas"});
    return this.clienteHttp.post<any>(this.API_Oficinas, datos);
  }

  guardarExterno(datosExterno:any):Observable<any>{
    let datos = JSON.stringify({contenido: datosExterno});
    return this.clienteHttp.post(this.API_RegistroExterno, datos);
  }
}