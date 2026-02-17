<?php

use \Php\PageAdmin;
use \Php\Model\Canal;

use \Php\Model\Department;
use \Php\Model\User;
use \Php\Model\Class_occ;
use \Php\Model\Degree_damg;
/**
 * Get Route List all Communicationsstored
 */

 //GET communications total
$app -> get("/admin/communications", function() {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoUser1();
  User::verifyNoTele3();
  $user = new User();
  $user = User::getFromSession();

  $communications = Canal::getCommunications();


  $page = new PageAdmin();
	$page->setTpl("communications", array(
		"communications"=>$communications,
		"user"=>$user->getValues()

	));
});

//GET Criação da communications página adiminstrativa
$app -> get('/admin/communications/create', function() {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
	$user = new User();
	$user = User::getFromSession();
	$departments = Department::getDepartments();
	
	$page = new PageAdmin();
	$page->setTpl("communications-create", [
		"user"=>$user->getValues(),
		"departments"=>$departments,
		
	]);
});




//POST criação / salvar
$app -> post("/admin/communications/create(/)", function() {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
	$communication = new Canal();
	$communication -> setData($_POST);
	$communication -> save();
	header("Location: /admin/communications/create");
	exit;
});


//GET comunicação Classificados
$app -> get("/admin/communications/finished", function() {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
	$user = new User();
	$user = User::getFromSession();
  
	$communicationsfinished = Canal::getCommunicationsfinished();
	$page = new PageAdmin();
	  $page->setTpl("communications-finished", array(
		  "communicationsfinished"=>$communicationsfinished,
		  "user"=>$user->getValues()
  
	  ));
  });
  

//GET comunicação Não Classificados
$app -> get("/admin/communications/noclass", function() {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoUser1();
  User::verifyNoTele3();
  $user = new User();
  $user = User::getFromSession();

  $communicationsnoclass = Canal::getCommunicationsnoclass();

  $page = new PageAdmin();
	$page->setTpl("communications-noclass", array(
		"communicationsnoclass"=>$communicationsnoclass,
		"user"=>$user->getValues()

	));
});

//GET classificação imcompleta
$app -> get("/admin/communications/classincomplet", function() {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoUser1();
  User::verifyNoTele3();
  $user = new User();
  $user = User::getFromSession();

  $communicationsclassincomplet = Canal::getCommunicationsclassincomplet();

  $page = new PageAdmin();
	$page->setTpl("communications-classincomplet", array(
		"communicationsclassincomplet"=>$communicationsclassincomplet,
		"user"=>$user->getValues()

	));
});


//GET comunicação year
$app -> get("/admin/communications/year", function() {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoUser1();
  User::verifyNoTele3();
  $user = new User();
  $user = User::getFromSession();

  $communicationsyear = Canal::getCommunicationsyear();

  $page = new PageAdmin();
	$page->setTpl("communications-year", array(
		"communicationsyear"=>$communicationsyear,
		"user"=>$user->getValues()

	));
});



	//GET comunicação month
$app -> get("/admin/communications/month", function() {
  User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
  $user = new User();
  $user = User::getFromSession();

  $communicationsmonth = Canal::getCommunicationsmonth();


  $page = new PageAdmin();
	$page->setTpl("communications-month", array(
		"communicationsmonth"=>$communicationsmonth,
		"user"=>$user->getValues()

	));
});


	//GET comunicação today
$app -> get("/admin/communications/today", function() {
  User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
  $user = new User();
  $user = User::getFromSession();

  $communicationstoday = Canal::getCommunicationstoday();

  $page = new PageAdmin();
	$page->setTpl("communications-today", array(
		"communicationstoday"=>$communicationstoday,
		"user"=>$user->getValues()

	));
});


//GET classificação da comunicação página administrativa
$app -> get('/admin/communications/:id_communication(/)', function($id_communication) {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
	$user = new User();
	$user = User::getFromSession();

	$communication = new Canal();
	$communication -> get((int)$id_communication);
	

	$class_occs = Class_occ::getClass_occs();
	$degree_damgs = Degree_damg::getDegree_damgs();
	

	$page = new PageAdmin();
	$page->setTpl("communication-details", array(
		"communication"=>$communication->getValues(),
		"user"=>$user->getValues(),
		"class_occs"=>$class_occs,
		"degree_damgs"=>$degree_damgs,
		
	));
	
});


// POST salvando a classificação
$app->post("/admin/communications/:id_communication(/)", function($id_communication) {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
	$communication = new Canal();	
	$communication->get($id_communication);
	$communication->setData($_POST);
	$communication->update();
	header("Location: /admin/communications/class/$id_communication");
	exit;
});


 //GET para impressão
$app -> get('/admin/communications/print/:id_communication(/)', function($id_communication) {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
	$user = new User();
	$user = User::getFromSession();

 	$communication = new Canal();
 	$communication -> get((int)$id_communication);
	
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	
	$page->setTpl("communications-print", [
		"user"=>$user->getValues(),
		"communication"=>$communication->getValues(),

		
	]);
});


//GET para impressão direta da página de lista de notificações
$app -> get('/admin/communications/print/:id_communication/print(/)', function($id_communication) {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyNoUser1();
	User::verifyNoTele3();
	$user = new User();
	$user = User::getFromSession();
 	$communication = new Canal();
 	$communication -> get((int)$id_communication);
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("communications-print", [
		"user"=>$user->getValues(),
		"communication"=>$communication->getValues(),	

	]);
});
