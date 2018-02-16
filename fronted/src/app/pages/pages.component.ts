import { Component, OnInit } from '@angular/core';
import { UsuarioService } from '../services/service.index';

@Component({
  selector: 'app-pages',
  templateUrl: './pages.component.html',
  styles: []
})
export class PagesComponent implements OnInit {

  constructor(
    public _usuarioService: UsuarioService
  ) { }

  ngOnInit() {
  }
}
