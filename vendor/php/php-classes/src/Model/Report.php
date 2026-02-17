<?php

namespace Php\Model;

use \Php\DB\Sql;
use \Php\Model;

class Report extends Model {
  
    // public static function getStatusNotificationsByMonth() {
    //     $sql = new Sql();
    //     return $sql->select("
    //         SELECT 
    //             MONTH(dt_notificacao) AS mes,
    //             st_cante,
    //             COUNT(*) AS total_por_status
    //         FROM 
    //             tb_notificacao
    //         GROUP BY 
    //             MONTH(dt_notificacao), st_cante;
    //     ");
    // }

     
     //St_cado

    //Concluded month cado
    public static function getStatusNotificationsByMonthCadoConcluded($month, $year, $names) {
      $sql = new Sql();
      return $sql->select(" 
      SELECT 
        MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) AS Ano, 
        (st_cado) Setor, (conclusion) AS Conclusão,
        COUNT(*) AS Total
    FROM 
        tb_notificacao
    WHERE
        MONTH(dt_notificacao) = :month
        AND YEAR(dt_notificacao) = :year
        AND st_cado = :names
        AND conclusion = 'Encerrada'
        AND eventinvestigation = 'Sim'
    GROUP BY 
        MONTH(dt_notificacao), st_cado;", [
              ':month' => $month,
              ':year' => $year,
              ':names' => $names
          ]);
      }

      //Late month cado
      public static function getStatusNotificationsByMonthCadoLate($month, $year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) AS Ano, 
          (st_cado) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          MONTH(dt_notificacao) = :month
          AND YEAR(dt_notificacao) = :year
          AND st_cado = :names
          AND conclusion = 'Mantida'
          AND eventinvestigation = 'Sim'
          AND return_date < (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          MONTH(dt_notificacao), st_cado;", [
                ':month' => $month,
                ':year' => $year,
                ':names' => $names
            ]);
        }

         //Ontime month cado
      public static function getStatusNotificationsByMonthCadoOntime($month, $year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) AS Ano, 
          (st_cado) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          MONTH(dt_notificacao) = :month
          AND YEAR(dt_notificacao) = :year
          AND st_cado = :names
          AND conclusion = 'Mantida'
          AND eventinvestigation = 'Sim'
          AND return_date >= (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          MONTH(dt_notificacao), st_cado;", [
                ':month' => $month,
                ':year' => $year,
                ':names' => $names
            ]);
           
        }



  
    //Concluded year cado Concluded
    public static function getStatusNotificationsByYearCadoConcluded($year, $names) {
      $sql = new Sql();
      return $sql->select(" 
      SELECT 
        YEAR(dt_notificacao) AS Ano, 
        (st_cado) Setor, (conclusion) AS Conclusão,
        COUNT(*) AS Total
    FROM 
        tb_notificacao
    WHERE
        YEAR(dt_notificacao) = :year
        AND st_cado = :names
        AND conclusion = 'Encerrada'
        AND eventinvestigation = 'Sim'
    GROUP BY 
         st_cado;", [
              ':year' => $year,
              ':names' => $names
          ]);
      }

      //Late year cado Late
      public static function getStatusNotificationsByYearCadoLate($year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          YEAR(dt_notificacao) AS Ano, 
          (st_cado) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          YEAR(dt_notificacao) = :year
          AND st_cado = :names
          AND conclusion = 'Mantida' 
          AND eventinvestigation = 'Sim'
          AND return_date < (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          st_cado;", [
                ':year' => $year,
                ':names' => $names
            ]);
        }

         //Ontime year cado ontime
      public static function getStatusNotificationsByYearCadoOntime($year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          YEAR(dt_notificacao) AS Ano, 
          (st_cado) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          YEAR(dt_notificacao) = :year
          AND st_cado = :names
          AND conclusion != 'Encerrada'
          AND eventinvestigation = 'Sim'
          AND return_date >= (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          st_cado;", [
                ':year' => $year,
                ':names' => $names
            ]);
        }

//-----------------------x---------------------
        //St_cante

        //Concluded month cante
    public static function getStatusNotificationsByMonthCanteConcluded($month, $year, $names) {
      $sql = new Sql();
      return $sql->select(" 
      SELECT 
        MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) AS Ano, 
        (st_cante) Setor, (conclusion) AS Conclusão,
        COUNT(*) AS Total
    FROM 
        tb_notificacao
    WHERE
        MONTH(dt_notificacao) = :month
        AND YEAR(dt_notificacao) = :year
        AND st_cante = :names
        AND conclusion = 'Encerrada'
        AND eventinvestigation = 'Sim'
    GROUP BY 
        MONTH(dt_notificacao), st_cante;", [
              ':month' => $month,
              ':year' => $year,
              ':names' => $names
          ]);
      }

      //Late month cante 
      public static function getStatusNotificationsByMonthCanteLate($month, $year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) AS Ano, 
          (st_cante) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          MONTH(dt_notificacao) = :month
          AND YEAR(dt_notificacao) = :year
          AND st_cante = :names
          AND conclusion = 'Mantida'
          AND eventinvestigation = 'Sim'
          AND return_date < (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          MONTH(dt_notificacao), st_cante;", [
                ':month' => $month,
                ':year' => $year,
                ':names' => $names
            ]);
        }

      //Ontime month cante 
      public static function getStatusNotificationsByMonthCanteOntime($month, $year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) AS Ano, 
          (st_cante) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          MONTH(dt_notificacao) = :month
          AND YEAR(dt_notificacao) = :year
          AND st_cante = :names
          AND conclusion = 'Mantida'
          AND eventinvestigation = 'Sim'
          AND return_date >= (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          MONTH(dt_notificacao), st_cante;", [
                ':month' => $month,
                ':year' => $year,
                ':names' => $names
            ]);
           
        }



  
    //Concluded year cante
    public static function getStatusNotificationsByYearCanteConcluded($year, $names) {
      $sql = new Sql();
      return $sql->select(" 
      SELECT 
        YEAR(dt_notificacao) AS Ano, 
        (st_cante) Setor, (conclusion) AS Conclusão,
        COUNT(*) AS Total
    FROM 
        tb_notificacao
    WHERE
        YEAR(dt_notificacao) = :year
        AND st_cante = :names
        AND conclusion = 'Encerrada'
        AND eventinvestigation = 'Sim'
    GROUP BY 
         st_cante;", [
              ':year' => $year,
              ':names' => $names
          ]);
      }

      //Late year cante Late
      public static function getStatusNotificationsByYearCanteLate($year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          YEAR(dt_notificacao) AS Ano, 
          (st_cante) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          YEAR(dt_notificacao) = :year
          AND st_cante = :names
          AND conclusion = 'Mantida' 
          AND eventinvestigation = 'Sim'
          AND return_date < (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          st_cante;", [
                ':year' => $year,
                ':names' => $names
            ]);
        }

         //Ontime year cante ontime
      public static function getStatusNotificationsByYearCanteOntime($year, $names) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          YEAR(dt_notificacao) AS Ano, 
          (st_cante) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          YEAR(dt_notificacao) = :year
          AND st_cante = :names
          AND conclusion != 'Encerrada'
          AND eventinvestigation = 'Sim'
          AND return_date >= (SELECT DATE_FORMAT(CURDATE(),'%d/%m/%Y') as date)
      GROUP BY 
          st_cante;", [
                ':year' => $year,
                ':names' => $names
            ]);
        }
//--------------------------------------------X---------------------------------
//Total de notification for month

        //Total Jan
        public static function getStatusNotificationsTotalCanteJan($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Jan
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '01'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Fev
        public static function getStatusNotificationsTotalCanteFev($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Fev
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '02'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Mar
        public static function getStatusNotificationsTotalCanteMar($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Mar
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '03'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Abr
        public static function getStatusNotificationsTotalCanteAbr($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Abr
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '04'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Mai
        public static function getStatusNotificationsTotalCanteMai($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Mai
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '05'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Jun
        public static function getStatusNotificationsTotalCanteJun($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Jun
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '06'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Jul
        public static function getStatusNotificationsTotalCanteJul($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Jul
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '07'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Ago
        public static function getStatusNotificationsTotalCanteAgo($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Ago
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '08'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Set
        public static function getStatusNotificationsTotalCanteSet($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Setem
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '09'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Out
        public static function getStatusNotificationsTotalCanteOut($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Outub
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '10'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Nov
        public static function getStatusNotificationsTotalCanteNov($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Nov
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '11'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }

          //Total Dev
        public static function getStatusNotificationsTotalCanteDez($year, $names) {
          $sql = new Sql();
          return $sql->select(" 
          SELECT 
            COUNT(*) AS Dez
        FROM 
            tb_notificacao
        WHERE
            YEAR(dt_notificacao) = :year
            AND st_cante = :names
            AND MONTH(dt_notificacao) = '12'
        GROUP BY 
            st_cante;", [
                  ':year' => $year,
                  ':names' => $names
              ]);
          }


//--------------------------------X-------------------------------------

















    public static function getStatusNotificationsByYearCadoConcluidoOLD($month, $year, $st_cado) {
      $sql = new Sql();
      return $sql->select(" 
      SELECT 
        YEAR(dt_notificacao) AS Ano, 
        (st_cado) Setor, (conclusion) AS Conclusão,
        COUNT(*) AS Total
    FROM 
        tb_notificacao
    WHERE
        YEAR(dt_notificacao) = :year
        AND st_cado = :st_cado
        AND conclusion = 'Encerrada'
    GROUP BY 
        MONTH(dt_notificacao), st_cado;", [
              ':month' => $month,
              ':year' => $year,
              ':st_cado' => $st_cado
          ]);
      }
    
      public static function getStatusNotificationsByMonthCanteConcluidoOLD($month, $year, $st_cante) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) AS Ano, 
          (st_cante) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          MONTH(dt_notificacao) = :month
          AND YEAR(dt_notificacao) = :year
          AND st_cante = :st_cante
          AND conclusion = 'Encerrada'
      GROUP BY 
          MONTH(dt_notificacao), st_cante;", [
                ':month' => $month,
                ':year' => $year,
                ':st_cante' => $st_cante
            ]);
        }
  
      public static function getStatusNotificationsByYearCanteConcluidoOLD($month, $year, $st_cante) {
        $sql = new Sql();
        return $sql->select(" 
        SELECT 
          YEAR(dt_notificacao) AS Ano, 
          (st_cante) Setor, (conclusion) AS Conclusão,
          COUNT(*) AS Total
      FROM 
          tb_notificacao
      WHERE
          YEAR(dt_notificacao) = :year
          AND st_cante = :st_cante
          AND conclusion = 'Encerrada'
      GROUP BY 
          MONTH(dt_notificacao), st_cante;", [
                ':month' => $month,
                ':year' => $year,
                ':st_cante' => $st_cante
            ]);
        }
      
   

    public static function getStatusNotificationsByMonthCanteOLD($month, $year, $st_cante) {
      $sql = new Sql();
      return $sql->select("
          SELECT 
              MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) As Ano,
              (st_cante) AS Setor,
              COUNT(*) AS Total
          FROM 
              tb_notificacao
          WHERE
              MONTH(dt_notificacao) = :month
              AND YEAR(dt_notificacao) = :year
              AND st_cante = :st_cante
          GROUP BY 
              MONTH(dt_notificacao), st_cante;
      ", [
          ':month' => $month,
          ':year' => $year,
          ':st_cante' => $st_cante
      ]);
  }

  public static function getStatusNotificationsByMonthCadoOLD($month, $year, $st_cado) {
    $sql = new Sql();
    return $sql->select("
        SELECT 
            MONTH(dt_notificacao) AS Mes, YEAR(dt_notificacao) As Ano,
            (st_cado) AS Setor,
            COUNT(*) AS Total
        FROM 
            tb_notificacao
        WHERE
            MONTH(dt_notificacao) = :month
            AND YEAR(dt_notificacao) = :year
            AND st_cado = :st_cado
        GROUP BY 
            MONTH(dt_notificacao), st_cado;
    ", [
        ':month' => $month,
        ':year' => $year,
        ':st_cado' => $st_cado
    ]);
}
  


  

    public static function getStatusNotificationsByYear() {
        $sql = new Sql();
        return $sql->select("
            SELECT 
                YEAR(dt_notificacao) AS ano,
                st_cante,
                COUNT(*) AS total_por_status
            FROM 
                tb_notificacao
            GROUP BY 
                YEAR(dt_notificacao), st_cante;
        ");
    }

    public static function getNotificationsByMonth() {
        $sql = new Sql();
        return $sql->select("
            SELECT 
                MONTH(dt_notificacao) AS mes,
                COUNT(*) AS total_por_mes
            FROM 
                tb_notificacao
            GROUP BY 
                MONTH(dt_notificacao);
        ");
    }




  public static function listAll()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_reports");
  }

  public static function lastReport()
  {
    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_reports ORDER BY id_report DESC LIMIT 1");
  }

  public static function lastReportId()
  {
    $sql = new Sql();
    return $sql->select("SELECT id_report FROM tb_reports ORDER BY id_report DESC LIMIT 1");
  }



   public function save(){
     $reportTitle = $this->getname_report();
     $slugTitle = $this->slugify($reportTitle);
     $sql = new Sql();
     $results = $sql->select("CALL sp_reports_save(:id_report, :name_report, :descripition_report, :url_slug, :id_user)", array(
      ":id_report" => $this->getid_report(),
       ":name_report"=>$this->getname_report(),
       ":descripition_report"=>$this->getdescription_report(),
       ":url_slug"=>$slugTitle,
       ":id_user"=>$this->getid_user()

      ));
         $this->setData($results[0]);
    }

  // public function saves()
  // {
  //   $reportTitle = $this->getname_report();
  //   $slugTitle = $this->slugify($reportTitle);

  //   $sql = new Sql();
  //   $results = $sql->select("CALL sp_reports_save(:id_report, :name_report, :description_report, :url_slug, :id_user)", [
  //     ":id_report" => $this->getid_report(),
  //     ":name_report" => $this->getname_report(),
  //     ":description_report" => $this->getdescription_report(),
  //     ":url_slug" => $slugTitle,
  //     ":id_user" => $this->getid_user()
  //   ]);
  //   $this->setData($results[0]);
  // }

  public function getSixPhotos()
  {
    $sql = new Sql();
    $resultsExistPhotos = $sql->select("SELECT * FROM tb_photos WHERE id_report = :id_report LIMIT 6", [":id_report" => $this->getid_report()]);

    $countResultsPhotos = count($resultsExistPhotos);

    if ($countResultsPhotos > 0) {
      foreach ($resultsExistPhotos as &$result) {
        foreach ($result as $key => $value) {
          if ($key === "name_photo") {
            $result["desphoto"] = "/res/site/img/reports/" . $result["name_photo"];
          }
        }
      }
      return $resultsExistPhotos;
    }
  }

  public static function checkList($list)
  {
    foreach ($list as &$row) {
      $p = new Report();
      $p->setData($row);
      $row =  $p->getValues();
    }
    return $list;
  }

  // public function save_old() {
  //   $reportTitle = $this->getname_report();
  //   $slugTitle = $this->slugify($reportTitle);
  //   $sql = new Sql();
  //   $results = $sql->select("CALL sp_reports_save(:name_report, :description_report, :url_slug, :id_user)", array(
  //     ":name_report"=>$this->getname_report(),
  //     ":description_report"=>$this->getdescription_report(),
  //     ":url_slug"=>$slugTitle,
  //     ":id_user"=>$this->getid_user()
  //   ));

  //   $this -> setData($results[0]);
  // }


  public function update()
  {
    $reportTitle = $this->getname_report();
    $slugTitle = $this->slugify($reportTitle);

    $sql = new Sql();
    $results = $sql->select("CALL sp_reportsupdate_save(:id_report, :name_report, :description_report, :url_slug, :id_user)", array(
      ":id_report" => $this->getid_report(),
      ":name_report" => $this->getname_report(),
      ":description_report" => $this->getdescription_report(),
      ":url_slug" => $slugTitle,
      ":id_user" => $this->getid_user()
    ));

    $this->setData($results[0]);
  }


  public function slugify($text)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }

  public function get($id_report)
  {
    $sql = new Sql();
    $results = $sql->select("SELECT * FROM tb_reports WHERE id_report = :id_report", [
      "id_report" => $id_report
    ]);
    $this->setData($results[0]);
  }

  public function delete()
  {
    $sql = new Sql();
    $sql->query("DELETE FROM tb_reports WHERE id_report = :id_report", [
      ":id_report" => $this->getid_report()
    ]);
  }

  public function getValues()
  {
    $this->checkPhoto();
    $values = parent::getValues();
    return $values;
  }

  public function setPhotos($files, $id_report)
  {

    $files = $_FILES["files"];
    $numFile = count(array_filter($files["name"]));

    if ($numFile > 0) {
      $sql = new Sql();
      $resultsExistPhotos = $sql->select("SELECT * FROM tb_photos WHERE id_report = :id_report", [
        ":id_report" => $id_report
      ]);

      $timeStampNow = time();
      $countResultsPhotos = count($resultsExistPhotos);

      for ($i = 0; $i < $countResultsPhotos; $i++) {
        if ($timeStampNow > $resultsExistPhotos[$i]["dt_photo"]) {
          $filename = $_SERVER["DOCUMENT_ROOT"] .
            DIRECTORY_SEPARATOR . "res" .
            DIRECTORY_SEPARATOR . "site" .
            DIRECTORY_SEPARATOR . "img" .
            DIRECTORY_SEPARATOR . "reports" .
            DIRECTORY_SEPARATOR . $resultsExistPhotos[$i]["id_report"] . "-" .
            $resultsExistPhotos[$i]["id_photo"] . ".jpg";

          $resultsDeletedPhotos = $sql->query("DELETE FROM tb_photos WHERE id_report = :id_report", [
            "id_report" => $resultsExistPhotos[$i]["id_report"]
          ]);
        }
      }


      for ($i = 0; $i <= $numFile; $i++) {
        if (isset($files["name"][$i])) {
          $name = $files["name"][$i];

          $extension = explode(".", $name);
          $extension = end($extension);

          switch ($extension) {
            case 'jpg':
            case 'jpeg':
              $image = imagecreatefromjpeg($files["tmp_name"][$i]);
              break;

            case 'gif':
              $image = imagecreatefromgif($files["tmp_name"][$i]);
              break;

            case 'png':
              $image = imagecreatefrompng($files["tmp_name"][$i]);
              break;
          }

          $countImg = $i + 1;
          $namePhoto = $this->getid_report() . "-" . $countImg . ".jpg";

          $dist = $_SERVER["DOCUMENT_ROOT"].
            DIRECTORY_SEPARATOR . "res" .
            DIRECTORY_SEPARATOR . "site" .
            DIRECTORY_SEPARATOR . "img" .
            DIRECTORY_SEPARATOR . "reports" .
            DIRECTORY_SEPARATOR . $namePhoto;

          imagejpeg($image, $dist);
          imagedestroy($image);

          $sql->query("INSERT INTO tb_photos (id_photo, name_photo, id_report) VALUES (:id_photo, :name_photo, :id_report)", [
            ":id_photo" => $this->getid_photo(),
            ":name_photo" => $namePhoto,
            ":id_report" => $this->getid_report()
          ]);

          $this->getPhotos();
        }
      }
    }
  }

  public function getPhotos()
  {
    $sql = new Sql();
    $resultsExistPhotos = $sql->select("SELECT * FROM tb_photos WHERE id_report = :id_report", [
      ":id_report" => $this->getid_report()
    ]);

    $countResultsPhotos = count($resultsExistPhotos);

    if ($countResultsPhotos > 0) {
      foreach ($resultsExistPhotos as &$result) {
        foreach ($result as $key => $value) {
          if ($key === "name_photo") {
            $result["desphoto"] = "/res/site/img/reports/" . $result["name_photo"];
          }
        }
      }

      return $resultsExistPhotos;
    }
  }

  public function getFirstPhoto()
  {
    return $url = "/res/site/img/reports" . $this->getid_report() . "-" . 1 . ".jpg";
  }

  public function getReportsPage($page = 1, $itemsPerPage = 12)
  {
    $start = ($page - 1) * $itemsPerPage;
    $sql = new Sql();
    $results = $sql->select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_reports ORDER BY id_report DESC LIMIT $start, $itemsPerPage");
    $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");
    return [
      'data' => Report::checkList($results),
      'total' => (int)$resultTotal[0]["nrtotal"],
      'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage),
    ];
  }

  public function getFromURL($id_report, $url_slug)
  {
    $sql = new Sql();
    $rows = $sql->select("SELECT * FROM tb_reports WHERE id_report = :id_report AND url_slug = :url_slug", [
      ':id_report' => $id_report,
      ':url_slug' => $url_slug
    ]);
    if (count($rows) > 0) {
      return $this->setData($rows[0]);
    } else {
      header("Location: /reports");
      exit;
    }
  }
}
