import { Component, OnInit } from '@angular/core';
import { UsuarioService } from '../../services/usuario/usuario.service';

@Component({
  selector: 'app-editar',
  templateUrl: './editar.component.html',
  styles: []
})
export class EditarComponent implements OnInit {
idiomas: any;
  constructor(
    public _usuarioService: UsuarioService
  ) { }

  ngOnInit() {
     this._usuarioService.obtenerIdiomas().subscribe(
      res => {
      this.idiomas = res;
      console.log(this.idiomas)
      ;
      }
    );
  }

}
