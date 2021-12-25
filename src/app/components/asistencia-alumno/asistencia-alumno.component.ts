import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AsistenciaAlumnoService } from 'src/app/services/asistencia-alumno/asistencia-alumno.service';

@Component({
  selector: 'app-asistencia-alumno',
  templateUrl: './asistencia-alumno.component.html',
  styleUrls: ['./asistencia-alumno.component.css']
})
export class AsistenciaAlumnoComponent implements OnInit {
  clases:any;
  constructor(private servicioAsistenciaAlum:AsistenciaAlumnoService, private router:Router) { }

  ngOnInit(): void {

    this.obtenerClases();
  }

  obtenerClases(){
    this.servicioAsistenciaAlum.obtenerClases(JSON.stringify({accion:"obtenerMaterias"})).subscribe(
      respuesta=>{
        this.clases = respuesta;
        console.log(this.clases);
      }
    )
  }

  enviarAsistencia(){
    //console.log(JSON.stringify({carga: this.clases, accion:"asignarReservaAlumno"}));
    this.servicioAsistenciaAlum.enviarAsistencia(JSON.stringify({carga:this.clases, accion:"asignarReservaAlumno"})).subscribe(
      respuesta=>{
        alert('Se ha registrado tu reserva sastisfactoriamente');
        //this.router.navigateByUrl('inicio-alumno');
      }
    );
  }

  cancelar(){
    //this.router.navigateByUrl('inicio-alumno');
    this.router.navigateByUrl('login');
  }
}
