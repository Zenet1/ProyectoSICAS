import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FrontEndService } from 'src/app/services/front-end/front-end.service';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  estaLogueado:boolean;
  constructor(private servicioLogin:LoginService, private servicioFront:FrontEndService) { }
  public localBool = false;

  ngOnInit(): void {
    //this.estaLogueado = this.servicioLogin.isLoggedIn();
    this.servicioFront.toggleMenu(this.servicioLogin.isLoggedIn());
    this.servicioFront.menuActive.subscribe(value => this.estaLogueado = value);
  }

  ComponentToggleMenu() {
    this.servicioFront.toggleMenu(!this.localBool);
  }

  cerrarSesion(){
    this.servicioLogin.deleteToken();
    location.href = '#/login';
  }
}