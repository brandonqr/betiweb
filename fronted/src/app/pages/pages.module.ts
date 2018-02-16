import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { PagesComponent } from './pages.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { PAGES_ROUTES } from './pages.routes';
import { AjustesCuentaComponent } from './ajustes-cuenta/ajustes-cuenta.component';
import { ListarComponent } from './listar/listar.component';
import { AgregarComponent } from './agregar/agregar.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { EditarComponent } from './editar/editar.component';

@NgModule({
declarations: [
    PagesComponent,
    DashboardComponent,
    AjustesCuentaComponent,
    ListarComponent,
    AgregarComponent,
    EditarComponent
],
    exports: [
        DashboardComponent
    ],
    imports: [
        SharedModule,
        PAGES_ROUTES,
        FormsModule,
        ReactiveFormsModule,
        CommonModule
    ]
})
export class PagesModule {

}
