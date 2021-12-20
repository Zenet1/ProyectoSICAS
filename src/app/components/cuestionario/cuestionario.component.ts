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
    let cantidadSi:number = 0;
    for (let index = 0; index < this.preguntas.length; index++) {
      if(this.preguntas.controls[index].get("respuesta").value  == 'si'){
        cantidadSi++; 
      }
    }

    if(cantidadSi > 1){
      this.cuestionario.controls["accion"].setValue("rechazado");
      console.log(this.cuestionario.value);
      this.servicioCuestionario.rechazado(this.cuestionario.value);
    } else {
      if(this.estaLogueado){
        //this.router.navigateByUrl('asistenciaAlumno');
      } else {
        this.router.navigateByUrl('registro-externo');
      }
      
    }

  }

  cancelar(){
    this.router.navigateByUrl('login');
  }

}