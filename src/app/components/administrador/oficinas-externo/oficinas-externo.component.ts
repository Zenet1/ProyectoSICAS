import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-oficinas-externo',
  templateUrl: './oficinas-externo.component.html',
  styleUrls: ['./oficinas-externo.component.css']
})
export class OficinasExternoComponent implements OnInit {
  formularioOficina:FormGroup;
  oficinas:any;
  edificios:any;

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioOficina = this.formBuilder.group({
        oficina: [""],
        departamento:[""],
        edificio:[""]
      }
    );

    this.obtenerEdificios();
    this.obtenerOficinas();
  }

  obtenerOficinas(){
    this.servicioAdmin.obtenerOficinas().subscribe(
      respuesta=>{
        this.oficinas = respuesta;
      }
    );
  }

  obtenerEdificios(){
    this.servicioAdmin.obtenerEdificios().subscribe(
      respuesta=>{
        this.edificios = respuesta;
      }
    );
  }

  guardarOficina(){
    this.servicioAdmin.guardarOficina(this.formularioOficina.value).subscribe(
      respuesta=>{
        this.oficinas = this.obtenerOficinas();
      }
    );
  }

  eliminarOficina(id:any, indexOficina:any){
    if (window.confirm("¿Desea eliminar la oficina?")) {
      this.servicioAdmin.eliminarOficina(id).subscribe(
        respuesta=>{
          this.oficinas.splice(indexOficina,1);
        },
        error=>{
          alert("Ocurrió un error al eliminar la oficina");
        }
      );
    }
  }

}
