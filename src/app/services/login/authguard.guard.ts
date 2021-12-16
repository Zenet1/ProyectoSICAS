import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, CanActivate, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { LoginService } from './login.service'; 
 
@Injectable({
  providedIn: 'root'
})
export class AuthguardGuard implements CanActivate  {
 
  constructor(private servicioLogin:LoginService, private router:Router) {}
 
  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean | UrlTree {
    const routeurl: string = state.url;
    return this.isLogin(routeurl);
  }
  isLogin(routeurl: string) {
    if (this.servicioLogin.isLoggedIn()) {
      return true;
    } else {
      return this.router.navigate(['inicio']);
    }
  }
}