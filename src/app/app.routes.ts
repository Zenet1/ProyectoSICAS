import { RouterModule, Routes } from "@angular/router";

import { LoginComponent } from './components/login/login.component';
import { RegistroExternoComponent } from "./components/registro-externo/registro-externo.component";
import { ScannerComponent } from './components/scanner/scanner.component';
import { CuestionarioComponent } from "./components/cuestionario/cuestionario.component";

import { AuthguardGuard } from "./services/login/authguard.guard";

const app_routes: Routes = [
    { path: 'login', component: LoginComponent},
    { path: 'escaneo', component: ScannerComponent, canActivate: [AuthguardGuard]},
    { path: 'registro-externo', component: RegistroExternoComponent},
    { path: 'cuestionario', component: CuestionarioComponent},
    { path: '**', pathMatch: 'full', redirectTo: 'login' },
]

export const app_routing = RouterModule.forRoot(app_routes);