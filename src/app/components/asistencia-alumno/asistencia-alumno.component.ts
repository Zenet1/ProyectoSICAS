import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { AsistenciaAlumnoService } from 'src/app/services/asistencia-alumno/asistencia-alumno.service';

@Component({
  selector: 'app-asistencia-alumno',
  templateUrl: './asistencia-alumno.component.html',
  styleUrls: ['./asistencia-alumno.component.css']
})
export class AsistenciaAlumnoComponent implements OnInit {
  clases:any;
  formularioAsistenciaAlumno:FormGroup;

  constructor(private servicioAsistenciaAlum:AsistenciaAlumnoService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.formularioAsistenciaAlumno = this.formBuilder.group({
      clases: [""],
      accion: [""],
    }
  );
  }

  enviarAsistencia(){

    if (window.confirm("Si está seguro que desea asistir, confirme para finalizar")) {
      this.formularioAsistenciaAlumno.controls["clases"].setValue(this.clases);
      this.formularioAsistenciaAlumno.controls["accion"].setValue("aceptado");
      this.servicioAsistenciaAlum.enviarAsistencia(this.formularioAsistenciaAlumno.value).subscribe(
        respuesta=>{
          this.router.navigateByUrl('inicio-alumno');
        }
      );
    }
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}
