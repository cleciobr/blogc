<?php

use \Php\PageAdmin;
use \Php\Model\Process;
use \Php\Model\User;
use \Php\Model\Notificacao;



// GET departaments
// $app->get("/admin/processs(/)", function() {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$user = new User();
// 	$user = User::getFromSession();
//     $processs = Process::listAll();
//     $page = new PageAdmin();
// 	$page->setTpl("processs", array(
// 		"processs"=>$processs,
// 		"user"=>$user->getValues()
// 	));
// });

// 	$app->get("/admin/processs/create(/)", function() {
// 		$success = isset($_GET['success']) ? $_GET['success'] : 0;
// 		$error = isset($_GET['error']) ? $_GET['error'] : 0;

// 		User::verifyLogin();
// 		User::verifyAccess();
// 		$user = new User();
// 		$user = User::getFromSession();
// 		$page = new PageAdmin();
// 		$page->setTpl("processs-create", [
// 			"user"=>$user->getValues(),
// 			"success"=>$success,
// 			"error"=>$error

// 		]);
// 	});

// $app->post("/admin/processs/create(/)", function() {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$process = new Process();
// 	$process->setData($_POST);
// 	$process->save();
// 	header("Location: /admin/processs/create");
// 	exit;
// });


// $app->get("/admin/processs/:id_process/delete(/)", function($id_process) {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$process = new Process();
// 	$process->get((int)$id_process);
//   $process->delete();
//   header("Location: /admin/processs");
// 	exit;
// });

// $app->get('/admin/processs/:id_process(/)', function($id_process) {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$user = new User();
// 	$user = User::getFromSession();
// 	$process = new Process();
// 	$process->get((int)$id_process);
// 	$page = new PageAdmin();
// 	$page->setTpl("processs-update", array(
// 		"process"=>$process->getValues(),
// 		"user"=>$user->getValues()
// 	));
// });

// $app->post("/admin/processs/:id_process(/)", function($id_process) {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$process = new Process();
// 	$process->get((int)$id_process);
//     $process->setData($_POST);
// 	$process->update();
// 	header("Location: /admin/processs/$id_process");
// 	exit;
// });




