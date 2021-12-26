import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
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
  
  constructor(private servicioCuestionario:CuestionarioService, private servicioLogin:LoginService, private formBuilder: FormBuilder, private router:Router) {
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
        }
        case "Capturador":{
          this.router.navigateByUrl('login');
        }
        default:{

        }
      }
    }

    this.servicioCuestionario.obtenerPreguntas().subscribe(
      respuesta=>{
        this.preguntasBD=respuesta;
        this.agregarPreguntas();
      }
    );
  }

  agregarPreguntas(){
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
    if (window.confirm("Si está seguro de su respuestas, confirme para continuar")) {
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
              this.router.navigateByUrl('asistencia-alumno');
            }
          }
        } else {
          this.router.navigateByUrl('asistencia-externo');
        }
      }
    }
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}