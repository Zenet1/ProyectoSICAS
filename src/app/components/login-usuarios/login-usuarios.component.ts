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
  formularioIniciarSesion:FormGroup;
  constructor(private servicioLogin:LoginService, private servicioCookie:CookieService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.estaLogueado = this.servicioLogin.isLoggedIn();
    if(this.estaLogueado){
      this.router.navigateByUrl('login')
    }

    this.formularioIniciarSesion = this.formBuilder.group({
      usuario:[""],
      contrasena:[""]
    });
  }

  iniciarSesion(){
    this.servicioLogin.iniciarSesion(this.formularioIniciarSesion.value).subscribe(
      respuesta => {
        if(respuesta!=null){
          switch(respuesta["Rol"]) { 
            case "Administrador": { 
              location.href = '/inicio-administrador';
              break; 
            }
            case "Capturador":{
              location.href = '/inicio-capturador';
              break;
            }
          } 
        } else {
          alert("Usuario o contraseña incorrectos");
        }
      },
      error => {
        alert("Usuario o contraseña incorrectos");
      }
    );
  }

}
