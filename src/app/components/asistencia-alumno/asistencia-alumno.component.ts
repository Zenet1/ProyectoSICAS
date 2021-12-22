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
    
  }

  enviarAsistencia(){
    this.servicioAsistenciaAlum.enviarAsistencia(this.clases).subscribe(
      respuesta=>{
        //this.router.navigateByUrl('inicio-alumno');
      }
    );
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}
