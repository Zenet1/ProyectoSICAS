import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-gestionar-sicei',
  templateUrl: './gestionar-sicei.component.html',
  styleUrls: ['./gestionar-sicei.component.css']
})
export class GestionarSiceiComponent implements OnInit {
  formularioBDSicei:FormGroup;
  constructor(private servicioAdmin:AdministradorService, private formBuilder: FormBuilder) { }

  ngOnInit(): void {
    this.formularioBDSicei = this.formBuilder.group({
      archivos:[""]
    });
  }

  get archivos(){
    return this.formularioBDSicei.get('archivos') as FormArray;
  }

  archivosSeleccionados(event){
    const archivo = event.target.files;
    this.formularioBDSicei.get('archivos').setValue(archivo);
  }

  subirBDSicei(){
    this.servicioAdmin.subirBDSicei(this.formularioBDSicei.value).subscribe(
      respuesta=>{
        
      },
      error=>{
        alert("Ocurrió un error al intentar subir los registros de SICEI");
      }
    );
  }
}