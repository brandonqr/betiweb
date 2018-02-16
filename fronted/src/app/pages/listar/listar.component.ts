import { Component, OnInit } from '@angular/core';
import { UsuarioService } from '../../services/service.index';
import { URL_SERVICIOS } from '../../config/config';

@Component({
  selector: 'app-listar',
  templateUrl: './listar.component.html',
  styles: []
})
export class ListarComponent implements OnInit {
  productos: any[] = [];
  url;
  constructor( public _usuarioService: UsuarioService) { }

  ngOnInit() {
    this._usuarioService.obtenerMisProductos().subscribe(
      response => {
           this.productos = response.producto; // solo muestra un producto, arreglar luego
           this.url = URL_SERVICIOS + '/';
          // console.log(this.productos[1].titulo);
          console.log(this.productos);
      }, err => {

      }
    );
  }

}
