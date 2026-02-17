<?php

use \Php\PageAdmin;
use \Php\Model\Incident;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/incidents(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $incidents = Incident::listAll();
    $page = new PageAdmin();
	$page->setTpl("incidents", array(
		"incidents"=>$incidents,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/incidents/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;
		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("incidents-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/incidents/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$incident = new Incident();
	$incident->setData($_POST);
	$incident->save();
	header("Location: /admin/incidents/create");
	exit;
});


$app->get("/admin/incidents/:id_incident/delete(/)", function($id_incident) {
	User::verifyLogin();
	User::verifyAccess();
	$incident = new Incident();
	$incident->get((int)$id_incident);
  $incident->delete();
  header("Location: /admin/incidents");
	exit;
});

$app->get('/admin/incidents/:id_incident(/)', function($id_incident) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$incident = new Incident();
	$incident->get((int)$id_incident);
	$page = new PageAdmin();
	$page->setTpl("incidents-update", array(
		"incident"=>$incident->getValues(),
		"user"=>$user->getValues()
	));
});

$app->post("/admin/incidents/:id_incident(/)", function($id_incident) {
	User::verifyLogin();
	User::verifyAccess();
	$incident = new Incident();
	$incident->get((int)$id_incident);
    $incident->setData($_POST);
	$incident->update();
	header("Location: /admin/incidents/$id_incident");
	exit;
});




