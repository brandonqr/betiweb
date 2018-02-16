import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedService, SidebarService, UsuarioService, LoginGuardGuard, SubirArchivoService } from './service.index';

@NgModule({
  imports: [
    CommonModule
  ],
  providers: [
    SidebarService,
    SharedService,
    UsuarioService,
    LoginGuardGuard,
    SubirArchivoService
  ],
  declarations: []
})
export class ServiceModule { }
