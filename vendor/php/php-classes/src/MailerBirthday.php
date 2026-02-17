<?php
namespace Php;
use Rain\Tpl;

class MailerBirthday {
    
   const USERNAME = "cleciope2@gmail.com";
   const PASSWORD = "kpdxhafmyaqsofqj"; 
   const NAME_FROM = "Aniversariantes Shineray";

   private $mail;

   public function __construct($id_birthday, $date_birthday, $name_birthday, $esp_birthday, $department, $subject, $tplName, $toEmail, $data = [])  {
      $config = array(
         "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/emailbirthday/",
         "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
         "debug"         => false
      );
      Tpl::configure($config);
      $tpl = new Tpl;
      foreach ($data as $key => $value) { $tpl->assign($key, $value); }
      
      $html = $tpl->draw($tplName, true);

      $this->mail = new \PHPMailer;
      $this->mail->isSMTP();
      $this->mail->SMTPDebug = 0; 
      $this->mail->Host = 'smtp.gmail.com';
      $this->mail->Port = 587;
      $this->mail->SMTPSecure = 'tls';
      $this->mail->SMTPAuth = true;
      $this->mail->Username = MailerBirthday::USERNAME;
      $this->mail->Password = MailerBirthday::PASSWORD;
      $this->mail->setFrom(MailerBirthday::USERNAME, MailerBirthday::NAME_FROM);
      $this->mail->addAddress($toEmail, 'RH comunica'); 
    //   $this->mail->addAddress('cleciope@gmail.com', 'RH comunica'); // Corrigido para .com
      $this->mail->Subject = $subject;
      $this->mail->CharSet = 'UTF-8';
$html = $tpl->draw($tplName, true);


$directory = $_SERVER['DOCUMENT_ROOT'] . "/res/site/img/aniver/";
$fotos = glob($directory . $id_birthday . "_*.jpg");

$conteudoDinamico = "";

if (count($fotos) > 0) {
    foreach ($fotos as $index => $fileUrl) {
        $cid = "foto_aniver_" . $index;
        $this->mail->addEmbeddedImage($fileUrl, $cid);
        $conteudoDinamico .= '<img src="cid:' . $cid . '" style="max-width:450px; width:100%; border-radius:10px; margin-bottom:15px; display:block; margin-left:auto; margin-right:auto;">';
    }
}

$nomeAniversariante = $data['nome'];
$dataNasc = date("d-m-Y", strtotime($data['data_nasc']));

$detalhesHtml = '
    <h2>🎉 Aniversariante(s) do Dia! 🎉</h2>
    <p class="lead">Aniversariante(s) celebrando hoje!</p>
    <div style="margin-top: 20px; text-align: center;">
        <h4 style="margin-bottom: 15px;">' . $nomeAniversariante . '</h4>
        <p><strong>Data de Registro:</strong> ' . $dataNasc . '</p>
    </div>
';

$html = str_replace('[CONTEUDO_ANIVERSARIANTE]', $detalhesHtml . $conteudoDinamico, $html);

$this->mail->msgHTML($html);
   }

   public function send() {
      // Correção para PHP 7/8 (PHPMailer antigo precisa disso)
      if (!function_exists('get_magic_quotes_runtime')) {
          function get_magic_quotes_runtime() { return false; }
      }
      return $this->mail->send();
   }
}
