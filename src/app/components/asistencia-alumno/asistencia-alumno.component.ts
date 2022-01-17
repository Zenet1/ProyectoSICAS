import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { AlumnoService } from 'src/app/services/alumno/alumno.service';
import { CookieService } from 'src/app/services/cookie/cookie.service';

@Component({
  selector: 'app-asistencia-alumno',
  templateUrl: './asistencia-alumno.component.html',
  styleUrls: ['./asistencia-alumno.component.css']
})
export class AsistenciaAlumnoComponent implements OnInit {
  clases:any;
  formularioAsistenciaAlumno:FormGroup;

  constructor(private servicioAlumno:AlumnoService, private servicioCookie:CookieService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    if(!this.servicioCookie.checkCookie("cuestionarioAlumno")){
      this.router.navigateByUrl('inicio-alumno');
    } else {
      this.servicioAlumno.combrobarReservacion().subscribe(
        respuesta=>{
          if(respuesta == "Aceptado"){
            this.obtenerClases();
          } else if (respuesta == "Rechazado"){
            alert("Ya tiene una reservación para mañana");
            this.router.navigateByUrl("inicio-alumno");
          }
        }
      );
    }
  }

  obtenerClases(){
    this.servicioAlumno.obtenerClases().subscribe(
      respuesta=>{
        if(respuesta.length > 0){
          this.clases = respuesta;
        } else {
          alert("No quedan cupos disponibles para mañana");
          this.router.navigateByUrl("inicio-alumno");
        }
      }
    )
  }

  enviarAsistencia(){
    if (window.confirm("Si está seguro que desea asistir, confirme para finalizar")){
      this.servicioAlumno.enviarAsistencia(this.clases).subscribe(
        respuesta=>{
          this.enviarQR();
        },
        error=>{
          alert('Ha ocurrido un error al registrar tu reserva, intenténtalo de nuevo');
        }
      );
    }
  }

  enviarQR(){
    this.servicioAlumno.enviarCorreo().subscribe(
      respuesta=>{
        alert('Se ha registrado tu reserva sastisfactoriamente y se ha enviado un código QR a tu correo, que deberás presentar para acceder a la facultad');
        this.router.navigateByUrl('inicio-alumno');
      },
      error=>{
        alert('Ha ocurrido un error al enviar el QR, intenténtalo de nuevo');
      }
    );
  }

  cancelar(){
    this.router.navigateByUrl('inicio-alumno');
  }
}