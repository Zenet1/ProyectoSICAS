import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { RegistroExternoService } from 'src/app/services/registro-externo/registro-externo.service';

@Component({
  selector: 'app-registro-externo',
  templateUrl: './registro-externo.component.html',
  styleUrls: ['./registro-externo.component.css']
})
export class RegistroExternoComponent implements OnInit {

  formularioRegistro:FormGroup;

  constructor(private servicioExterno:RegistroExternoService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.formularioRegistro = this.formBuilder.group({
        nombre: [""],
        apellidos: [""],
        empresa: [""],
        correo: [""]
      }
    );
  }

  registrarse(){
    this.servicioExterno.guardarExterno(this.formularioRegistro.value).subscribe(
      respuesta=>{
        //this.router.navigateByUrl('cuestionario');
      }
    );
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }

}
