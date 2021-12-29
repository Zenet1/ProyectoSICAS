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
    if (window.confirm("Confirme para enviar la alerta")) {
      console.log(this.formularioAlerta.value);
      this.servicioAdmin.alertar(this.formularioAlerta.value).subscribe(
        respuesta=>{
          alert("Se ha alertado a los alumnos correctamente");
        }
      )
    }
  }
}
