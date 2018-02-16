import { Injectable } from '@angular/core';
import { Usuario } from '../../../assets/models/usuario.model';
import {HttpClient, HttpResponse, HttpErrorResponse} from '@angular/common/http';
import { URL_SERVICIOS } from '../../config/config';
import 'rxjs/add/operator/map';
import { Router } from '@angular/router';
import { Options } from 'selenium-webdriver/chrome';
import { SubirArchivoService } from '../subir-archivo/subir-archivo.service';

@Injectable()
export class UsuarioService {
  usuario: any;
  productos: any;
  token: string;

  constructor(
    public router: Router,
    public http: HttpClient,
    public _subirArchivoService: SubirArchivoService
  ) {
    console.log('servicio inicaao');
    this.cargarStorage();
  }
  estaLogeado() {
    return (this.token.length > 5) ? true : false;
  }
  cargarStorage() {
    if ( localStorage.getItem('token')) {
      this.token = localStorage.getItem('token');
      this.usuario = JSON.parse(localStorage.getItem('usuario'));
    } else {
      this.token = '';
    }
  }
  guardarEnStorage(token: string, usuario: any) {
    localStorage.setItem('token', token);
    localStorage.setItem('usuario', usuario);
    this.token = token;
    this.usuario = usuario;
  }
  logout() {
    this.token = '';
    localStorage.removeItem('token');
    localStorage.removeItem('usuario');
    this.router.navigate(['/login']);
  }

  login( usuario: Usuario) {
    const url = URL_SERVICIOS + '/auth/autenticar';
    return this.http.post( url, usuario)
              .map( (res: any) => {
                this.guardarEnStorage(res.token, JSON.stringify(res.usuario));
                      return true;
                    });

  }
  crearUsuario(usuario: Usuario) {
    const url = URL_SERVICIOS + '/usuario/registrar';
    return this.http.post( url, usuario );
  }
obtenerMisProductos() {
  let url = URL_SERVICIOS + '/producto/listarmisproductos/';
   url += this.usuario.id + '/es';
   return this.http.get(url)
            .map((res: any) => res);

 }

 CrearProducto( producto: any) {
   producto['usuario_id'] = this.usuario.id;
   console.log(producto);
  const url = URL_SERVICIOS + '/producto/crearproducto';
 // makeFileRequest()
  return this.http.post( url, producto );
 }

 cambiarImagen( imagen: File, id: string  ) {
  this._subirArchivoService.subirArchivo(imagen, 'producto', this.usuario.id, id, this.token )
      .then( res => {
        console.log('ha subiod el archivo');
        console.log( res );

      })
      .catch( res => {
        console.log( res );
      });
 }
 obtenerIdiomas() {
   const url = URL_SERVICIOS + '/producto/listaridiomas';
   return this.http.get(url).map((res: any) => res);

 }
}
