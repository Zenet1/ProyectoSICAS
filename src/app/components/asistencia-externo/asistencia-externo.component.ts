import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { CookieService } from 'src/app/services/cookie/cookie.service';
import { ExternoService } from 'src/app/services/externo/externo.service';

@Component({
  selector: 'app-asistencia-externo',
  templateUrl: './asistencia-externo.component.html',
  styleUrls: ['./asistencia-externo.component.css']
})
export class AsistenciaExternoComponent implements OnInit {
  listaOficinas:any;
  formularioAsistenciaExterno:FormGroup;

  constructor(private servicioExterno:ExternoService, private servicioCookie:CookieService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    /*if(!this.servicioCookie.checkCookie("cuestionarioExterno")){
      this.router.navigateByUrl('login');
    }*/
    this.formularioAsistenciaExterno = this.formBuilder.group({
        oficinas: this.formBuilder.array([]),
        fechaAsistencia:[""],
      }
    );
    this.obtenerOficinas();
  }

  obtenerOficinas(){
    this.servicioExterno.obtenerOficinas().subscribe(
      respuesta=>{
        this.listaOficinas = respuesta;
        this.agregarCamposOficinas();
      }
    );
  }

  get oficinas(){
    return this.formularioAsistenciaExterno.get('oficinas') as FormArray;
  }

  get fechaAsistencia(){
    return this.formularioAsistenciaExterno.get('fechaAsistencia');
  }

  agregarCamposOficinas(){
    for (let index = 0; index < this.listaOficinas.length; index++) {
      const preguntaFormGroup = this.formBuilder.group({
        respuesta:['']
      });
      this.oficinas.push(preguntaFormGroup);
    }
  }

  enviarAsistencia(){
    var oficinasSeleccionadas: Array<any> = [];
    for (let index = 0; index < this.oficinas.length; index++) {
      if(this.oficinas.controls[index].get("respuesta").value == true){
        oficinasSeleccionadas.push(this.listaOficinas[index].IDOficina);
      }
    }

    if(oficinasSeleccionadas.length > 0){
      if (window.confirm("Si está seguro que desea asistir, confirme para finalizar")){
        this.servicioExterno.enviarAsistencia(oficinasSeleccionadas, this.fechaAsistencia.value).subscribe(
          respuesta=>{
            this.enviarQR(oficinasSeleccionadas, this.fechaAsistencia.value);
          },
          error=>{
            alert('Ha ocurrido un error al registrar tu reserva, intenténtalo de nuevo');
          }
        );
      }
    } else {
      alert("Selecciona al menos una oficina");
    }
  }

  enviarQR(oficinasSeleccionadas, fechaAsistencia){
    this.servicioExterno.enviarCorreo(oficinasSeleccionadas, fechaAsistencia).subscribe(
      respuesta=>{
        alert('Se ha enviado un código QR a tu correo, que deberás presentar para entrar a la facultad');
        this.router.navigateByUrl('login');
      },
      error=>{
        alert('Ha ocurrido un error al enviar el QR, intenténtalo de nuevo');
      }
    );
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}