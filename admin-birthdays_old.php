<?php

use \Php\PageAdmin;
use \Php\Model\Birthday;
use \Php\Model\User;

/**
 * Get Route List all birthdays stored
 */
$app -> get("/admin/birthdays(/)", function() {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
  $user = new User();
  $user = User::getFromSession();
  $birthday = Birthday::getBirthdays();
  $birthdays = new Birthday();
  $page = new PageAdmin();
  $page -> setTpl("birthdays", [
    "user" => $user -> getValues(),
    "birthdays" => $birthdays -> getValues(),
    "birthdays" => Birthday::checkList($birthday)
  ]);
});

/**
 * Get Route form to create a new birthday
 */
// $app -> get("/admin/birthdays/create(/)", function() {
//   User::verifyLogin();
  User::verifyLogin2();
//   User::verifyNoQualy2();
//   $user = new user();
//   $user = User::getFromSession();
//   $birthday = new Birthday();
//   $page = new PageAdmin();
//   $page -> setTpl("birthdays-create", [
//     "user" => $user -> getValues(),
//     "birthday" => $birthday -> getImageCreate()
//   ]); 
// });



$app->get('/admin/birthdays/create(/)', function() {
	User::verifyLogin();
  User::verifyLogin2();
	User::verifyInadmin();
	
	$user = new user();
	$user = User::getFromSession();
	$page = new PageAdmin();
	$page->setTpl("birthdays-create", [
		"user"=>$user->getValues()
	]);
});
/**
 * Post Route form to create a new birthday
 */
$app->post("/admin/birthdays/create(/)", function () {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
  
  $birthday = new Birthday();
  $birthday -> setData($_POST);
  $birthday -> save();
  header("Location: /admin/birthdays");
  exit;
});

/**
 * Get Route to delete a birthday
 */
$app->get("/admin/birthdays/:id_birthday/delete(/)", function ($id_birthday) {
  User::verifyLogin();
  User::verifyLogin2();
  User::verifyNoQualy2();
  User::getFromSession();
  $birthday = new Birthday();
  $birthday -> get((int)$id_birthday);
  $birthday -> delete();
  header("Location: /admin/birthdays");
  exit;
});


// $app -> get("/admin/birthdays(/)", function() {
//   $user = new User();
//   $user = User::verifyLogin();
  User::verifyLogin2();
//   User::verifyNoQualy2();
//   $user = User::getFromSession();
  
//   $birthdays = Birthday::listAll();
  
//   $page = new PageAdmin;
//   $page -> setTpl("birthdays", [
//     "birthdays" => $birthdays,
//     "user" => $user -> getValues()
//   ]);
// });

// // $app->get("/admin/birthdays/create(/)", function () { 
// //   $user = new User();
// //   $user = User::verifyLogin();
  User::verifyLogin2();
// //   User::verifyNoQualy2();
// //   $user = User::getFromSession();
  
// //   $page = new PageAdmin();
// //   $page -> setTpl("birthdays-create", [
// //     "user" => $user -> getValues()
// //   ]);
// // });

// $app->get('/admin/birthdays/create(/)', function() {
// 	User::verifyLogin();
  User::verifyLogin2();
// 	User::verifyInadmin();
	
// 	$user = new User();
// 	$user = User::getFromSession();
// 	$page = new PageAdmin();
// 	$page->setTpl("birthdays-create", [
// 		"user"=>$user->getValues()
// 	]);
// });


// $app->post("/admin/birthdays/create(/)", function () { 
//   User::verifyLogin();
  User::verifyLogin2();
//   User::verifyNoQualy2();
//   $birthday = new Birthday();
//   $_POST["id_user"] = (isset($_POST["id_user"])) ? 1 : 0;
//   $birthday -> setData($_POST);
//   $birthday -> save();

//   header("Location: /admin/birthdays");
//   exit;
// });

// $app->get("/admin/birthdays/:id_birthday/delete(/)", function ($id_birthday) {
//   User::verifyLogin();
  User::verifyLogin2();
//   User::verifyNoQualy2();
//   $birthday = new Birthday();
//   $birthday -> get((int)$id_birthday);
//   $birthday -> delete();

//   header("Location: /admin/birthdays");
//   exit;
// });

 $app->get("/admin/birthdays/:id_birthday(/)", function ($id_birthday) {
   $user = new User();
   $user = User::verifyLogin();
  User::verifyLogin2();
   User::verifyNoQualy2();
   $user = User::getFromSession();

   $birthday = new Birthday();
   $birthday -> get((int)$id_birthday);

   $page = new PageAdmin();
   $page -> setTpl("birthdays-update", [
     "birthday" => $birthday -> getValues(),
     "user" => $user -> getValues()
   ]);
 });

 $app->post("/admin/birthdays/:id_birthday(/)", function ($id_birthday) {
   User::verifyLogin();
  User::verifyLogin2();
   User::verifyNoQualy2();
   $birthday = new Birthday();
   $birthday -> get((int)$id_birthday);
   $_POST["id_user"] = (isset($_POST["id_user"])) ? 1 : 0;
   $birthday -> setData($_POST);
   $birthday -> update();

   header("Location: /admin/birthdays");
   exit;
 });
