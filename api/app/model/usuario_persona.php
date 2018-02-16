<?php
namespace App\model;

use App\Lib\Response;

class UsuarioModel{
  private $db;
  private $table = 'usuario_persona';
  private $response;

  public function __CONSTRUCT($db){
    $this->db = $db;
    $this->response = new Response();
  }
  public function Listar(){
    $data = $this->db->from($this->table)
                     ->orderBy('id DESC')
                     ->fetchAll();//cuando queremos retornar varios registros.
    $total = $this->db->from($this->table)
                      ->select('COUNT(*) Total')
                      ->fetch()
                      ->Total;
    return [
      'data' => $data,
      'total' => $total
    ];
  }

  public function Obtener($id){
    return $this->db->from($this->table,$id)
                    ->fetch();//cuando queremos retornar un sólo registro.
  }

  public function Registrar($data){

    $data['pass'] = md5($data['pass']);
    $this->db->insertInto($this->table, $data)
             ->execute();

     return $this->response->SetResponse(true);
  }

  public function Actualizar($data, $id){
  //  $data['pass'] = md5($data['pass']);
    $this->db->update($this->table, $data, $id)
             ->execute();

     return $this->response->SetResponse(true);
  }

  public function Eliminar($data){
    $this->db->deleteFrom($this->table, $data, $id)
             ->execute();

     return $this->response->SetResponse(true);
  }


//listar productos por usuario depende del idioma


}
?>
