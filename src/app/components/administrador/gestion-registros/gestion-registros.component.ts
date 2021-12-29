import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-gestion-registros',
  templateUrl: './gestion-registros.component.html',
  styleUrls: ['./gestion-registros.component.css']
})
export class GestionRegistrosComponent implements OnInit {

  formularioRestaurar:FormGroup;
  siArchivoRespaldado:boolean = false;

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioRestaurar = this.formBuilder.group({
      archivo:[""]
    });
  }

  respaldar(){
    //this.siArchivoRespaldado = true;
    this.servicioAdmin.respaldarBD().subscribe(
      respuesta=>{
        this.siArchivoRespaldado = true;
      }
    );
  }

  archivoSeleccionado(event){
    const logo = event.target.files[0];
    this.formularioRestaurar.get('archivo').setValue(logo);
  }

  restaurar(){
    if (window.confirm("¿Está seguro que desea restaurar este archivo?")) {
      this.servicioAdmin.restaurarBD(this.formularioRestaurar).subscribe(
        respuesta=>{

        }
      );
    }
  }

  eliminar(){
    if (window.confirm("¿Está seguro que desea eliminar los datos de asistencia actuales?")) {
      this.servicioAdmin.eliminarBD().subscribe(
        respuesta=>{
          
        }
      );
    }
  }
}