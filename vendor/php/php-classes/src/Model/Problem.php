<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Problem extends Model {
  public static function getProblems() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_problems");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_problems ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_problems_save(:name, :descrition, :cod_problem)", array(
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_problem"=>$this->getcod_problem()
    ));
    $this->setData($results[0]);
}

public function get($id_problem) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_problems WHERE id_problem = :id_problem", array(
        ":id_problem"=>$id_problem
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_problems_delete(:id_problem)", array(
        ":id_problem"=>$this->getid_problem()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_problemsupdate_save(:id_problem, :name, :descrition, :cod_problem)", array(
        ":id_problem"=>$this->getid_problem(),
        ":name"=>$this->getname(),
        ":descrition"=>$this->getdescrition(),
        ":cod_problem"=>$this->getcod_problem()
    ));

    
    $this->setData($results[0]);
   
}

}
