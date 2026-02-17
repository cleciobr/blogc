<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Process extends Model {
  public static function getProcesss() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_processs");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_processs ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_processs_save(:name, :descrition, :cod_process)", array(
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_process"=>$this->getcod_process()
    ));
    $this->setData($results[0]);
}

public function get($id_process) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_processs WHERE id_process = :id_process", array(
        ":id_process"=>$id_process
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_processs_delete(:id_process)", array(
        ":id_process"=>$this->getid_process()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_processsupdate_save(:id_process, :name, :descrition, :cod_process)", array(
        ":id_process"=>$this->getid_process(),
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_process"=>$this->getcod_process()
    ));

    
    $this->setData($results[0]);
   
}

}
