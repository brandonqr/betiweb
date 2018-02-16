import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
// models
import {Usuario } from '../../assets/models/usuario.model';

// servicios
import {UsuarioService } from '../services/usuario/usuario.service';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styles: []
})
export class RegistroComponent implements OnInit {

forma: FormGroup;

  constructor(
    public _usuarioService: UsuarioService
  ) { }
  sonIguales(campo1: string, campo2: string) {
    return ( group: FormGroup ) => {
      const pass = group.controls[campo1].value;
      const pass2 = group.controls[campo2].value;
      if ( pass === pass2) {
        return null;
      }
      return {
        sonIguales: true
      };
    };
  }

  ngOnInit() {

    this.forma = new FormGroup({
      nombre: new FormControl(null, Validators.required),
      email: new FormControl(null, [Validators.required, Validators.email]),
      apellidos: new FormControl(null, Validators.required),
      dni: new FormControl(null, Validators.required),
      ciudad: new FormControl(null, Validators.required),
      cp: new FormControl(null, Validators.required),
      pass: new FormControl(null, Validators.required),
      pass2: new FormControl(null, Validators.required),
      condiciones: new FormControl(null, Validators.required),

    }, {validators: this.sonIguales( 'pass', 'pass2' )});
    this.forma.setValue({
      nombre: 'Brandon',
      email: 'Brandonqr1@gmail.com',
      apellidos: 'Quiroz',
      dni: '1111111H',
      ciudad: 'Girona',
      cp: '17002',
      pass: '123456',
      pass2: '123456',
      condiciones: false
    });
  }
registroUsuario() {
  if ( this.forma.invalid) {
      return;
  }
  if ( !this.forma.value.condiciones) {
    console.log('debe aceptar las condiciones');
  }
  const usuario = new Usuario(
    // this.forma.value
    this.forma.value.nombre,
    this.forma.value.email,
    this.forma.value.pass,
    this.forma.value.apellidos,
    this.forma.value.dni,
    this.forma.value.ciudad,
    this.forma.value.cp

  );
  console.log(usuario);

  this._usuarioService.crearUsuario( usuario )
                      .subscribe( resp => {
                        console.log( resp );
                      });
}
}

