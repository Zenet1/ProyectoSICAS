import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { CookieService } from 'src/app/services/cookie/cookie.service';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-login-usuarios',
  templateUrl: './login-usuarios.component.html',
  styleUrls: ['./login-usuarios.component.css']
})
export class LoginUsuariosComponent implements OnInit {
  estaLogueado:boolean;
  formLogin:FormGroup;
  facultades:any;

  constructor(private servicioLogin:LoginService, private servicioCookie:CookieService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.estaLogueado = this.servicioLogin.isLoggedIn();
    if(this.estaLogueado){
      this.router.navigateByUrl('login');
    } else {
      this.formLogin = this.formBuilder.group({
        usuario:[""],
        contrasena:[""],
        facultad:[""]
      });
      this.obtenerFacultades();
    }
  }

  trimCampo(campo:any, valor:any){
    var textoTrim = valor.trim();
    campo.setValue(textoTrim);
  }

  trimForm(){
    this.trimCampo(this.formLogin.controls["usuario"],this.formLogin.controls["usuario"].value);
  }

  obtenerFacultades(){
    this.servicioLogin.obtenerFacultades().subscribe(
      respuesta=>{
        this.facultades = respuesta;
      }
    );
  }

  iniciarSesion(){
    this.trimForm();
    this.servicioLogin.iniciarSesion(this.formLogin.value, "validarSICAS");
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}