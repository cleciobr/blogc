<?php

use \Php\Model\User;
use \Php\Model\Post;
use \Php\Model\Birthday;
use \Php\Model;
use \Php\Model\Canal;
use \Php\Model\Notificacao;
use \Php\Model\Consult;



function getAlertsPTM() {
    $alert = Consult::checkForNewRecords();
    if ($alert === true) { 
        return "Novo registrado";
    } else {
        return "Não há registro"; 
    }
}
function getAlertsPTMactive() {
    $alert = Consult::checkForNewRecords();
    if ($alert === true) { 
        return "true";
    } else {
        return ""; 
    }
}



function getUserName() {
	$user = User::getFromSession();
    return $user->getdesname();
}


function getUserInadmin() {
    $user = User::getFromSessionInadmin();
    return $user->getinadmin();
}


function getUserId() {
	$user = User::getFromSession();
    return $user->getid_user();
}

// function getPhotosId() {
// 	$user = User::getPhotosId();
//     return $user->getdesphoto();
// }

function getPhotosId() {
    $user = new User();
    $user->getPhotosId(); // Chama o método que acabamos de corrigir
    return $user->getdesphoto(); // Retorna apenas a string do caminho da imagem
}

function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

function formatDateMes($date) {
    return date('m', strtotime($date));
}

function formatDateAno($date) {
    return date('Y', strtotime($date));
}


function formatDatePtBr($date) {
    if ($date != ""){
        return date('d/m/Y', strtotime($date));
    }
    return "00/00/0000";
}


function formatTime($time) {
    if ($date != ""){
        return date('h:m', strtotime($time));
    }
    return "" ;
}


function formatRegistro($time) {
    if ($time != ""){
        return ($time);
    }
    return "" ;
}



function formatDateTimePtBr($date) {
    if ($date != ""){
        return date('d/m/Y h:m',strtotime($date));
    }
    return "00/00/0000" ;
}
      

function formaTextDate($date) {
    if ($date != ""){
        return date('d/m/Y',strtodate($date));
    }
    return "00/00/0000" ;
}

function cortaStr($texto) {
    if(strlen($texto) > 100) {
      $textCutted = substr($texto, 0, 100) . "..."; 
      return $textCutted;
    }
    return $texto;
}

function formataStr($texto) {
    return substr($texto, 0, 500000);
}

function totalPosts() {
    $totals = Post::getPostsTotals();
    return $totals['nrqtd'];
}

function setPostActive() {
    return 1 || 0;
}


function totalVazio($value) {
    if ($value == "") {
        return "-";
    }
    return $value;
}

function status($value){
    if ($value == "Date.Day") {
        return "-";

    }
    return $value;
}

/*Comunicações*/ 
function totalCommuToday() {
    $totals = Canal::getCommuToday();
    return $totals['count(*)'];
}
function totalCommuMonth() {
    $totals = Canal::getCommuMonth();
    return $totals['count(*)'];
}
function totalCommuYear() {
    $totals = Canal::getCommuYear();
    return $totals['count(*)'];
}
function totalCommunications() {
    $totals = Canal::getCommuTotals();
    return $totals['nrqtd'];
}


/* Notificações*/ 
function totalNotificToday() {
    $totals = Notificacao::getNotificToday();
    return $totals['count(*)'];
}
function totalBirthdaysActive() {
    $totals = Birthday::getBirthdaysActive();
    return $totals['count(*)'];
}


function totalNotificMonth() {
    $totals = Notificacao::getNotificMonth();
    return $totals['count(*)'];
}

function totalNotificYear() {
    $totals = Notificacao::getNotificYear();
    return $totals['count(*)'];
}

function totalNotifications() {
    $totals = Notificacao::getNotificTotals();
    return $totals['nrqtd'];
}

function DateAtual() {
    $totals = Notificacao::getDateAtual();
    return $totals['date'];
}

function DateAtualnow() {
    $date = Notificacao::getDateAtual(); // Obtém a data atual no formato dd/mm/yyyy
    // Extrai os componentes da data
    $components = explode('/', $date);
    // Formata a data para o formato yyyy-mm-dd
    $formattedDate = $components[2] . '-' . $components[1] . '-' . $components[0];
    return $formattedDate;
}
