import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Producto } from '../../../assets/models/producto.model';
import {UsuarioService } from '../../services/usuario/usuario.service';

@Component({
  selector: 'app-agregar',
  templateUrl: './agregar.component.html',
  styles: []
})
export class AgregarComponent implements OnInit {
  // producto: Producto;
  forma: FormGroup;
  imagenASubir: File;

  constructor(public _usuarioService: UsuarioService) {}

  ngOnInit() {
    this.forma = new FormGroup({
      idioma: new FormControl(null, Validators.required),
      titulo: new FormControl(null, Validators.required),
      descripcion: new FormControl(null, Validators.required),
      imagen: new FormControl(null, Validators.required),
      pMin: new FormControl(null, Validators.required),
      pMax: new FormControl(null, Validators.required),
      dimensiones: new FormControl(null, Validators.required),
      categoria_id: new FormControl(null, Validators.required)
    });
    /*
          public idioma: string,
      public titulo: string,
      public descripcion: string,
      public imagen: string,
      public pMin: string,
      public pMax: string,
      public dimensiones: string,
      public categoria: string
    */
    /*
    this.forma.setValue({
      idioma: 'es',
      titulo: 'producto numero 1',
      descripcion: 'descripcion producto numero 1',
      imagen: 'img/imagen.jpg',
      pMin: '1500',
      pMax: '17002',
      dimensiones: '20 x 30',
      categoria_id: '1'
    });
    */
  }
  registroProducto() {
    /*
    if (this.forma.invalid) {
      console.log('invalid');
      return;
    }*/
    const producto = new Producto(
      // this.forma.value
      this.forma.value.idioma,
      this.forma.value.titulo,
      this.forma.value.descripcion,
      this.forma.value.imagen,
      this.forma.value.pMin,
      this.forma.value.pMax,
      this.forma.value.dimensiones,
      this.forma.value.categoria_id
    );
    this._usuarioService.CrearProducto(producto).subscribe((res: any) => {
      console.log(res); // obtener id de producto y nombre de producto, para poder insertar la imagen
      this._usuarioService.cambiarImagen(this.imagenASubir, res.producto.producto_id );
    });

    // console.log(producto);
  }
  seleccionImagen(imagen: File) {
    if ( !imagen ) {
      this.imagenASubir = null;
      return;
    }
      this.imagenASubir = imagen;
      console.log(this.imagenASubir);
      // this._usuarioService.cambiarImagen(this.imagenASubir);
  }
}
