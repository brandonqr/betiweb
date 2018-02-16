import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BetiwebAuthInterceptor } from './betiwebauth.interceptor';

/*===============================*/
/*===========RUTAS===============*/
/*===============================*/
import { APP_ROUTES } from './app.routes';

/*===============================*/
/*===========MODULOS===============*/
/*===============================*/
import { PagesModule } from './pages/pages.module';
import { ServiceModule } from './services/service.module';

/*===============================*/
/*===========COMPONENTES===============*/
/*===============================*/
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { RegistroComponent } from './login/registro.component';

/*===============================*/
/*===========SERVICIOS===============*/
/*===============================*/
import { UsuarioService } from './services/service.index';




@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegistroComponent
  ],
  imports: [
    BrowserModule,
    APP_ROUTES,
    PagesModule,
    ServiceModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: BetiwebAuthInterceptor,
      multi: true
    },
    UsuarioService,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
