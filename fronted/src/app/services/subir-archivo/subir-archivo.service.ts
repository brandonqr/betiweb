import { Injectable } from '@angular/core';
import { URL_SERVICIOS } from '../../config/config';

@Injectable()
export class SubirArchivoService {
  constructor(
  ) {}

  // file-> imagen, tipo->producto, imagen, etc, id->id se utiliza para actualizar
  subirArchivo(archivo: File, tipo: string , usuario_id: string, id: string, token) {
    return new Promise( (resolve, reject ) => {
      const formData = new FormData();
      const xhr = new XMLHttpRequest();

      formData.append('imagen', archivo, archivo.name);
      console.log(formData.get('imagen'));

      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            console.log('Imagen subida');
             resolve( xhr.response );
          } else {
            console.log( 'falló la subida' );
             reject( xhr.response );

          }
        }
      };

      const url = URL_SERVICIOS + '/upload/' + tipo + '/' + usuario_id + '/' + id;

      xhr.open( 'POST', url, true );
      xhr.withCredentials = true;
      // tslint:disable-next-line:max-line-length
      xhr.setRequestHeader('Authorization', token);
      xhr.send( formData );
    });

  }
}
