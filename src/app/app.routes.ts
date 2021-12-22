import { RouterModule, Routes } from "@angular/router";

import { LoginComponent } from './components/login/login.component';
import { RegistroExternoComponent } from "./components/registro-externo/registro-externo.component";
import { ScannerComponent } from './components/scanner/scanner.component';
import { CuestionarioComponent } from "./components/cuestionario/cuestionario.component";
import { AsistenciaAlumnoComponent } from "./components/asistencia-alumno/asistencia-alumno.component";

import { AuthguardGuard } from "./services/login/authguard.guard";
import { AuthguardGuardAdmin } from "./services/login/authguardAdmin.guard";
import { AuthguardGuardCapturador } from "./services/login/authguardCapturador.guard";
import { InicioAlumnoComponent } from "./components/inicio-alumno/inicio-alumno.component";
import { InicioCapturadorComponent } from "./components/inicio-capturador/inicio-capturador.component";

const app_routes: Routes = [
    { path: 'login', component: LoginComponent},
    { path: 'escaneo', component: ScannerComponent, canActivate: [AuthguardGuardCapturador]},
    { path: 'registro-externo', component: RegistroExternoComponent},
    { path: 'cuestionario', component: CuestionarioComponent},
    { path: 'asistencia-alumno', component: AsistenciaAlumnoComponent, canActivate: [AuthguardGuard]},
    { path: 'inicio-alumno', component: InicioAlumnoComponent, canActivate: [AuthguardGuard]},
    { path: 'inicio-capturador', component: InicioCapturadorComponent},
    { path: '**', pathMatch: 'full', redirectTo: 'login' },
]

export const app_routing = RouterModule.forRoot(app_routes);