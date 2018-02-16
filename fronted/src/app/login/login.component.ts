import { Component, OnInit } from '@angular/core';
import { Router} from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';
// models
import {Usuario } from '../../assets/models/usuario.model';

// servicios
import {UsuarioService } from '../services/service.index';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styles: []
})
export class LoginComponent implements OnInit {
forma: FormGroup;
  constructor(
              public _usuarioService: UsuarioService,
              public router: Router) { }

  ngOnInit() {
    this.forma = new FormGroup({
      email: new FormControl(null, [Validators.required, Validators.email]),
      pass: new FormControl(null, Validators.required)

    });
    }
  login() {
    if (this.forma.invalid) {
        return;
    }
    const usuario = new Usuario(
                              null,
                              this.forma.value.email,
                              this.forma.value.pass,
                              null,
                              null,
                              null,
                              null
                            );
    this._usuarioService.login( usuario)
                        .subscribe(() => this.router.navigate(['/dashboard']));
  }

}
