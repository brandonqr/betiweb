export class Producto {
    constructor(
      public idioma_codigo: string,
      public titulo: string,
      public descripcion: string,
      public imagen: File,
      public precio_min: string,
      public precio_max: string,
      public dimensiones: string,
      public categoria_id: string
    ) { }
}