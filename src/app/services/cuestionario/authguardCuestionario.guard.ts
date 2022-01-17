import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, CanActivate, Router } from '@angular/router';
import { Observable } from 'rxjs';

 
@Injectable({
  providedIn: 'root'
})
export class AuthguardGuardCuestionario implements CanActivate  {
 
  constructor(private router:Router) {}
 
  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean | UrlTree {
    return false;
  }

}