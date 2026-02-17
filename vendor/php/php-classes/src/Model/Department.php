<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Department extends Model {
  public static function getDepartments() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_departments");
  }

  public static function listAll() {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_departments ORDER BY name");
}

public function save() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_departments_save(:name, :cod_department)", array(
        ":name"=>$this->getname(),
        ":cod_department"=>$this->getcod_department()
    ));
    $this->setData($results[0]);
}

public function get($id_department) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_departments WHERE id_department = :id_department", array(
        ":id_department"=>$id_department
    ));
    $data = $results[0];
    $this->setData($data);
}

public function delete() {
    $sql = new Sql();
    $sql->query("CALL sp_departments_delete(:id_department)", array(
        ":id_department"=>$this->getid_department()
    ));
}

public function update() {
    $sql = new Sql();
    $results = $sql->select("CALL sp_departmentsupdate_save(:id_department, :name, :cod_department)", array(
        ":id_department"=>$this->getid_department(),
        ":name"=>$this->getname(),
        ":cod_department"=>$this->getcod_department()
    ));

    
    $this->setData($results[0]);
   
}

}
