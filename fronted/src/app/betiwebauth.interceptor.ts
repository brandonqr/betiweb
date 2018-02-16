import { Injectable } from '@angular/core';

import { HttpEvent, HttpInterceptor, HttpHandler, HttpRequest} from '@angular/common/http';

import { Observable } from 'rxjs/observable';
import { UsuarioService } from './services/usuario/usuario.service';

@Injectable()
export class BetiwebAuthInterceptor implements HttpInterceptor {
    constructor(public _usuarioService: UsuarioService){
        this._usuarioService.cargarStorage();
    }
    intercept( req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent< any>>{
        //const _usuarioService : UsuarioService;
 
        const authReq = req.clone({
            headers: req.headers.set('Authorization', this._usuarioService.token)
        });
        return next.handle(authReq);
     }
}