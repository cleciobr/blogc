<?php

use \Php\PageAdmin;
use \Php\Model\Ramal;
use \Php\Model\User;
use \Php\Model\Department;
use \Php\Model\Unit;

$app->get("/admin/ramais(/)", function() {
	User::verifyLogin();
	User::Accessgranted();
	$user = new User();
	$user = User::getFromSession();
  $ramais = Ramal::listAll();
  $page = new PageAdmin();
	$page->setTpl("ramais", array(
		"ramais"=>$ramais,
		"user"=>$user->getValues()
	));
});

$app->get('/admin/ramais/create(/)', function() {
	User::verifyLogin();
	User::Accessgranted();
	$units = Unit::getUnits();
	$departments = Department::getDepartments();
	$user = new User();
	$user = User::getFromSession();
	$page = new PageAdmin();
	$page->setTpl("ramais-create", [
		"user"=>$user->getValues(),
		"departments"=>$departments,
		"units"=>$units
	]);
});

$app->post("/admin/ramais/create(/)", function() {
	User::verifyLogin();
	User::Accessgranted();
	$ramal = new Ramal();
	$ramal->setData($_POST);
	$ramal->save();
	header("Location: /admin/ramais");
	exit;
});

$app->get("/admin/ramais/:id_agenda/delete(/)", function($idramal) {
	User::verifyLogin();
	User::Accessgranted();
	$ramal = new Ramal();
	$ramal->get((int)$idramal);
  $ramal->delete();
  header("Location: /admin/ramais");
	exit;
});

$app->get('/admin/ramais/:id_agenda(/)', function($idagenda) {
	User::verifyLogin();
	User::Accessgranted();
	$departments = Department::listAll();
	$units= Unit::listAll();
	$user = new User();
	$user = User::getFromSession();
	$ramal = new Ramal();
	$ramal->get((int)$idagenda);
	$page = new PageAdmin();
	$page->setTpl("ramais-update", array(
		"ramal"=>$ramal->getValues(),
		"user"=>$user->getValues(),
		"departments"=>$departments,
		"units"=>$units
	));
});

$app->post("/admin/ramais/:id_agenda(/)", function($idagenda) {
	User::verifyLogin();
	User::Accessgranted();
	$ramal = new Ramal();
	$ramal->get((int)$idagenda);
	$_POST["ativo"] = (isset($_POST["ativo"])) ? "S" : "N";
    $ramal->setData($_POST);
	$ramal->update();
	header("Location: /admin/ramais/$idagenda");
	exit;
});
