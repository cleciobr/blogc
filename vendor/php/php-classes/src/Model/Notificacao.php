<?php

namespace Php\Model;

use \Php\DB\Sql;
use Php\Model;
use Php\MailerNotification;

class Notificacao extends Model {

    //Total notification
    public static function getNotifications()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_notificacao ORDER BY id_notificacao DESC");
	}

    
		public function getSingleNotification($notificationId) {
			$sql = new Sql();
			$results = $sql->select("SELECT * FROM tb_notificacao WHERE id_notificacao = :id_notificacao", array(":id_notificacao" => $notificationId));

            $notification = $results[0];
			$this->setData($notification);
        }

    //Total notification year
    public static function getNotificationsyear()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_notificacao WHERE YEAR(dt_notificacao) = YEAR(CURRENT_DATE()) ORDER BY id_notificacao DESC");
	}
    
     //Total notification month
    public static function getNotificationsmonth()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_notificacao WHERE MONTH(dt_notificacao) = MONTH(CURRENT_DATE()) AND YEAR(dt_notificacao) = YEAR(CURRENT_DATE()) ORDER BY id_notificacao DESC");
	}
    
		public function getSingleNotificationmonth($notificationmonthId) {
			$sql = new Sql();   
			$results = $sql->select("SELECT * FROM tb_notificacao WHERE id_notificacao = :id_notificacao", array(":id_notificacao" => $notificationmonthId));
			$notificationmonth = $results[0];
			$this->setData($notificationmonth);
        }

    //Total notification today
    public static function getNotificationstoday()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_notificacao WHERE DATE (dt_notificacao)= CURDATE() ORDER BY id_notificacao DESC");
	}
    
		public function getSingleNotificationtoday($notificationtodayId) {
			$sql = new Sql();   
			$results = $sql->select("SELECT * FROM tb_notificacao WHERE id_notificacao = :id_notificacao", array(":id_notificacao" => $notificationtodayId));
			$notificationtoday = $results[0];
			$this->setData($notificationtoday);
        }

      //Total notification class
    public static function getNotificationsclass()  {
			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_notificacao");
		
    }
		public function getSingleNotificationclass($notificationclassId) {
			$sql = new Sql();   
			$results = $sql->select("SELECT * FROM tb_notificacao WHERE id_notificacao = :id_notificacao", array(":id_notificacao" => $notificationclassId));
			$notificationclass = $results[0];
			$this->setData($notificationclass);
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
    //         ":solution"=>$this->getsolution()

    //     ));
      

    //     $this->setData($results[0]);
       
    // }





    public function save() {
        $dataAtual = date("Y-m-d");
        $sql = new Sql();
        $results = $sql->select("CALL sp_notification_save(
            :id_notificacao,
            :dt_notificacao,
            :patient,
            :nome_pac, 
            :dt_nasc,
            :atendimento,  
            :registro, 
            :dt_internamento,
            :dt_oco, 
            :hr_oco, 
            :st_cante,
            :st_cado,
            :class_incident,
            :descricao,
            :class_occ,
            :degree_damg, 
            :solution)", array(
                ":id_notificacao" => $this->getid_notificacao(),
                ":dt_notificacao" => $dataAtual, 
                ":patient" => $this->getpatient(),
                ":nome_pac" => $this->getnome_pac(),
                ":dt_nasc" => $this->getdt_nasc(),
                ":atendimento" => $this->getatendimento(),
                ":registro" => $this->getregistro(),
                ":dt_internamento" => $this->getdt_internamento(),
                ":dt_oco" => $this->getdt_oco(),
                ":hr_oco" => $this->gethr_oco(),
                ":st_cante" => $this->getst_cante(),
                ":st_cado" => $this->getst_cado(),
                ":class_incident" => $this->getclass_incident(),
                ":descricao" => $this->getdescricao(),
                ":class_occ" => $this->getclass_occ(),
                ":degree_damg" => $this->getdegree_damg(),
                ":solution" => $this->getsolution()
        ));

        
        $this->setData($results[0]);
    }
    


    public function saveadmin() {
        $sql = new Sql();
        $results = $sql->select("CALL sp_notification_saveadmin(
            :id_notificacao,
            :dt_notificacao,
            :patient,
            :nome_pac, 
            :dt_nasc,
            :atendimento,  
            :registro, 
            :dt_internamento,
            :dt_oco, 
            :hr_oco, 
            :st_cante,
            :st_cado,
            :class_incident,
            :descricao,
            :class_occ,
            :degree_damg, 
            :solution)", array(
                ":id_notificacao" => $this->getid_notificacao(),
                ":dt_notificacao" =>$this->getdt_notificacao(),
                ":patient" => $this->getpatient(),
                ":nome_pac" => $this->getnome_pac(),
                ":dt_nasc" => $this->getdt_nasc(),
                ":atendimento" => $this->getatendimento(),
                ":registro" => $this->getregistro(),
                ":dt_internamento" => $this->getdt_internamento(),
                ":dt_oco" => $this->getdt_oco(),
                ":hr_oco" => $this->gethr_oco(),
                ":st_cante" => $this->getst_cante(),
                ":st_cado" => $this->getst_cado(),
                ":class_incident" => $this->getclass_incident(),
                ":descricao" => $this->getdescricao(),
                ":class_occ" => $this->getclass_occ(),
                ":degree_damg" => $this->getdegree_damg(),
                ":solution" => $this->getsolution()
        ));

        $this->setData($results[0]);
    }
    




    public function saveMultipleNotifications($quant_rg) {
        $sql = new Sql();
        
        for ($i = 0; $i < $quant_rg; $i++) {
            $dataAtual = date("Y-m-d");
            $results = $sql->select("CALL sp_multiplenotification_save(
            :id_notificacao, 
            :dt_notificacao, 
            :patient, 
            :nome_pac, 
            :dt_nasc, 
            :atendimento, 
            :registro, 
            :dt_internamento, 
            :dt_oco, 
            :hr_oco, 
            :st_cante, 
            :st_cado, 
            :descricao, 
            :class_incident, 
            :class_occ, 
            :degree_damg, 
            :solution, 
            :patientsecurity, 
            :qclass_incident, 
            :qclass_occ, 
            :qdegree_damg, 
            :return_date, 
            :process,  
            :problem, 
            :fact_occurred, 
            :validation_date,
            :proposed_action,
            :eventinvestigation,
			:internacionalsecurity,
            :conclusion )", array(
           
            ":id_notificacao"=>$this->getid_notificacao(),
            ":dt_notificacao" => $dataAtual, 
            ":patient"=>$this->getpatient(),
            ":nome_pac"=>$this->getnome_pac(),
            ":dt_nasc"=>$this->getdt_nasc(),
            ":atendimento"=>$this->getatendimento(),
            ":registro"=>$this->getregistro(),
            ":dt_internamento"=>$this->getdt_internamento(),
            ":dt_oco"=>$this->getdt_oco(),
            ":hr_oco"=>$this->gethr_oco(),
            ":st_cante"=>$this->getst_cante(),
            ":st_cado"=>$this->getst_cado(),
            ":descricao"=>$this->getdescricao(),
            ":class_incident"=>$this->getclass_incident(),
            ":class_occ"=>$this->getclass_occ(),
            ":degree_damg"=>$this->getdegree_damg(),
            ":solution"=>$this->getsolution(),
            ":patientsecurity"=>$this->getpatientsecurity(),
            ":qclass_incident"=>$this->getqclass_incident(),
            ":qclass_occ"=>$this->getqclass_occ(),
            ":qdegree_damg"=>$this->getqdegree_damg(),
            ":return_date"=>$this->getreturn_date(),
            ":process"=>$this->getprocess(),
            ":problem"=>$this->getproblem(),
            ":fact_occurred"=>$this->getfact_occurred(),
            ":validation_date"=>$this->getvalidation_date(),
            ":proposed_action"=>$this->getproposed_action(),
            ":eventinvestigation"=>$this->geteventinvestigation(),
			":internacionalsecurity"=>$this->getinternacionalsecurity(),
            ":conclusion"=>$this->getconclusion()
            ));

            if ($i === 0) {
                $this->setData($results[0]);
            }
        }
    }
    
    //         // Salvar o resultado da primeira notificação
    //         if (!empty($results)) {
    //             $this->setData($results[0]);
    //         }
    //     }
    // }
    
    

    
    //  public function update() {
    //      $sql = new Sql();
        
    //      $results = $sql->select("UPDATE tb_notificacao SET id_notificacao = :id_notificacao, id_int = :id_int, class_occ = :class_occ, degree_damg = :degree_damg , analysis = :analysis, senddate = :senddate, deadline = :deadline WHERE id_notificacao = :id_notificacao", array(
            
    //          ":id_notificacao"=>$this->getid_notificacao(),
    //          ":id_int"=>$this->getid_int(),
    //          ":class_occ"=>$this->getclass_occ(),
    //          ":degree_damg"=>$this->getdegree_damg(),
    //          ":analysis"=>$this->getanalysis(),
    //          ":senddate"=>$this->getsenddate(),
    //          ":deadline"=>$this->getdeadline(),
            
    //      ));
     
        
    // }
    public function update() {
        $sql = new Sql();
       
        $results = $sql->select("CALL sp_notification_update (
            
            :id_notificacao, 
            :patient, 
            :nome_pac, 
            :dt_nasc, 
            :atendimento, 
            :registro, 
            :dt_internamento, 
            :dt_oco, 
            :hr_oco, 
            :st_cante, 
            :st_cado, 
            :descricao, 
            :class_incident, 
            :class_occ, 
            :degree_damg, 
            :solution, 
            :patientsecurity, 
            :qclass_incident, 
            :qclass_occ, 
            :qdegree_damg, 
            :return_date, 
            :process,  
            :problem, 
            :fact_occurred, 
            :validation_date,
            :proposed_action,
            :eventinvestigation,
			:internacionalsecurity,
            :conclusion )", array(
           
            ":id_notificacao"=>$this->getid_notificacao(),
            ":patient"=>$this->getpatient(),
            ":nome_pac"=>$this->getnome_pac(),
            ":dt_nasc"=>$this->getdt_nasc(),
            ":atendimento"=>$this->getatendimento(),
            ":registro"=>$this->getregistro(),
            ":dt_internamento"=>$this->getdt_internamento(),
            ":dt_oco"=>$this->getdt_oco(),
            ":hr_oco"=>$this->gethr_oco(),
            ":st_cante"=>$this->getst_cante(),
            ":st_cado"=>$this->getst_cado(),
            ":class_incident"=>$this->getclass_incident(),
            ":descricao"=>$this->getdescricao(),
            ":solution"=>$this->getsolution(),
            ":patientsecurity"=>$this->getpatientsecurity(),
            ":class_occ"=>$this->getclass_occ(),
            ":degree_damg"=>$this->getdegree_damg(),
            ":qclass_incident"=>$this->getqclass_incident(),
            ":qclass_occ"=>$this->getqclass_occ(),
            ":qdegree_damg"=>$this->getqdegree_damg(),
            ":return_date"=>$this->getreturn_date(),
            ":process"=>$this->getprocess(),
            ":problem"=>$this->getproblem(),
            ":fact_occurred"=>$this->getfact_occurred(),
            ":validation_date"=>$this->getvalidation_date(),
            ":proposed_action"=>$this->getproposed_action(),
            ":eventinvestigation"=>$this->geteventinvestigation(),
			":internacionalsecurity"=>$this->getinternacionalsecurity(),
            ":conclusion"=>$this->getconclusion()
  
        ));
        $this->setData($results[0]);
       
   }
    

  //  public function attachEmail($file) {
  //     $extension = explode('.', $file['name']);
  //     $extension = end($extension);
      
  //     $newName = $this->getid_notificacao().".".$extension;

  //     $dist = $_SERVER['DOCUMENT_ROOT']
  //        .DIRECTORY_SEPARATOR."res"
  //        .DIRECTORY_SEPARATOR."admin"
  //        .DIRECTORY_SEPARATOR."notification"
  //        .DIRECTORY_SEPARATOR;

  //     move_uploaded_file($file['tmp_name'], $dist.$newName);
  //     $this->attachEmail();
  //   }
  
  public function attachEmail($file) {
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = $this->getid_notificacao() . "." . $extension;

    // Define o caminho completo para o arquivo
    $fileUrl = $_SERVER['DOCUMENT_ROOT'] 
    . DIRECTORY_SEPARATOR . "res" 
    . DIRECTORY_SEPARATOR . "admin" 
    . DIRECTORY_SEPARATOR . "notification" 
    . DIRECTORY_SEPARATOR . $newName;

    // Move o arquivo para o diretório correto
    $dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "admin" . DIRECTORY_SEPARATOR . "notification" . DIRECTORY_SEPARATOR;
    move_uploaded_file($file['tmp_name'], $dist . $newName);
}


   public function get($id_notificacao) {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_notificacao WHERE id_notificacao = :id_notificacao", array(
       ":id_notificacao" => $id_notificacao
    ));
   
    $this->setData($results[0]);
   
 } 


 public function sendNotification() {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_notificacao ORDER BY id_notificacao DESC LIMIT 1");
    $data = $results[0];
    $mailer = new MailerNotification($data["id_notificacao"], $data["patient"], $data["nome_pac"], $data["dt_nasc"], $data["atendimento"], $data["registro"], $data["dt_internamento"], $data["dt_notificacao"], $data["dt_oco"], $data["hr_oco"], $data["st_cante"], $data["st_cado"], $data["class_incident"], $data["descricao"], $data["class_occ"], $data["degree_damg"], $data["solution"], "Notificação Shineray", "email", array(
        "id_notificacao" => $data["id_notificacao"],
        "patient" => $data["patient"],
        "nome_pac" => $data["nome_pac"],
        "dt_nasc" => $data["dt_nasc"],
        "atendimento" => $data["atendimento"],
        "registro" => $data["registro"],
        "dt_internamento" => $data["dt_internamento"],
        "dt_notificacao" => $data["dt_notificacao"],
        "dt_oco" => $data["dt_oco"],
        "hr_oco" => $data["hr_oco"],
        "st_cante" => $data["st_cante"],
        "st_cado" => $data["st_cado"],
        "class_incident" => $data["class_incident"],
        "descricao" => $data["descricao"],
        "class_occ" => $data["class_occ"],
        "degree_damg" => $data["degree_damg"],
        "solution" => $data["solution"]
    ));
    $mailer->send();
}


    // public function sendNotification() {
    //     $sql = new Sql();
    //     $results = $sql->select("SELECT * FROM tb_notificacao ORDER BY id_notificacao DESC LIMIT 1");
    //     $data = $results[0];
    //     $mailer = new MailerNotification($data["id_notificacao"], $data["id_int"], $data["nome_pac"],$data["dt_nasc"], $data["registro"], $data["dt_relato"], $data["dt_oco"], $data["st_cante"], $data["st_cado"], $data["descricao"], $data["solution"], "Notificação Shineray", "email", array(
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


    public static function getNotificToday(){

        $sql = new Sql();
        $results = $sql->select("SELECT count(*) FROM tb_notificacao WHERE DATE (dt_notificacao)= CURDATE() ORDER BY id_notificacao DESC");
        if (count($results) > 0) {
            return $results[0];
        }else{
            return[];
        }
    }

    public static function getNotificMonth(){

        $sql = new Sql();
        $results = $sql->select("SELECT count(*) FROM tb_notificacao WHERE MONTH(dt_notificacao) = MONTH(CURRENT_DATE()) AND YEAR(dt_notificacao) = YEAR(CURRENT_DATE()) ORDER BY id_notificacao DESC");
        if (count($results) > 0) {
            return $results[0];
        }else{
            return[];
        }
    }

    public static function getNotificYear() {
        $sql = new Sql();
        $results = $sql->select("SELECT count(*) FROM tb_notificacao WHERE YEAR(dt_notificacao) = YEAR(CURRENT_DATE()) ORDER BY id_notificacao DESC");
        if (count($results) > 0) {
            return $results[0];
        } else {
            return [];
        }
    }



    public static function getNotificTotals() {
        $sql = new Sql();
        $results = $sql->select("SELECT COUNT(*) as nrqtd FROM tb_notificacao");
        return $results[0];
           
    }

    // public static function getDateAtual() {
    //     $sql = new Sql();
    //     $results = $sql->select("SELECT DATE_FORMAT(NOW(),'%d-%m-%Y') as data");
    //     return $results[0];
           
    // }


    public static function getDateTimeAtual() {
        $sql = new Sql();
        $results = $sql->select("SELECT DATE_FORMAT(NOW(),'%d/%m/%Y %h:%m') as date");
        return $results[0];
           
    }


     public static function getDateAtual() {
         $sql = new Sql();
         $results = $sql->select("SELECT DATE_FORMAT(NOW(),'%d/%m/%Y') as date");
         return $results[0];
           
     }


    public static function getAnoAtual() {
        $sql = new Sql();
        $results = $sql->select("SELECT DATE_FORMAT(NOW(),'%y') as date");
        return $results[0];
           
    }
    public static function getNotificationskept2()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_notificacao where conclusion ='Mantida' AND YEAR(dt_notificacao) = YEAR(CURRENT_DATE) ORDER BY id_notificacao DESC");
    }

    public static function getNotificationskept()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_notificacao where conclusion ='Mantida' ORDER BY id_notificacao DESC");
    }

    public static function getNotificationsontime()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_notificacao where conclusion ='Mantida' and return_date < (SELECT DATE_FORMAT(NOW(),'%d/%m/%Y') as date) ORDER BY id_notificacao DESC");
    }
    
   
    
    public static function getNotificationsontimemonthprevious()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_notificacao 
        WHERE conclusion = 'Mantida' 
        AND DATE_FORMAT(dt_notificacao, '%Y-%m') = DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH), '%Y-%m')
        ORDER BY id_notificacao DESC");
    }


     //Total notification no class
     public static function getNotificationsnoclass()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM notification.tb_notificacao where conclusion is null or conclusion ='' ORDER BY id_notificacao DESC");
     }

      //Total notification class incomplet
      public static function getNotificationsclassincomplet()  {
        $sql = new Sql();
        return $sql->select("SELECT * FROM notification.tb_notificacao where 
        conclusion is null
        or conclusion = '' ORDER BY id_notificacao DESC");
     }

     //Total notification finalizados
    public static function getNotificationsfinished() {
        $sql = new Sql();
        return $sql->select("SELECT * FROM notification.tb_notificacao where conclusion = 'Encerrada' ORDER BY id_notificacao DESC");
     }


    
}