import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-inicio-administrador',
  templateUrl: './inicio-administrador.component.html',
  styleUrls: ['./inicio-administrador.component.css']
})
export class InicioAdministradorComponent implements OnInit {

  estaLogueado:boolean;
  usuario:string;
  constructor(private servicioLogin:LoginService, private datePipe:DatePipe) { }

  ngOnInit(): void {
    this.estaLogueado = this.servicioLogin.isLoggedIn();
    if(this.estaLogueado){
      this.usuario = this.servicioLogin.getUsuario();
    }

    let currentDateTime =this.datePipe.transform((new Date), 'dd/MM/yyyy h:mm:ss');
    console.log(currentDateTime);
    
  }

}
