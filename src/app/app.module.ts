import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { RouterModule} from '@angular/router';
import { app_routing } from './app.routes';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { LoginComponent } from './components/login/login.component';
import { ScannerComponent } from './components/scanner/scanner.component';
import { RegistroExternoComponent } from './components/registro-externo/registro-externo.component';
import { CuestionarioComponent } from './components/cuestionario/cuestionario.component';

import { ZXingScannerModule } from '@zxing/ngx-scanner';
import { AsistenciaAlumnoComponent } from './components/asistencia-alumno/asistencia-alumno.component';
import { InicioAlumnoComponent } from './components/inicio-alumno/inicio-alumno.component';
import { InicioCapturadorComponent } from './components/inicio-capturador/inicio-capturador.component';


@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    LoginComponent,
    ScannerComponent,
    RegistroExternoComponent,
    CuestionarioComponent,
    AsistenciaAlumnoComponent,
    InicioAlumnoComponent,
    InicioCapturadorComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    RouterModule,
    app_routing,
    ZXingScannerModule
    
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
