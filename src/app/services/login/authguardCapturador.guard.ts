import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, CanActivate, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { LoginService } from './login.service'; 
 
@Injectable({
  providedIn: 'root'
})
export class AuthguardGuardCapturador implements CanActivate  {
 
  constructor(private servicioLogin:LoginService, private router:Router) {}
 
  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean | UrlTree {
    const routeurl: string = state.url;
    return this.isLogin(routeurl);
  }
  isLogin(routeurl: string) {
    if (this.servicioLogin.isLoggedIn() && (this.servicioLogin.getRol() == "Capturador")) {
      return true;
    } else {
      if(this.servicioLogin.isLoggedIn()){
        switch(this.servicioLogin.getRol()) { 
          case "Alumno": { 
            return this.router.navigateByUrl('inicio-alumno');
          }
          case "Administrador":{
            //return vista admin
          }
        } 
      } else {
        return this.router.navigateByUrl('login');
      }
    }
  }
}