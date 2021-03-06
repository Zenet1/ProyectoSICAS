import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { AsistenciaExternoService } from 'src/app/services/asistencia-externo/asistencia-externo.service';
import { CookieService } from 'src/app/services/cookie/cookie.service';

@Component({
  selector: 'app-asistencia-externo',
  templateUrl: './asistencia-externo.component.html',
  styleUrls: ['./asistencia-externo.component.css']
})
export class AsistenciaExternoComponent implements OnInit {
  listaOficinas:any;
  formularioAsistenciaExterno:FormGroup;

  constructor(private servicioAsistenciaExterno:AsistenciaExternoService, private servicioCookie:CookieService, private datepipe:DatePipe, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    if(!this.servicioCookie.checkCookie("cuestionarioExterno")){
      this.router.navigateByUrl('login');
    }
    this.formularioAsistenciaExterno = this.formBuilder.group({
        oficinas: this.formBuilder.array([]),
        fechaAsistencia:[""],
        accion: [""],
      }
    );
    this.obtenerOficinas();
  }

  obtenerOficinas(){
    this.servicioAsistenciaExterno.obtenerOficinas().subscribe(
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
    let seleccionadas: Array<any> = [];
    for (let index = 0; index < this.oficinas.length; index++) {
      if(this.oficinas.controls[index].get("respuesta").value == true){
        seleccionadas.push(this.listaOficinas[index]);
      }
    }

    if(seleccionadas.length > 0){
      if (window.confirm("Si est?? seguro que desea asistir, confirme para finalizar")){
        let datos = JSON.stringify({seleccionadas: seleccionadas, fechaAsistencia: this.fechaAsistencia.value, accion: "aceptado"});
        this.servicioAsistenciaExterno.enviarAsistencia(datos).subscribe(
          respuesta=>{
            this.enviarQR();
          },
          error=>{
            alert('Ha ocurrido un error al registrar tu reserva, intent??ntalo de nuevo');
          }
        );
      }
    } else {
      alert("Selecciona al menos una oficina");
    }
  }

  enviarQR(){
    this.servicioAsistenciaExterno.enviarCorreo(JSON.stringify({accion:"EnviarQRExterno"})).subscribe(
      respuesta=>{
        alert('Se ha enviado un c??digo QR a tu correo, que deber??s presentar para entrar a la facultad');
        this.router.navigateByUrl('login');
      },
      error=>{
        alert('Ha ocurrido un error al enviar el QR, intent??ntalo de nuevo');
      }
    );
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}