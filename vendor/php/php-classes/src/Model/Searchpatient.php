<?php

namespace Php\Model;

use \Php\DB\SqlOracle; 
use \Php\Model;

class Searchpatient extends Model {


    // public static function search3($searchText) {
    //     $SqlOracle = new SqlOracle();
    //     $query = "SELECT * FROM FAPACCAD WHERE NOME_SEGU LIKE '%' || :searchText || '%' ORDER BY NOME_SEGU DESC";
    //     $params = array(
    //         ':searchText' => "'" . $searchText . "'" 
    //     );
    //     return $SqlOracle->select($query, $params);
    // }

    public static function searchok($searchText) {
        $SqlOracle = new SqlOracle();
        $query = "SELECT * FROM FAPACCAD WHERE NOME_SEGU LIKE '%' || :searchText || '%' ORDER BY NOME_SEGU DESC";
        $params = array(
            ':searchText' => $searchText
        );
        return $SqlOracle->select($query, $params);
    }
    
    public static function search($searchText) {
        $SqlOracle = new SqlOracle();
        $query = "SELECT * FROM FAPACCAD WHERE COD_PAC LIKE :searchText OR LEITO LIKE :searchText OR NOME_SEGU LIKE '%' || :searchText || '%' ORDER BY NOME_SEGU DESC";
        $params = array(
            ':searchText' => '%' . $searchText . '%'
        );
        return $SqlOracle->select($query, $params);
    }
    

    

    public static function search2() {
        $SqlOracle = new SqlOracle();
        return $SqlOracle->select("SELECT * FROM FAPACCAD WHERE NOME_SEGU LIKE '%' || 'RODRIGO CESAR BARBOSA PESSOA FERREIRA' || '%' ORDER BY NOME_SEGU DESC");
    }

    public static function listAllLimit() {
        $SqlOracle = new SqlOracle();
        return $SqlOracle->select("SELECT * FROM (SELECT * FROM FAPACCAD ORDER BY NOME_SEGU DESC) WHERE ROWNUM <= 8");
    }
    


    public static function getPatientsdgs() {
        $SqlOracle = new SqlOracle(); 
        return $SqlOracle->select("SELECT * FROM FAPACCAD ORDER BY nome_segu DESC LIMIT 8");
    }
    

    // public static function listAllLimit() {
    //     $SqlOracle = new SqlOracle();
    //     return $SqlOracle->select("SELECT * FROM (SELECT * FROM FAPACCAD ORDER BY NOME_SEGU DESC) WHERE ROWNUM <= 8");
    // }



    // public function getLastCodPac() {
    //     $SqlOracle = new SqlOracle();
    //     $lastCodPacQuery = "SELECT MAX(COD_PAC) AS MAX_COD_PAC FROM FAPACCAD";
    //     $lastCodPacResult = $SqlOracle->select($lastCodPacQuery);
    //     $lastCodPac = $lastCodPacResult[0]['MAX_COD_PAC'];
    //     $newCodPac = $lastCodPac + 1;
    
    //     return $newCodPac;
    // }


    public function getLastCodPrt() {
        $SqlOracle = new SqlOracle();
        $lastCodPrtQuery = "SELECT MAX(COD_PRT) AS MAX_COD_PRT FROM FAPACCAD WHERE REGEXP_LIKE(COD_PRT, '^[[:digit:]]+$')";
        $lastCodPrtResult = $SqlOracle->select($lastCodPrtQuery);
        
        if (!empty($lastCodPrtResult) && isset($lastCodPrtResult[0]['MAX_COD_PRT'])) {
            $lastCodPrt = $lastCodPrtResult[0]['MAX_COD_PRT'];
        } else {
            $lastCodPrt = 0;
        }
        
        $newCodPrt = $lastCodPrt + 1;
    
        return $newCodPrt;
    }
    
    

    public function getLastCodPac() {
        $SqlOracle = new SqlOracle();
        $lastCodPacQuery = "SELECT MAX(COD_PAC) AS MAX_COD_PAC FROM FAPACCAD WHERE REGEXP_LIKE(COD_PAC, '^[[:digit:]]+$')";
        $lastCodPacResult = $SqlOracle->select($lastCodPacQuery);
        
        if (!empty($lastCodPacResult) && isset($lastCodPacResult[0]['MAX_COD_PAC'])) {
            $lastCodPac = $lastCodPacResult[0]['MAX_COD_PAC'];
        } else {
            $lastCodPac = 0;
        }
        
        $newCodPac = $lastCodPac + 1;
    
        return $newCodPac;
    }
    


    public function save() {
        $SqlOracle = new SqlOracle();
        $newCodPac = $this->getLastCodPac();
        $currentLastCodPac = $this->getLastCodPac();
        if ($newCodPac !== $currentLastCodPac) {
            $newCodPac = $this->getLastCodPac();
        }
        $rawQuery = "INSERT INTO FAPACCAD (COD_PAC, NOME_SEGU, LEITO, COD_PRT) VALUES (:cod_pac, :nome_segu, :leito, :cod_prt)";
        $SqlOracle->query($rawQuery, array(
            ":cod_pac" => $newCodPac,
            ":nome_segu" => $this->getNOME_SEGU(),
            ":leito" => $this->getLEITO(),
            ":cod_prt" => $this->getCOD_PRT()
        ));
    }
    
    
    public function update() {
     
        $SqlOracle = new SqlOracle();
   
        $rawQuery = "UPDATE FAPACCAD SET NOME_SEGU = :nome_segu WHERE COD_PAC = :cod_pac";
   
       
        $SqlOracle->query($rawQuery, array(
            ":nome_segu" => $this->getNOME_SEGU(),
            ":cod_pac" => $this->getCOD_PAC()
        ));
    }
    

    
    public function update2() {
        $SqlOracle = new SqlOracle();
    
        $rawQuery = "UPDATE FAPACCAD SET 
                        NOME_SEGU = :nome_segu
                     WHERE COD_PAC = :cod_pac";
    
        $SqlOracle->query($rawQuery, array(
            ":nome_segu" => $this->getNOME_SEGU(),
            ":cod_pac" => $this->getCOD_PAC()
        ));
    }
    








    // public static function listAll() {
    //     $SqlOracle = new SqlOracle();
    //     return $SqlOracle->select("SELECT * FROM FAPACCAD ORDER BY nome_segu");
    // }
    public static function listAll() {
        $SqlOracle = new SqlOracle();
        return $SqlOracle->select("SELECT * FROM FAPACCAD");
    }

    public static function listAll3($page = 1, $registro = null, $nome_segu = null, $leito = null) {
        $SqlOracle = new SqlOracle();
        $limit = 10; 
        $offset = ($page - 1) * $limit; 
        
        $query = "SELECT * FROM FAPACCAD WHERE 1 = 1"; 
        
        $params = array();
        
        // Adiciona condição para registro se fornecido
        if ($registro !== null) {
            $query .= " AND registro = :registro";
            $params[':registro'] = $registro;
        }
        
        // Adiciona condição para nome_segu se fornecido
        if ($nome_segu !== null) {
            $query .= " AND nome_segu = :nome_segu";
            $params[':nome_segu'] = $nome_segu;
        }
        
        // Adiciona condição para leito se fornecido
        if ($leito !== null) {
            $query .= " AND leito = :leito";
            $params[':leito'] = $leito;
        }
        
        // Adiciona cláusula LIMIT e OFFSET para paginação
        $query .= " LIMIT $limit OFFSET $offset";
        
        $results = $SqlOracle->select($query, $params);
        
        // Retorna apenas 10 registros se nenhum parâmetro de pesquisa for fornecido
        if ($registro === null && $nome_segu === null && $leito === null) {
            return $results;
        }
        
        // Caso contrário, verifica se há mais registros além dos 10 retornados
        $moreResults = $SqlOracle->select("SELECT COUNT(*) AS total FROM FAPACCAD WHERE 1 = 1", $params);
        $totalRecords = $moreResults[0]['total'];
        $hasMore = count($results) < $totalRecords;
        
        return array(
            'records' => $results,
            'hasMore' => $hasMore
        );
    }
    

    public static function testConnection() {
        $SqlOracle = new SqlOracle();
        $result = $SqlOracle->select("SELECT 1 FROM DUAL");
        return !empty($result);
    }
    




// public function save() {
//     $SqlOracle = new SqlOracle();
//     $results = $SqlOracle->select("CALL sp_departments_save(:name, :cod_department)", array(
//         ":name"=>$this->getname(),
//         ":cod_department"=>$this->getcod_department()
//     ));
//     $this->setData($results[0]);
// }

public function get($COD_PAC) {
    $SqlOracle = new SqlOracle();
    $results = $SqlOracle->select("SELECT * FROM FAPACCAD WHERE COD_PAC = :COD_PAC", array(
        ":COD_PAC"=>$COD_PAC
    ));
    if (!empty($results)) {
        $data = $results[0];
        $this->setData($data);
    } else { 
}}

public function delete() {
    $SqlOracle = new SqlOracle();
    $SqlOracle->query("CALL sp_FAPACCAD_PACIENTES_delete(:COD_PAC)", array(
        ":COD_PAC"=>$this->getid_department()
    ));
}

 






}