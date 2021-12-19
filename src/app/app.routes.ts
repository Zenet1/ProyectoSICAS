import { RouterModule, Routes } from "@angular/router";

import { LoginComponent } from './components/login/login.component';
import { ScannerComponent } from './components/scanner/scanner.component';

const app_routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'escaneo', component: ScannerComponent},
    { path: '**', pathMatch: 'full', redirectTo: 'login' },
]

export const app_routing = RouterModule.forRoot(app_routes);