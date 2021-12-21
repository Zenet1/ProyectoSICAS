import { Component, OnInit } from '@angular/core';
import { Form, FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  estaLogueado: Boolean = this.servicioLogin.isLoggedIn();
  formularioIniciarSesion:FormGroup;

  constructor(private servicioLogin:LoginService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.formularioIniciarSesion = this.formBuilder.group({
        usuario: [""],
        contrasena: [""],
      }
    );
  }

  iniciarSesion(){
    //console.log(this.formularioIniciarSesion.value);
    this.servicioLogin.iniciarSesion(this.formularioIniciarSesion.value).subscribe(
      respuesta => {
        //console.log(respuesta);
        location.href = '/cuestionario';
      },
      error => {
        alert("Usuario o contraseña incorrectos");
      }
    );
  }
}