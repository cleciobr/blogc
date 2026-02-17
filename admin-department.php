<?php

use \Php\PageAdmin;
use \Php\Model\Department;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
$app->get("/admin/departments(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
    $departments = Department::listAll();
    $page = new PageAdmin();
	$page->setTpl("departments", array(
		"departments"=>$departments,
		"user"=>$user->getValues()
	));
});

	$app->get("/admin/departments/create(/)", function() {
		$success = isset($_GET['success']) ? $_GET['success'] : 0;
		$error = isset($_GET['error']) ? $_GET['error'] : 0;

		User::verifyLogin();
		User::verifyAccess();
		$user = new User();
		$user = User::getFromSession();
		$page = new PageAdmin();
		$page->setTpl("departments-create", [
			"user"=>$user->getValues(),
			"success"=>$success,
			"error"=>$error

		]);
	});

$app->post("/admin/departments/create(/)", function() {
	User::verifyLogin();
	User::verifyAccess();
	$department = new Department();
	$department->setData($_POST);
	$department->save();
	header("Location: /admin/departments/create");
	exit;
});


$app->get("/admin/departments/:id_department/delete(/)", function($id_department) {
	User::verifyLogin();
	User::verifyAccess();
	$department = new Department();
	$department->get((int)$id_department);
  $department->delete();
  header("Location: /admin/departments");
	exit;
});

$app->get('/admin/departments/:id_department(/)', function($id_department) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$department = new Department();
	$department->get((int)$id_department);
	$page = new PageAdmin();
	$page->setTpl("departments-update", array(
		"department"=>$department->getValues(),
		"user"=>$user->getValues()
	));
});

$app->post("/admin/departments/:id_department(/)", function($id_department) {
	User::verifyLogin();
	User::verifyAccess();
	$department = new Department();
	$department->get((int)$id_department);
    $department->setData($_POST);
	$department->update();
	header("Location: /admin/departments/$id_department");
	exit;
});




