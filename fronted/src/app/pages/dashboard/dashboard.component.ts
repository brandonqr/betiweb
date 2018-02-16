import { Component, OnInit, Pipe, PipeTransform} from '@angular/core';
import { UsuarioService } from '../../services/usuario/usuario.service';
import { Usuario } from '../../../assets/models/usuario.model';
import { HttpClient } from '@angular/common/http';
// servicios


@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styles: []
})
export class DashboardComponent implements OnInit {
  usuario: Usuario;
  constructor(
    public _usuarioService: UsuarioService
  ) { }

  ngOnInit() {
    this._usuarioService.cargarStorage();
    this.usuario = this._usuarioService.usuario;
  }

}
