import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-oficinas-externo',
  templateUrl: './oficinas-externo.component.html',
  styleUrls: ['./oficinas-externo.component.css']
})
export class OficinasExternoComponent implements OnInit {
  formularioOficina:FormGroup;
  oficinas:any;

  constructor(private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioOficina = this.formBuilder.group({
        oficina: [""],
        capacidad:[""]
      }
    );
  }

  guardarOficina(){
    
  }

  eliminarOficina(){
    if (window.confirm("¿Desea eliminar la oficina?")) {
      
    }
  }

}
