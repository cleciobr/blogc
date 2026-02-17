<?php

namespace Php\Model;

use \Php\DB\Sql;
use Php\Model;

class Ramal extends Model {


    
        public static function listAll() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_ramais ORDER BY setor_sala");
    }

    public function save() {
    $sql = new Sql();
    
        // Agora a CALL precisa de todos os parâmetros definidos na Procedure
        $results = $sql->select("CALL sp_ramais_save(:unidade, :setor_sala, :colaborador, :ddr, :ramal, :celular, :emails, :ativo)", array(
            ":unidade"      => $this->getunidade(),
            ":setor_sala"   => $this->getsetor_sala(), // Verifique se o getter é getsetor() ou getsetor_sala()
            ":colaborador"  => $this->getcolaborador(),
            ":ddr"          => $this->getddr(),
            ":ramal"        => $this->getramal(),
            ":celular"      => $this->getcelular(),
            ":emails"       => $this->getemails(),
            ":ativo"       => $this->getativo()
        ));

        if (count($results) > 0) {
            $this->setData($results[0]);
        }
    }

    public function get($idramal) {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_ramais WHERE id_agenda = :id_agenda", array(
            ":id_agenda"=>$idramal
        ));
        $data = $results[0];
        $this->setData($data);
    }

    public function delete() {
        $sql = new Sql();
        $sql->query("CALL sp_ramais_delete(:id_agenda)", array(
            ":id_agenda"=>$this->getid_agenda()
        ));
    }

    public function update() {
    $sql = new Sql();
        
        // A CALL agora espera 8 parâmetros no total (ID + 7 campos)
        $results = $sql->select("CALL sp_ramaisupdate_save(:id_agenda, :unidade, :setor_sala, :colaborador, :ddr, :ramal, :celular, :emails, :ativo)", array(
            ":id_agenda"    => $this->getid_agenda(),
            ":unidade"      => $this->getunidade(),
            ":setor_sala"   => $this->getsetor_sala(), //
            ":colaborador"  => $this->getcolaborador(),
            ":ddr"          => $this->getddr(),
            ":ramal"        => $this->getramal(),
            ":celular"      => $this->getcelular(),
            ":emails"       => $this->getemails(),
            ":ativo"        => $this->getativo(),
        ));

        
        if (count($results) > 0) {
            $this->setData($results[0]);
        }
    }


    // public function update2() {
    //     $sql = new Sql();
    //     $results = $sql->select("CALL sp_ramaisupdate_save(:id_agenda, :setor_sala, :ramal, :colaborador)", array(
    //         ":id_agenda"=>$this->getid_agenda(),
    //         ":setor_sala"=>$this->getsetor(),
    //         ":ramal"=>$this->getramal(),
    //         ":colaborador"=>$this->getcolaborador()
    //     ));

        
    //     $this->setData($results[0]);
       
    // }

}
