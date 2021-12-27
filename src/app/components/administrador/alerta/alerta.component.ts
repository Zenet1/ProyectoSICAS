import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-alerta',
  templateUrl: './alerta.component.html',
  styleUrls: ['./alerta.component.css']
})
export class AlertaComponent implements OnInit {

  formularioAlerta:FormGroup;

  constructor(private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioAlerta = this.formBuilder.group({
        matricula: [""],
      }
    );
  }

  alertar(){
    if (window.confirm("Confirme para enviar la alerta")) {
      
    }
  }
}
