import { Injectable } from '@angular/core';
import { BehaviorSubject, Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class FrontEndService {

  constructor() { }
  public menuSubject: Subject<boolean> = new BehaviorSubject<boolean>(false);
  public menuActive = this.menuSubject.asObservable();
  
  toggleMenu(val : boolean) {
    this.menuSubject.next(val);
  }
}