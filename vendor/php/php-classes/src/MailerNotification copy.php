<?php

namespace Php;

use Rain\Tpl;
use Php\Model\Notificacao;


class MailerNotification {
    
   const USERNAME = "cleciope2@gmail.com";
   const PASSWORD = "clecio2375";
   const NAME_FROM = "Notificação Shineray";

   private $mail;


   public function __construct($id_notificacao, $patient, $dt_notificacao, $nome_pac, $dt_nasc, $atendimento, $registro, $dt_internamento,  $dt_oco, $hr_oco, $st_cante, $st_cado, $class_incident, $descricao, $class_occ, $degree_damg, $solution, $subject, $tplName, $data = []) {
      $config = array(
         "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/emailnotification/",
         "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
         "debug"         => false // set to false to improve the speed
      );

      Tpl::configure( $config );
      $tpl = new Tpl;
      foreach ($data as $key => $value) {
         $tpl->assign($key, $value);
      }
      $html = $tpl->draw($tplName, true);
      //Create a new PHPMailer instance
      $this->mail = new \PHPMailer;
      //Tell PHPMailer to use SMTP
      $this->mail->isSMTP();
      //Enable SMTP debugging
      // 0 = off (for production use)
      // 1 = client messages
      // 2 = client and server messages
      $this->mail->SMTPDebug = 2;
      //Ask for HTML-friendly debug output
      $this->mail->Debugoutput = 'html';
      //Set the hostname of the mail server
      $this->mail->Host = 'smtp.shineray.com.br';
      // use
      // $this->mail->Host = gethostbyname('smtp.gmail.com');
      // if your network does not support SMTP over IPv6
      //Set the SMTP port number - 465 for authenticated TLS, a.k.a. RFC4409 SMTP submission
      $this->mail->Port = 25;
      //Set the encryption system to use - ssl (deprecated) or tls
      $this->mail->SMTPSecure = 'tls';
      $this->mail->SMTPOptions = array(
         'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
         )
      );

      //Whether to use SMTP authentication
      $this->mail->SMTPAuth = true;
      //Username to use for SMTP authentication - use full email address for gmail
      $this->mail->Username = MailerNotification::USERNAME;
      //Password to use for SMTP authentication
      $this->mail->Password = MailerNotification::PASSWORD;
      //Set who the message is to be sent from
      $this->mail->setFrom(MailerNotification::USERNAME, MailerNotification::NAME_FROM);
      //Set an alternative reply-to address
      //$this->mail->addReplyTo('replyto@example.com', 'First Last');
      //Set who the message is to be sent to
      $this->mail->addAddress('cpd@shineray.com.br', 'Notificação');
      //Set the subject line
      $this->mail->Subject = $subject;
      //Read an HTML message body from an external file, convert referenced images to embedded,
      //convert HTML into a basic plain-text alternative body
      $this->mail->msgHTML($html);
      //Replace the plain text body with one created manually
      $this->mail->AltBody = 'Foi realizada uma nova Notificação.';

	   $this->mail->CharSet = 'UTF-8';

      $fileTypes = ['jpg', 'jpeg', 'png', 'pdf', 'rar', 'zip'];
      $fileUrl = '';
      foreach ($fileTypes as $fileType) {
          $filePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "admin" . DIRECTORY_SEPARATOR . "notification" . DIRECTORY_SEPARATOR . $id_notificacao . "." . $fileType;
          if (file_exists($filePath)) {
              $fileUrl = $filePath;
              break;
          }
      }
      
  // Se o arquivo existir, anexe-o ao e-mail
  if (!empty($fileUrl) && file_exists($fileUrl)) {
   $this->mail->addAttachment($fileUrl);
}
  }

public function send() {
   return $this->mail->send();
}

}
















         // Attachments
         //  $this->mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
         //  $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

   //      //Attach an image file
   //      $this->mail->addAttachment('images/phpmailer_mini.png');
   //      //send the message, check for errors

//    if (file_exists($_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".jpg")
//         ) {
//         $fileUrl = $_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".jpg";
//      } else if (file_exists($_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".jpeg")
//         ) {
//         $fileUrl = $_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".jpeg";
//      } else if (file_exists($_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".png")
//         ) {
//         $fileUrl = $_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".png";
//      } else if (
//         file_exists($_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".pdf")
//         ) {
//         $fileUrl = $_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".pdf";
//      } elseif (file_exists($_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".rar")
//         ) {
//         $fileUrl = $_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".rar";
//      } elseif (file_exists($_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".zip")
//         ) {
//         $fileUrl = $_SERVER['DOCUMENT_ROOT']
//         .DIRECTORY_SEPARATOR."res"
//         .DIRECTORY_SEPARATOR."admin"
//         .DIRECTORY_SEPARATOR."notification"
//         .DIRECTORY_SEPARATOR.$id_notificacao.".zip";
//      } 
     
//         else{ $fileUrl = ""; }
//       // else {
//       //    $fileUrl = $_SERVER['DOCUMENT_ROOT']
//       //    .DIRECTORY_SEPARATOR."views"
//       //    .DIRECTORY_SEPARATOR."emailcomm"
//       //    .DIRECTORY_SEPARATOR."shineray".".jpg";
//       // }

//     // //Attach an image file
//      $this->mail->addAttachment($fileUrl);
//     //send the message, check for errors


//      }

//     public function send() {
//         return $this->mail->send();
//     }

// }
