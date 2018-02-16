<?php
namespace App\model;

use App\Lib\Response;

class TestModel{
  private $db;
  private $table = 'empleado';
  private $response;

  public function __CONSTRUCT($db){
    $this->db = $db;
    $this->response = new Response();
  }
  public function GetAll($l,$p){
    $data = $this->db->from($this->table)
                     ->limit($l)
                     ->offset($p)
                     ->orderBy('id DESC')
                     ->fetchAll();
    $total = $this->db->from($this->table)
                      ->select('COUNT(*) total')
                      ->fetch()
                      ->total;
    return [
      'data' => $data,
      'total' => $total
    ];
  }
  public function Insert($data){
    $data['password'] = md5($data['password']);
    $this->db->insertInto($this->table, $data)
             ->execute();

     return $this->response->SetResponse(true);
  }
}
?>
