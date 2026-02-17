<?php

use \Php\PageAdmin;
use \Php\Model\Unit;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/units(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $units = Unit::listAll();
    $page = new PageAdmin();
	$page->setTpl("units", array(
		"units"=>$units,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/units/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;

		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("units-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/units/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$unit = new Unit();
	$unit->setData($_POST);
	$unit->save();
	header("Location: /admin/units/create");
	exit;
});


$app->get("/admin/units/:id_unit/delete(/)", function($id_unit) {
	User::verifyLogin();
	User::verifyAccess();
	$unit = new Unit();
	$unit->get((int)$id_unit);
  $unit->delete();
  header("Location: /admin/units");
	exit;
});

$app->get('/admin/units/:id_unit(/)', function($id_unit) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$unit = new Unit();
	$unit->get((int)$id_unit);
	$page = new PageAdmin();
	$page->setTpl("units-update", array(
		"unit"=>$unit->getValues(),
		"user"=>$user->getValues()
	));
});

$app->post("/admin/units/:id_unit(/)", function($id_unit) {
	User::verifyLogin();
	User::verifyAccess();
	$unit = new Unit();
	$unit->get((int)$id_unit);
    $unit->setData($_POST);
	$unit->update();
	header("Location: /admin/units/$id_unit");
	exit;
});




