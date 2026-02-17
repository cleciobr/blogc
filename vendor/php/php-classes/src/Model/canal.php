<?php

namespace Php\Model;

use \Php\DB\Sql;
use Php\Model;
use Php\Mailer;
use Php\MailerCommunication;

class Canal extends Model {

    //Total notification
    public static function getCommunications()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_canal ORDER BY id_communication DESC");
	}
    
		public function getSingleCommunication($communicationId) {
			$sql = new Sql();
			$results = $sql->select("SELECT * FROM tb_canal WHERE id_communication = :id_communication", array(":id_communication" => $communicationId));

            $communication = $results[0];
			$this->setData($communication);
        }

    //Total notification year
    public static function getCommunicationsyear()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_canal WHERE YEAR(dt_comm) = YEAR(CURRENT_DATE())");
	}
    
     //Total notification month
    public static function getCommunicationsmonth()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_canal WHERE MONTH(dt_comm) = MONTH(CURRENT_DATE()) AND YEAR(dt_comm) = YEAR(CURRENT_DATE())");
	}
    
		public function getSingleCommunicationmonth($communicationmonthId) {
			$sql = new Sql();   
			$results = $sql->select("SELECT * FROM tb_canal WHERE id_communication = :id_communication", array(":id_communication" => $communicationmonthId));
			$communicationmonth = $results[0];
			$this->setData($communicationmonth);
        }


    //Total notification today
    public static function getCommunicationstoday()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_canal WHERE DATE (dt_comm)= CURDATE()");
	}
    
		public function getSingleCommunicationtoday($communicationtodayId) {
			$sql = new Sql();   
			$results = $sql->select("SELECT * FROM tb_canal WHERE id_communication = :id_communication", array(":id_communication" => $communicationtodayId));
			$communicationtoday = $results[0];
			$this->setData($communicationtoday);
        }


      //Total notification class
    public static function getCommunicationsclass()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_canal");
		
        
        
    }
		public function getSingleCommunicationclass($communicationclassId) {
			$sql = new Sql();   
			$results = $sql->select("SELECT * FROM tb_canal WHERE id_communication = :id_communication", array(":id_communication" => $communicationclassId));
			$communicationclass = $results[0];
			$this->setData($communicationclass);
        }


         public function save() {
             $sql = new Sql();
             $results = $sql->select("CALL sp_canal_save(:praise, :dt_comm, :st_oco, :descricao_oco, :dt_oco, :feedback, :nome, :setor, :email , :phone)", array(
              
             
                 ":praise"=>$this->getpraise(),
                 ":dt_comm"=>$this->getdt_comm(),
                 ":st_oco"=>$this->getst_oco(),
                 ":descricao_oco"=>$this->getdescricao_oco(),
                 ":dt_oco"=>$this->getdt_oco(),
                 ":feedback"=>$this->getfeedback(),
                 ":nome"=>$this->getnome(),
                 ":setor"=>$this->getsetor(),
                 ":email"=>$this->getemail(),
                 ":phone"=>$this->getphone(),
    
             ));

             $this->setData($results[0]);
      
         }

        // public function save() {
        //     $sql = new Sql();
        //     $results = $sql->select("CALL sp_notification_save(:nome_pac, :dt_nasc, :registro, :dt_relato, :dt_oco, :st_cante, :st_cado, :descricao, :solution)", array(
              
        //         ":nome_pac"=>$this->getnome_pac(),
        //         ":dt_nasc"=>$this->getdt_nasc(),
        //         ":registro"=>$this->getregistro(),
        //         ":dt_relato"=>$this->getdt_relato(),
        //         ":dt_oco"=>$this->getdt_oco(),
        //         ":st_cante"=>$this->getst_cante(),
        //         ":st_cado"=>$this->getst_cado(),
        //         ":descricao"=>$this->getdescricao(),
        //         ":solution"=>$this->getsolution(),
    
        //     ));
        //     $this->setData($results[0]);
           
        // }



    public function update() {
        $sql = new Sql();
        
        $results = $sql->select("UPDATE tb_canal SET id_int = :id_int, class_occ = :class_occ, degree_damg = :degree_damg , analysis = :analysis, senddate = :senddate, deadline = :deadline WHERE id_communication = :id_communication", array(
            
            ":id_communication"=>$this->getid_communication(),
            ":id_int"=>$this->getid_int(),
            ":class_occ"=>$this->getclass_occ(),
            ":degree_damg"=>$this->getdegree_damg(),
            ":analysis"=>$this->getanalysis(),
            ":senddate"=>$this->getsenddate(),
            ":deadline"=>$this->getdeadline(),
            
        ));
      
        
   }

    
   public function attachEmail($file) {
    $extension = explode('.', $file['name']);
    $extension = end($extension);
    
    $newName = $this->getid_communication().".".$extension;

    $dist = $_SERVER['DOCUMENT_ROOT']
       .DIRECTORY_SEPARATOR."res"
       .DIRECTORY_SEPARATOR."site"
       .DIRECTORY_SEPARATOR."communication"
       .DIRECTORY_SEPARATOR;

    move_uploaded_file($file['tmp_name'], $dist.$newName);
  }


   public function get($id_communication) {
      $sql = new Sql();
      $results = $sql->select("SELECT * FROM tb_canal WHERE id_communication = :id_communication", array(
         ":id_communication" => $id_communication
      ));
     
      $this->setData($results[0]);
     
   } 



    public function sendCommunication() {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_canal ORDER BY id_communication DESC LIMIT 1");
        $data = $results[0];
        $mailer = new MailerCommunicationr($data["id_communication"], $data["praise"], $data["dt_comm"],$data["st_oco"], $data["descricao_oco"], $data["dt_oco"], $data["feedback"], $data["nome"], $data["setor"], $data["email"], $data["phone"], "Comunicação Shineray", "email", array(
        "id_communication"=>$data["id_communication"],
            "praise"=>$data["praise"],
            "dt_comm"=>$data["dt_comm"],
            "st_oco"=>$data["st_oco"],
            "descricao_oco"=>$data["descricao_oco"],
            "dt_oco"=>$data["dt_oco"],
            "feedback"=>$data["feedback"],
            "nome"=>$data["nome"],
            "setor"=>$data["setor"],
            "email"=>$data["email"],
            "phone"=>$data["phone"]
        ));
        $mailer->send();
    }
    
    public function sendNotification() {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_notificacao ORDER BY id_notificacao DESC LIMIT 1");
        $data = $results[0];
        $mailer = new MailerCommunicationr($data["id_notificacao"], $data["id_int"], $data["nome_pac"],$data["dt_nasc"], $data["registro"], $data["dt_relato"], $data["dt_oco"], $data["st_cante"], $data["st_cado"], $data["descricao"], $data["solution"], "Notificacao Shineray", "email", array(
            "id_notificacao"=>$data["id_notificacao"],
            "id_int"=>$data["id_int"],
            "name_pac"=>$data["nome_pac"],
            "dt_nasc"=>$data["dt_nasc"],
            "registro"=>$data["registro"],
            "dt_relato"=>$data["dt_relato"],
            "dt_oco"=>$data["dt_oco"],
            "st_cante"=>$data["st_cante"],
            "st_cado"=>$data["st_cado"],
            "descricao"=>$data["descricao"],
            "solution"=>$data["solution"]
        ));
        $mailer->send();
    }
        // public function sendCommunication() {
    //     $sql = new Sql();
    //     $results = $sql->select("SELECT * FROM canal.tb_canal ORDER BY id_notificacao DESC LIMIT 1");
    //     $data = $results[0];
    //     $mailer = new Mailer($data["id_notificacao"], $data["id_int"], $data["nome_pac"],$data["dt_nasc"], $data["registro"], $data["dt_relato"], $data["dt_oco"], $data["st_cante"], $data["st_cado"], $data["descricao"], $data["solution"], "Denúncia Shineray", "email", array(
    //         "id_notificacao"=>$data["id_notificacao"],
    //         "id_int"=>$data["id_int"],
    //         "name_pac"=>$data["nome_pac"],
    //         "dt_nasc"=>$data["dt_nasc"],
    //         "registro"=>$data["registro"],
    //         "dt_relato"=>$data["dt_relato"],
    //         "dt_oco"=>$data["dt_oco"],
    //         "st_cante"=>$data["st_cante"],
    //         "st_cado"=>$data["st_cado"],
    //         "descricao"=>$data["descricao"],
    //         "solution"=>$data["solution"]
    //     ));
    //     $mailer->send();
    // }



    public static function getCommuToday(){

        $sql = new Sql();
        $results = $sql->select("SELECT count(*) FROM tb_canal WHERE DATE (dt_comm)= CURDATE();");
        if (count($results) > 0) {
            return $results[0];
        }else{
            return[];
        }
    }

    public static function getCommuMonth(){
        $sql = new Sql();
        $results = $sql->select("SELECT count(*) FROM tb_canal WHERE MONTH(dt_comm) = MONTH(CURRENT_DATE()) AND YEAR(dt_comm) = YEAR(CURRENT_DATE());");
        if (count($results) > 0) {
            return $results[0];
        }else{
            return[];
        }
    }

    public static function getCommuYear() {
        $sql = new Sql();
        $results = $sql->select("SELECT count(*) FROM tb_canal WHERE YEAR(dt_comm) = YEAR(CURRENT_DATE());");
        if (count($results) > 0) {
            return $results[0];
        } else {
            return [];
        }
    }



    public static function getCommuTotals() {
        $sql = new Sql();
        $results = $sql->select("SELECT COUNT(*) as nrqtd FROM tb_canal");
        return $results[0];
           
    }

    public static function getDateAtual() {
        $sql = new Sql();
        $results = $sql->select("SELECT DATE_FORMAT(NOW(),'%d-%m-%Y') as data");
        return $results[0];
           
    }
  

     //Total notification no class
     public static function getCommunicationsnoclass()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM db_canal.tb_canal where degree_damg = '' or degree_damg = '0000-00-00'");
     }

      //Total notification class incomplet
      public static function getCommunicationsclassincomplet()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM db_canal.tb_canal where deadline = '' or deadline = '0000-00-00'");
     }

     //Total notification finalizados
      public static function getCommunicationsfinished()  {
            $sql = new Sql();
            return $sql->select("SELECT * FROM db_canal.tb_canal where analysis <> ''");
    }

    
}