import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-aulas',
  templateUrl: './aulas.component.html',
  styleUrls: ['./aulas.component.css']
})
export class AulasComponent implements OnInit {
  formAula:FormGroup;
  aulas:any;

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formAula = this.formBuilder.group({
      aula:[""],
      capacidad:[""],
      accion:[""]
    });
  }

  obtenerAulas(){
    this.servicioAdmin.obtenerAulas().subscribe(
      respuesta=>{
        this.aulas = respuesta;
      }
    );
  }

  guardarAula(){
    this.servicioAdmin.guardarAula(this.formAula.value).subscribe(
      respuesta=>{
        alert("Se ha guardado el aula correctamente");
        this.obtenerAulas();
      }
    )
  }

  eliminarAula(id:any, index:any){
    if (window.confirm("¿Desea eliminar la oficina?")) {
      this.servicioAdmin.eliminarAula(id).subscribe(
        respuesta=>{
          this.aulas.splice(index,1);
        }
      );
    }
  }
}