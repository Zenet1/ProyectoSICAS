import { Component, OnInit } from '@angular/core';
import { Form, FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { CookieService } from 'src/app/services/cookie/cookie.service';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  estaLogueado: Boolean;
  formularioIniciarSesion:FormGroup;
  facultades:any;

  constructor(private servicioLogin:LoginService, private servicioCookie:CookieService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.estaLogueado = this.servicioLogin.isLoggedIn();
    this.servicioCookie.deleteCookie("registroExterno");
    this.servicioCookie.deleteCookie("cuestionarioAlumno");
    this.servicioCookie.deleteCookie("cuestionarioExterno");

    if(this.estaLogueado){
      switch(this.servicioLogin.getRol()) { 
        case "Alumno": { 
          this.router.navigateByUrl('inicio-alumno');
          break; 
        } 
        case "Administrador": { 
          this.router.navigateByUrl('inicio-administrador');
          break; 
        }
        case "Capturador":{
          this.router.navigateByUrl('inicio-capturador');
          break;
        }
        case "Profesor":{
          this.router.navigateByUrl('inicio-personal');
          break;
        }
        case "Personal":{
          this.router.navigateByUrl('inicio-personal');
          break;
        }
        default:{
          this.router.navigateByUrl('login');
        }
      } 
    } else {
      this.formularioIniciarSesion = this.formBuilder.group({
        usuario: [""],
        contrasena: [""],
        facultad:[""]
      });
    this.obtenerFacultades();
    }
  }

  obtenerFacultades(){
    this.servicioLogin.obtenerFacultades().subscribe(
      respuesta=>{
        this.facultades = respuesta;
      }
    );
  }

  iniciarSesion(){
    this.servicioLogin.iniciarSesion(this.formularioIniciarSesion.value, "validarINET").subscribe(
      respuesta => {
        if(respuesta!=null){
          switch(respuesta["Rol"]) { 
            case "Alumno": { 
              location.href = '/inicio-alumno';
              break; 
            } 
            case "Administrador": { 
              location.href = '/inicio-administrador';
              break; 
            }
            case "Capturador":{
              location.href = '/inicio-capturador';
              break;
            }
            case "Profesor":{
              location.href = '/inicio-personal';
              break;
            }
            case "Personal":{
              location.href = '/inicio-personal';
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