<?php

namespace Php\Model;

// use \Php\DB\SqlOracle; 
use \Php\DB\Sql; 
use \Php\Model;
use \Php\Model\User;

class Consult extends Model {
    
    const SESSION = "User";
    const ERROR = "UserError";
    const SUCCESS = "UserSucesss";

    //  private $lastCheckTime;
      private static $lastCheckCount;
    //  private $lastCheckMaxDate;
      private static $lastCheckMaxSequence;

      public function __construct() {
            self::$lastCheckMaxSequence = $this->retrieveLastCheckMaxSequenceFromDatabase();
        
    }


    public static function verifyAccess($requiredAccessLevel) {
        if (isset($_SESSION[User::SESSION]['inadmin']) && ($_SESSION[User::SESSION]['inadmin'] == $requiredAccessLevel)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public function checkForNewRecords() {
        // Verifica o acesso do usuário antes de continuar
        $hasAccessLevel0 = Consult::verifyAccess(0);
        $hasAccessLevel2 = Consult::verifyAccess(2);
        
        // Verifique se o usuário tem acesso de nível 0 ou 2
        if ($hasAccessLevel0 || $hasAccessLevel2) {
            $sqlCount =  "SELECT count(*) AS count FROM (          
        SELECT Z.VAL_PRM_CLN
        FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
        WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
        AND FA.COD_PAC=U.COD_PAC
        AND I.COD_FRM_CLN=U.COD_FRM_CLN
        AND P.COD_PRM = I.COD_PRM
        AND PRO.COD_PRO=U.COD_PRO
        AND Z.COD_FRM_CLN = U.COD_FRM_CLN
        AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
        AND I.FK_GPOFRM = W.PK_GPOFRM
        AND Z.COD_PRM = P.COD_PRM
        AND U.COD_FRM_CLN IN ('PTME')
        AND W.CO_GRUPO IN ('PMED')
        AND U.COD_PAC LIKE '%%'
        and u.cod_pro like '%%'
        AND Z.COD_PRM IN ('STAMED')
        AND U.DAT_AFERICAO = Z.DAT_AFERICAO
        AND Z.VAL_PRM_CLN = 'Em andamento'
        AND Z.VAL_PRM_CLN = (SELECT Z.VAL_PRM_CLN
        FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
        WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
        AND FA.COD_PAC=U.COD_PAC
        AND U.COD_PAC=Z.COD_PAC
        AND PRO.COD_PRO=U.COD_PRO
        AND Z.COD_FRM_CLN = U.COD_FRM_CLN
        AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
        AND I.FK_GPOFRM = W.PK_GPOFRM
        AND Z.COD_PRM = P.COD_PRM
        AND U.COD_FRM_CLN ='PTME' 
        AND W.CO_GRUPO ='PMED'
        AND U.COD_PAC LIKE '%%'
        and u.cod_pro like '%%'
        AND Z.COD_PRM = 'STAMED'
        AND U.DAT_AFERICAO = Z.DAT_AFERICAO
        AND U.DAT_AFERICAO = (SELECT MAX(Z.DAT_AFERICAO) FROM ITEM_MDL_AFERIDO Z
        WHERE Z.COD_FRM_CLN ='PTME') 
        AND Z.PK_ITMDAF = (SELECT MAX(Z.PK_ITMDAF) FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
        WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
        AND FA.COD_PAC=U.COD_PAC
        AND U.COD_PAC=Z.COD_PAC
        AND PRO.COD_PRO=U.COD_PRO
        AND Z.COD_FRM_CLN = U.COD_FRM_CLN
        AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
        AND I.FK_GPOFRM = W.PK_GPOFRM
        AND Z.COD_PRM = P.COD_PRM
        AND U.COD_FRM_CLN ='PTME' 
        AND W.CO_GRUPO ='PMED'
        AND U.COD_PAC LIKE '%%'
        and u.cod_pro like '%%'
        AND Z.COD_PRM = 'STAMED'
        AND U.DAT_AFERICAO = Z.DAT_AFERICAO
        AND U.DAT_AFERICAO = (SELECT MAX(Z.DAT_AFERICAO) FROM ITEM_MDL_AFERIDO Z
        WHERE Z.COD_FRM_CLN ='PTME')))
        AND U.DAT_AFERICAO BETWEEN CURRENT_TIMESTAMP -1.2 AND CURRENT_TIMESTAMP
        AND U.DAT_AFERICAO =  (SELECT MAX(Z.DAT_AFERICAO) FROM ITEM_MDL_AFERIDO Z
        WHERE Z.COD_FRM_CLN IN ('PTME')
        /*AND Z.COD_PAC = '%%' */)
        AND exists(select D.cod_grupo from faprocad b, FAUSUCAD c, FAUSUSIS d 
        where  c.matricula = d.matricula
        AND B.COD_PROFISSAO = C.COD_PROFISSAO
        and b.cod_pro = c.cod_pro
        and b.COD_CATEG in ('MEDU','MEDR','MEDL','MEDC','MEDA','FONO','COOR')
        AND b.cod_pro =(SELECT distinct(U.COD_PRO)
            FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
            WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
            AND FA.COD_PAC=U.COD_PAC
            AND U.COD_PAC=Z.COD_PAC
            AND PRO.COD_PRO=U.COD_PRO
            AND Z.COD_FRM_CLN = U.COD_FRM_CLN
            AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
            AND I.FK_GPOFRM = W.PK_GPOFRM
            AND Z.COD_PRM = P.COD_PRM
            AND U.COD_FRM_CLN ='PTME' 
            AND W.CO_GRUPO ='PMED'
            AND U.COD_PAC LIKE '%%'
            and u.cod_pro like '%%'
            AND Z.COD_PRM = 'STAMED'
            AND U.DAT_AFERICAO = Z.DAT_AFERICAO
            AND U.DAT_AFERICAO = (SELECT MAX(Z.DAT_AFERICAO) FROM ITEM_MDL_AFERIDO Z
            WHERE Z.COD_FRM_CLN ='PTME')
            AND Z.PK_ITMDAF = (SELECT MAX(Z.PK_ITMDAF) FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
            WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
            AND FA.COD_PAC=U.COD_PAC
            AND U.COD_PAC=Z.COD_PAC
            AND PRO.COD_PRO=U.COD_PRO
            AND Z.COD_FRM_CLN = U.COD_FRM_CLN
            AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
            AND I.FK_GPOFRM = W.PK_GPOFRM
            AND Z.COD_PRM = P.COD_PRM
            AND U.COD_FRM_CLN ='PTME' 
            AND W.CO_GRUPO ='PMED'
            AND U.COD_PAC LIKE '%%'
            and u.cod_pro like '%%'
            AND Z.COD_PRM = 'STAMED'
            AND U.DAT_AFERICAO = Z.DAT_AFERICAO
            AND U.DAT_AFERICAO = (SELECT MAX(Z.DAT_AFERICAO) FROM ITEM_MDL_AFERIDO Z
            WHERE Z.COD_FRM_CLN ='PTME'))))
     )";
         
         
             $sqlDate = "SELECT TO_CHAR(MAX(U.DAT_AFERICAO), 'DD/MM/YYYY HH24:MI:SS') AS MAX_DAT
            FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i 
            LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
            WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
            AND FA.COD_PAC=U.COD_PAC
            AND U.COD_PAC=Z.COD_PAC
            AND PRO.COD_PRO=U.COD_PRO
            AND Z.COD_FRM_CLN = U.COD_FRM_CLN
            AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
            AND I.FK_GPOFRM = W.PK_GPOFRM
            AND Z.COD_PRM = P.COD_PRM
            AND U.COD_FRM_CLN ='PTME' 
            AND W.CO_GRUPO ='PMED'
            AND U.COD_PAC LIKE '%%'
            AND u.cod_pro like '%%'
            AND Z.COD_PRM = 'STAMED'
            AND U.DAT_AFERICAO = Z.DAT_AFERICAO
            AND U.DAT_AFERICAO = (
                SELECT MAX(Z.DAT_AFERICAO) 
                FROM ITEM_MDL_AFERIDO Z
                WHERE Z.COD_FRM_CLN ='PTME')";
               
               $sqlSeq = "SELECT MAX(Z.PK_ITMDAF) AS MAX_SEQ
               FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i 
               LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
               WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
               AND FA.COD_PAC=U.COD_PAC
               AND U.COD_PAC=Z.COD_PAC
               AND PRO.COD_PRO=U.COD_PRO
               AND Z.COD_FRM_CLN = U.COD_FRM_CLN
               AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
               AND I.FK_GPOFRM = W.PK_GPOFRM
               AND Z.COD_PRM = P.COD_PRM
               AND U.COD_FRM_CLN ='PTME' 
               AND W.CO_GRUPO ='PMED'
               AND U.COD_PAC LIKE '%%'
               AND u.cod_pro like '%%'
               AND Z.COD_PRM = 'STAMED'
               AND U.DAT_AFERICAO = Z.DAT_AFERICAO
               AND U.DAT_AFERICAO = (
                   SELECT MAX(Z.DAT_AFERICAO) 
                   FROM ITEM_MDL_AFERIDO Z
                   WHERE Z.COD_FRM_CLN ='PTME'
               )";
            

            $sqlOracle = new SqlOracle();
            $resultCount = $sqlOracle->select($sqlCount);
            $resultSeq = $sqlOracle->select($sqlSeq);
            // $resultDate = $sqlOracle->select($sqlDate);

            if ($resultCount[0]['COUNT'] > 0 && $resultSeq[0]['MAX_SEQ'] != self::$lastCheckMaxSequence) {
                self::$lastCheckMaxSequence = $resultSeq[0]['MAX_SEQ'];
                self::saveLastCheckMaxSequenceToDatabase(self::$lastCheckMaxSequence);
                $maxsequence =self::$lastCheckMaxSequence;
                return array(
                    'success' => true,
                    'max_sequence' => self::$lastCheckMaxSequence,
                    'maxsequence' =>  $maxsequence,
                    'resultseq' => $resultSeq[0]['MAX_SEQ'],
                    'resultCount'=>$resultCount
                );
             
            }
          }
    
            return false;
        }
    





        public function retrieveLastCheckMaxSequenceFromDatabase() {
            $sql = new Sql();
            $query = "SELECT max_seqptm FROM tb_alert WHERE id = 1";
            $result = $sql->select($query);
            if ($result && isset($result[0]['max_seqptm'])) {
                return $result[0]['max_seqptm'];
            } else {
                return 0; 
            }
        }
        
        private static function saveLastCheckMaxSequenceToDatabase($value) {
            $sql = new Sql();
            $query = "UPDATE tb_alert SET max_seqptm = :value WHERE id = 1";
            $params = array(':value' => $value);
            $sql->query($query, $params);
        }
      
    




        public static function checkMaxSequenceOracle() {
            $SqlOracle = new SqlOracle(); 
            $query= "SELECT MAX(Z.PK_ITMDAF) AS MAX_SEQ
            FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i 
            LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
            WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
            AND FA.COD_PAC=U.COD_PAC
            AND U.COD_PAC=Z.COD_PAC
            AND PRO.COD_PRO=U.COD_PRO
            AND Z.COD_FRM_CLN = U.COD_FRM_CLN
            AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
            AND I.FK_GPOFRM = W.PK_GPOFRM
            AND Z.COD_PRM = P.COD_PRM
            AND U.COD_FRM_CLN ='PTME' 
            AND W.CO_GRUPO ='PMED'
            AND U.COD_PAC LIKE '%%'
            AND u.cod_pro like '%%'
            AND Z.COD_PRM = 'STAMED'
            AND U.DAT_AFERICAO = Z.DAT_AFERICAO
            AND U.DAT_AFERICAO = (
                SELECT MAX(Z.DAT_AFERICAO) 
                FROM ITEM_MDL_AFERIDO Z
                WHERE Z.COD_FRM_CLN ='PTME'
            )";
            $result = $SqlOracle->select($query);
            if ($result && isset($result[0]['MAX_SEQ'])) {
                return $result[0]['MAX_SEQ'];
            } else {
                return 0; 
            }

        }
        
        public static function infoMedPTMOracle() {
            $SqlOracle = new SqlOracle(); 
            $query= "SELECT 'Prontuário: '||fa.cod_prt||'-  Nome do paciente:  '|| FA.NOME_SEGU ||' - Data e hora:  '||  to_char((U.DAT_AFERICAO),'DD/MM/YYYY HH24:MI:SS') 
            FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
            WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
            AND FA.COD_PAC=U.COD_PAC
            AND U.COD_PAC=Z.COD_PAC
            AND PRO.COD_PRO=U.COD_PRO
            AND Z.COD_FRM_CLN = U.COD_FRM_CLN 
            AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
            AND I.FK_GPOFRM = W.PK_GPOFRM
            AND Z.COD_PRM = P.COD_PRM
            AND U.COD_FRM_CLN ='PTME' 
            AND W.CO_GRUPO ='PMED'
            AND U.COD_PAC LIKE '%%'
            and u.cod_pro like '%%'
            AND Z.COD_PRM = 'STAMED'
            AND U.DAT_AFERICAO = Z.DAT_AFERICAO
            AND U.DAT_AFERICAO = (SELECT MAX(Z.DAT_AFERICAO) FROM ITEM_MDL_AFERIDO Z
            WHERE Z.COD_FRM_CLN ='PTME')AND Z.PK_ITMDAF = (SELECT MAX(Z.PK_ITMDAF) FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
            WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
            AND FA.COD_PAC=U.COD_PAC
            AND U.COD_PAC=Z.COD_PAC
            AND PRO.COD_PRO=U.COD_PRO
            AND Z.COD_FRM_CLN = U.COD_FRM_CLN
            AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
            AND I.FK_GPOFRM = W.PK_GPOFRM
            AND Z.COD_PRM = P.COD_PRM
            AND U.COD_FRM_CLN ='PTME' 
            AND W.CO_GRUPO ='PMED'
            AND U.COD_PAC LIKE '%%'
            and u.cod_pro like '%%'
            AND Z.COD_PRM = 'STAMED'
            AND U.DAT_AFERICAO = Z.DAT_AFERICAO
            AND U.DAT_AFERICAO = (SELECT MAX(Z.DAT_AFERICAO) FROM ITEM_MDL_AFERIDO Z
            WHERE Z.COD_FRM_CLN ='PTME'))";
            $result = $SqlOracle->select($query);
            if ($result && isset($result[0]['MAX_SEQ'])) {
                return $result[0]['MAX_SEQ'];
            } else {
                return 0; 
            }

        }
        

        



        // private function updateLastCheckTime() {
        //     $this->lastCheckTime = time(); 
        // }


        // if ($resultCount && $resultSeq && isset($resultCount[0]['COUNT'])  && isset($resultSeq[0]['MAX_SEQ'])) {
        //     // Verifique se há novos registros e se as informações são diferentes das últimas consultas
        //     if ($resultCount[0]['COUNT'] > 0 &&
        //         ($resultCount[0]['COUNT'] != $this->lastCheckCount ||
        //         $resultSeq[0]['MAX_SEQ'] != $this->lastCheckMaxSequence)) {
        //         // Novos registros encontrados ou valores diferentes, atualize os valores da última consulta
        //         $this->lastCheckCount = $resultCount[0]['COUNT'];
        //         $this->lastCheckMaxSequence = $resultSeq[0]['MAX_SEQ'];
        //         return true;
        //     }






        public static function getalertt1() {
         
            $hasAccessLevel0 = Consult::verifyAccess(0);
            return $hasAccessLevel0 ;
            
        }
        

        public static function getMaxdataPTMinserido() {
            $SqlOracle = new SqlOracle(); 
            return $SqlOracle->select("SELECT TO_CHAR(MAX(U.DAT_AFERICAO), 'DD/MM/YYYY HH24:MI:SS') AS MAX_DAT
            FROM FAPROCAD PRO, FAPACCAD FA, MODELO_AFERIDO U, ITEM_MDL_AFERIDO Z, TB_GRUPO_FRM W, item_mdl_frm_cln i 
            LEFT JOIN parametro_clinico p ON i.cod_prm = p.cod_prm
            WHERE I.COD_FRM_CLN = U.COD_FRM_CLN
            AND FA.COD_PAC=U.COD_PAC
            AND U.COD_PAC=Z.COD_PAC
            AND PRO.COD_PRO=U.COD_PRO
            AND Z.COD_FRM_CLN = U.COD_FRM_CLN
            AND W.FK_COD_FRM_CLN = U.COD_FRM_CLN
            AND I.FK_GPOFRM = W.PK_GPOFRM
            AND Z.COD_PRM = P.COD_PRM
            AND U.COD_FRM_CLN ='PTME' 
            AND W.CO_GRUPO ='PMED'
            AND U.COD_PAC LIKE '%%'
            AND u.cod_pro like '%%'
            AND Z.COD_PRM = 'STAMED'
            AND U.DAT_AFERICAO = Z.DAT_AFERICAO
            AND U.DAT_AFERICAO = (
                SELECT MAX(Z.DAT_AFERICAO) 
                FROM ITEM_MDL_AFERIDO Z
                WHERE Z.COD_FRM_CLN ='PTME')
             ");
        }
        






}















?>
