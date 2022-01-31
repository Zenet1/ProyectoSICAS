import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { LoginService } from 'src/app/services/login/login.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  estaLogueado:boolean;
  constructor(private servicioLogin:LoginService) { }

  ngOnInit(): void {
    this.estaLogueado = this.servicioLogin.isLoggedIn();
  }

  cerrarSesion(){
    this.servicioLogin.deleteToken();
    location.href = '#/login';
  }
}