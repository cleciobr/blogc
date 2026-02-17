<?php

use \Php\PageAdmin;
use \Php\Model\Patientdgs;
use \Php\Model\User;
use \Php\Model\Notificacao;





// GET
// $app->get("/admin/patientsdgs(/)", function() {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$user = new User();
// 	$user = User::getFromSession();
 
//     // $connectionTest = Patientdgs::testConnection();
   
//     //  if ($connectionTest) {
//    	//   echo "Success!";
//     //  } else {
//    	//   echo "Error.";
//     //  }

//     $patientsdgs = Patientdgs::listAllLimit();
//     $page = new PageAdmin();
// 	$page->setTpl("patientsdgs", array(
// 		"patientsdgs"=>$patientsdgs,
// 		"user"=>$user->getValues()
// 	));
// });



// $app->get("/admin/patientsdgs/create(/)", function() {
// 	$success = isset($_GET['success']) ? $_GET['success'] : 0;
// 	$error = isset($_GET['error']) ? $_GET['error'] : 0;

// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$patientdgs = new Patientdgs();
// 	$registrolast = Patientdgs::getLastCodPac();
// 	$prontuariolast = Patientdgs::getLastCodPrt();
// 	$user = new User();
// 	$user = User::getFromSession();
// 	$page = new PageAdmin();
// 	$page->setTpl("patientsdgs-create", [
// 		"user"=>$user->getValues(),
// 		"patientdgs"=>$patientdgs->getValues(),
// 		"registrolast"=>$registrolast,
// 		"prontuariolast"=>$prontuariolast,
// 		"success"=>$success,
// 		"error"=>$error

// 	]);
// });


// $app->post("/admin/patientsdgs/create(/)", function() {
// 	User::verifyLogin();
// 	User::verifyAccess();
// 	$patientdgs = new Patientdgs();
// 	$patientdgs->setData($_POST);
// 	$patientdgs->save();
// 	header("Location: /admin/patientsdgs/create");
// 	exit;
// });





// $app->post("/admin/patientsdgs/create(/)", function() {
// User::verifyLogin();
// User::verifyAccess();
// $patientdgs = new Patientdgs();
// $patientdgs->setData($_POST);
// $patientdgs->save();
// header("Location: /admin/patientsdgs/create");
// exit;
// });




// $app->get("/admin/patientsdgs/:COD_PAC/delete(/)", function($COD_PAC) {
// User::verifyLogin();
// User::verifyAccess();
// $patientdgs = new Patientdgs();
// $patientdgs->get($COD_PAC);
// $patientdgs->delete();
// header("Location: /admin/patientsdgs");
// exit;
// });

// $app->get('/admin/patientsdgs/:COD_PAC(/)', function($COD_PAC) {
// User::verifyLogin();
// User::verifyAccess() ;
// $user = new User();
// $user = User::getFromSession();
// $patientdgs = new Patientdgs();
// $patientdgs->get($COD_PAC);
// $page = new PageAdmin();
// $page->setTpl("patientsdgs-update", array(
// 	"patientdgs"=>$patientdgs->getValues(),
// 	"user"=>$user->getValues()
// ));
// });

// $app->post("/admin/patientsdgs/:COD_PAC(/)", function($COD_PAC) {
// User::verifyLogin();
// User::verifyAccess() ;
// $patientdgs = new Patientdgs();
// $patientdgs->get($COD_PAC);
// $patientdgs->setData($_POST);
// $patientdgs->update();
// header("Location: /admin/patientsdgs/$COD_PAC");
// exit;
// });




