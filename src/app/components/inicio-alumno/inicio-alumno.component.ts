import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-inicio-alumno',
  templateUrl: './inicio-alumno.component.html',
  styleUrls: ['./inicio-alumno.component.css']
})
export class InicioAlumnoComponent implements OnInit {
  estaLogueado:boolean;
  usuario:string;

  constructor(private servicioLogin:LoginService, private router: Router) { }

  ngOnInit(): void {
    //console.log(JSON.parse(this.servicioLogin.getUsuario()).Cuenta);
    this.estaLogueado = this.servicioLogin.isLoggedIn();
    if(this.estaLogueado){
      this.usuario = this.servicioLogin.getUsuario();
    }
  }

  cuestionario(){
    this.router.navigateByUrl('cuestionario');
  }

}
