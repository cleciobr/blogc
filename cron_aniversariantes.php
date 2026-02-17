<?php
// Arquivo: cron_aniversariantes.php
require_once("vendor/autoload.php"); 

use Php\Model\Birthday;

// 1. Verifica se hoje é dia útil (Segunda a Sexta)
$diaSemana = date('w'); // 0 (dom) a 6 (sab)
if ($diaSemana == 0 || $diaSemana == 6) exit; 

// 2. Busca quem faz aniversário hoje no banco
$aniversariantes = Birthday::getListBirthdaysActive(); //lógica do SQL

foreach ($aniversariantes as $colaborador) {
    $b = new Birthday();
    $b->setData($colaborador);
    // 3. Dispara o e-mail
    $b->sendBirthdayEmail($colaborador['id_birthday'], $colaborador['name_birthday']);
}
