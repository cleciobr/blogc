<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Convenant extends Model {

  public static function listAll() {
    $sql = new Sql();
    return $sql -> select("SELECT * FROM tb_convenants");
    
  }

  public static function checkList($list) {
    foreach ($list as &$row) {
      $p = new Convenant();
      $p -> setData($row);
      $row = $p -> getValues();
    }
    return $list;
  }

  public function get($id_convenant) {
    $sql = new Sql();
    $results = $sql -> select("SELECT * FROM tb_convenants WHERE id_convenant = :id_convenant", [
      "id_convenant" => $id_convenant
    ]);
    $this -> setData($results[0]);
  }

   public function save() {
     $sql = new Sql();
     $results = $sql -> select("CALL sp_convenants_save(:id_convenant, :name_convenant, :call_center, :site, :id_user)", [
       ":id_convenant" => $this -> getid_convenant(),
       ":name_convenant" => $this -> getname_convenant(),
       ":call_center" => $this -> getcall_center(),
       ":site" => $this -> getsite(),
       ":id_user" => $this -> getid_user() 
     ]);
     
     $this -> setData($results[0]);
   }


  public function update() {
    $sql = new Sql();
    $results = $sql -> select("CALL sp_convenantsupdate_save(:id_convenant, :name_convenant, :call_center, :site, :id_user)", [
      ":id_convenant" => $this -> getid_convenant(),
      ":name_convenant" => $this -> getname_convenant(),
      ":call_center" => $this -> getcall_center(),
      ":site" => $this -> getsite(),
      ":id_user" => $this -> getid_user()
    ]);
    $this -> setData($results[0]);
  }

  public function delete() {
    $sql = new Sql();
    $sql -> query("DELETE FROM tb_convenants WHERE id_convenant = :id_convenant", [
      ":id_convenant" => $this -> getid_convenant()
    ]);
  }
}
