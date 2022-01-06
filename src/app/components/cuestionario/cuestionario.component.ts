import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { CookieService } from 'src/app/services/cookie/cookie.service';
import { CuestionarioService } from 'src/app/services/cuestionario/cuestionario.service';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-cuestionario',
  templateUrl: './cuestionario.component.html',
  styleUrls: ['./cuestionario.component.css']
})
export class CuestionarioComponent implements OnInit {
  cuestionario:FormGroup;
  preguntasBD:any;
  estaLogueado:boolean;
  
  constructor(private servicioCuestionario:CuestionarioService, private servicioLogin:LoginService, private servicioCookie:CookieService, private formBuilder: FormBuilder, private router:Router) {
    this.cuestionario = this.formBuilder.group({
      preguntas: this.formBuilder.array([]),
      accion: ['']    
    });
  }

  ngOnInit(): void {
    this.estaLogueado = this.servicioLogin.isLoggedIn();
    if(this.estaLogueado){
      switch(this.servicioLogin.getRol()) {
        case "Administrador": { 
          this.router.navigateByUrl('login');
          break;
        }
        case "Capturador":{
          this.router.navigateByUrl('login');
          break;
        }
        case "Alumno":{
          break;
        }
      }
    } else {
      if(!this.servicioCookie.checkCookie("registroExterno")){
        this.router.navigateByUrl('login');
      }
    }

    this.servicioCuestionario.obtenerPreguntas().subscribe(
      respuesta=>{
        this.preguntasBD=respuesta;
        this.agregarCamposPreguntas();
      }
    );
  }

  agregarCamposPreguntas(){
    for (let index = 0; index < this.preguntasBD.length; index++) {
      const preguntaFormGroup = this.formBuilder.group({
        respuesta:['']
      });
      this.preguntas.push(preguntaFormGroup);
    }
  }

  get preguntas(){
    return this.cuestionario.get('preguntas') as FormArray;
  }

  enviar(){
    if (window.confirm("Si está seguro de sus respuestas, confirme para continuar")) {
      //recoleccion de respuestas
      let cantidadSi:number = 0;
      for (let index = 0; index < this.preguntas.length; index++) {
        if(this.preguntas.controls[index].get("respuesta").value  == 'si'){
          cantidadSi++; 
        }
      }
  
      if(cantidadSi > 0){
        this.cuestionario.controls["accion"].setValue("rechazado");
        this.servicioCuestionario.rechazado(this.cuestionario.value).subscribe();
      } else {
        if(this.estaLogueado){
          switch(this.servicioLogin.getRol()){
            case "Alumno": {
              this.servicioCookie.setCookie("cuestionarioAlumno", "si");
              this.router.navigateByUrl('asistencia-alumno');
              break;
            }
          }
        } else {
          this.servicioCookie.setCookie("cuestionarioExterno", "si");
          this.router.navigateByUrl('asistencia-externo');
        }
      }
    }
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}