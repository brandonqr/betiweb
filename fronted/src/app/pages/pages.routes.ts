import { RouterModule, Routes } from '@angular/router';

import { PagesComponent } from './pages.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { AjustesCuentaComponent } from './ajustes-cuenta/ajustes-cuenta.component';
import { LoginGuardGuard } from '../services/service.index';
import { ListarComponent } from './listar/listar.component';
import { AgregarComponent } from './agregar/agregar.component';

const pagesRoutes: Routes = [
    {
        path: '',
        component: PagesComponent,
        canActivate: [
            LoginGuardGuard
        ],
        children: [
            {path: 'dashboard', component: DashboardComponent},
            {path: 'ajustescuenta', component: AjustesCuentaComponent},
            {path: 'listar', component: ListarComponent},
            {path: 'agregar', component: AgregarComponent},
            {path: '', redirectTo: '/dashboard', pathMatch: 'full'}
        ]
    }
];

export const PAGES_ROUTES = RouterModule.forChild( pagesRoutes );
