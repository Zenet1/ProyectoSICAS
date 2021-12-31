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

  constructor(private servicioAdmin: AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioCapacidad = this.formBuilder.group({
      capacidad:[""]
    });
  }

  guardarCapacidad(){
    this.servicioAdmin.guardarCapacidadFacultdad(this.formularioCapacidad.get("capacidad").value).subscribe(
      respuesta=>{
        alert("Se ha guardado la capacidad correctamente");
      }
    );
  }

}
