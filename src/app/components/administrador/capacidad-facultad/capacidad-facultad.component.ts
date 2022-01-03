import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-capacidad-facultad',
  templateUrl: './capacidad-facultad.component.html',
  styleUrls: ['./capacidad-facultad.component.css']
})
export class CapacidadFacultadComponent implements OnInit {
  formularioCapacidad:FormGroup;
  capacidadActual:any;

  constructor(private servicioAdmin: AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioCapacidad = this.formBuilder.group({
      porcentaje:[""],
      accion:[""]
    });
    this.obtenerCapacidadActual();
  }

  guardarCapacidad(){
    this.formularioCapacidad.controls["accion"].setValue("actualizar");
    this.servicioAdmin.guardarCapacidadFacultdad(this.formularioCapacidad.value).subscribe(
      respuesta=>{
        alert("Se ha guardado la capacidad correctamente");
        this.capacidadActual = this.servicioAdmin.obtenerCapacidadActual();
      }
    );
  }

  obtenerCapacidadActual(){
    this.servicioAdmin.obtenerCapacidadActual().subscribe(
      respuesta=>{
        this.capacidadActual = respuesta;
      }
    );
  }
}