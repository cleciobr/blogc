<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Degree_damg extends Model {
  public static function getDegree_damgs() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_degree_damgs");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_degree_damgs ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_degree_damgs_save(:name, :days_degree_damg, :descrition, :cod_degree_damg)", array(
        ":name"=>$this->getname(),
        ":days_degree_damg"=>$this->getdays_degree_damg(),
        ":descrition"=>$this->getdescrition(),
        ":cod_degree_damg"=>$this->getcod_degree_damg()
    ));
    $this->setData($results[0]);
}

public function get($id_degree_damg) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_degree_damgs WHERE id_degree_damg = :id_degree_damg", array(
        ":id_degree_damg"=>$id_degree_damg
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_degree_damgs_delete(:id_degree_damg)", array(
        ":id_degree_damg"=>$this->getid_degree_damg()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_degree_damgsupdate_save(:id_degree_damg, :name, :days_degree_damg, :descrition, :cod_degree_damg)", array(
        ":id_degree_damg"=>$this->getid_degree_damg(),
        ":name"=>$this->getname(),
        ":days_degree_damg"=>$this->getdays_degree_damg(),
        ":descrition"=>$this->getdescrition(),
        ":cod_degree_damg"=>$this->getcod_degree_damg()
    ));
    $this->setData($results[0]);
   
}

}
