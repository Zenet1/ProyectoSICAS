import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { AsistenciaExternoService } from 'src/app/services/asistencia-externo/asistencia-externo.service';

@Component({
  selector: 'app-asistencia-externo',
  templateUrl: './asistencia-externo.component.html',
  styleUrls: ['./asistencia-externo.component.css']
})
export class AsistenciaExternoComponent implements OnInit {
  listaOficinas:any;
  formularioAsistenciaExterno:FormGroup;

  constructor(private servicioAsistenciaExterno:AsistenciaExternoService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.formularioAsistenciaExterno = this.formBuilder.group({
        oficinas: this.formBuilder.array([]),
        fechaAsistencia:[""],
        accion: [""],
      }
    );
    this.obtenerOficinas();
    this.agregarCamposOficinas();
  }

  obtenerOficinas(){
    this.servicioAsistenciaExterno.obtenerOficinas().subscribe(
      respuesta=>{
        this.listaOficinas = respuesta;
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
    if (window.confirm("Si está seguro que desea asistir, confirme para finalizar")) {
      let oficinasSeleccionas: Array<any> = [];

      for (let index = 0; index < this.oficinas.length; index++) {
        if(this.oficinas.controls[index].get("respuesta").value == true){
          //console.log(this.listaOficinas[index].title);
          oficinasSeleccionas.push(this.listaOficinas[index].title);
        }
      }
      let datos = JSON.stringify({oficinasSeleccionadas: oficinasSeleccionas, fechaAsistencia: this.fechaAsistencia.value, accion: "aceptado"});
      //console.log(datos);
      //this.formularioAsistenciaExterno.controls["oficinas"].setValue(this.oficinas);
      //this.formularioAsistenciaExterno.controls["accion"].setValue("aceptado");
      this.servicioAsistenciaExterno.enviarAsistencia(datos).subscribe(
        respuesta=>{
          this.router.navigateByUrl('inicio-externo');
        }
      );
    }
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}