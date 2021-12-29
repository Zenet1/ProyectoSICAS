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
    console.log(this.formularioOficina.value);
  }

  eliminarOficina(){
    if (window.confirm("¿Desea eliminar la oficina?")) {
      
    }
  }

}
