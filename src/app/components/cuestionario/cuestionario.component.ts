import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { CuestionarioService } from 'src/app/services/cuestionario/cuestionario.service';

@Component({
  selector: 'app-cuestionario',
  templateUrl: './cuestionario.component.html',
  styleUrls: ['./cuestionario.component.css']
})
export class CuestionarioComponent implements OnInit {
  cuestionario:FormGroup;
  preguntasBD:any;
  
  constructor(private servicioCuestionario:CuestionarioService, private formBuilder: FormBuilder) {
    this.cuestionario = this.formBuilder.group({
      preguntas: this.formBuilder.array([])    
    });
  }

  ngOnInit(): void {
    this.servicioCuestionario.obtenerPreguntas().subscribe(
      respuesta=>{
        this.preguntasBD=respuesta;
      }
    );
  }

  obtenerPreguntas(){
    
  }

  agregarPreguntas(){
    for (let index = 0; index < this.preguntasBD.length; index++) {
      const preguntaFormGroup = this.formBuilder.group({
        unaPregunta:['']
      });
      this.preguntas.push(preguntaFormGroup);
    }
  }

  get preguntas(){
    return this.cuestionario.get('preguntas') as FormArray;
  }

}
