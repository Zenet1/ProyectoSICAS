import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-alerta',
  templateUrl: './alerta.component.html',
  styleUrls: ['./alerta.component.css']
})
export class AlertaComponent implements OnInit {

  formularioAlerta:FormGroup;
  numAfectados:any;
  gruposAfectados:any;
  siAlertaEnviada:boolean = false;

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioAlerta = this.formBuilder.group({
        matricula: [""],
        fechaInicio:[""],
        fechaFin:[""]
      }
    );
  }

  alertar(){
    this.siAlertaEnviada = false;
    if (window.confirm("Confirme para enviar la alerta")) {
      console.log(this.formularioAlerta.value);
      this.servicioAdmin.obtenerAfectados(this.formularioAlerta.value).subscribe(
        respuesta=>{
          this.gruposAfectados = respuesta.grupos;
          this.numAfectados = respuesta.usuarios.length;
          let afectados = JSON.stringify({grupos: respuesta.grupos, usuarios: respuesta.usuarios, accion:"alertar"});
          this.servicioAdmin.alertar(afectados).subscribe(
            respuesta=>{
              this.siAlertaEnviada = true;
              alert("Se ha alertado a los alumnos correctamente");
            }
          );
        }
      );
    }
  }
}
