<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Factoccurred extends Model {
  public static function getFactoccurreds() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_factoccurreds");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_factoccurreds ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_factoccurreds_save(:name, :descrition, :cod_factoccurred)", array(
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_factoccurred"=>$this->getcod_factoccurred()
    ));
    $this->setData($results[0]);
}

public function get($id_factoccurred) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_factoccurreds WHERE id_factoccurred = :id_factoccurred", array(
        ":id_factoccurred"=>$id_factoccurred
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_factoccurreds_delete(:id_factoccurred)", array(
        ":id_factoccurred"=>$this->getid_factoccurred()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_factoccurredsupdate_save(:id_factoccurred, :name, :descrition, :cod_factoccurred)", array(
        ":id_factoccurred"=>$this->getid_factoccurred(),
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_factoccurred"=>$this->getcod_factoccurred()
    ));

    
    $this->setData($results[0]);
   
}

}
