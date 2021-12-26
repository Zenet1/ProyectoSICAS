import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CookieService {

  constructor() { }

  setCookie(nombre, valor) {
    var cookie = nombre + "=" + encodeURIComponent(valor);
    document.cookie = cookie;
  }

  getCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }
    
    // Return null if not found
    return null;
  }

  checkCookie() {
    // Get cookie using our custom function
    var firstName = this.getCookie("firstName");
    
    if(firstName != "") {
        alert("Welcome again, " + firstName);
    } else {
        firstName = prompt("Please enter your first name:");
        if(firstName != "" && firstName != null) {
            // Set cookie using our custom function
            this.setCookie("firstName", firstName);
        }
    }
  }

  updateCookie(name, value){
    document.cookie = "firstName=Alexander; path=/; max-age=" + 365*24*60*60;
  }

  deleteCookie(name, value){
    document.cookie = "firstName=; path=/; domain=example.com; max-age=0";
  }
}