<?php

use \Php\PageAdmin;
use \Php\Model\User;
use \Php\Model\Department;
use \Php\Model\Consult;
use \Php\Model\Post;
use \Php\Model\Subscription;

$app->get('/admin/subscriptions(/)', function() {
	User::verifyLogin();
	User::verifyMyuserAdmin();
	$user = new User();
	$user = User::getFromSession();
	$subscription = new Subscription();
	// $alert = Consult::checkMaxSequenceOracle();
	// $datealert = Consult::getMaxdataPTMinserido();
	// $alertconsult= Consult::retrieveLastCheckMaxSequenceFromDatabase();
	$subscriptions = Subscription::listAll();
	$page = new PageAdmin();
	$page->setTpl("subscriptions", array(
		"subscriptions"=>$subscriptions,
		// "alert"=>$alert,
		// "datealert"=>$datealert,
		// "alertconsult"=>$alertconsult,
		"user"=>$user->getValues()
	));
});

$app->get('/admin/subscriptions/create(/)', function() {
	User::verifyLogin();
    User::Accessgranted();
	$user = new User();
	$user = User::getFromSession();
	$subscription = new Subscription();
	$departments = Department::getDepartments();
	// $alert= Consult::checkForNewRecords();
	
	$subscriptionimg = new Subscription();
	$page = new PageAdmin();
	$page->setTpl("subscriptions-create", [
		"user"=>$user->getValues(),
		// "alert"=>$alert,
		"subscriptionimg"=>$subscriptionimg->getImageCreate(),
		"departments"=>$departments,
	]);
});

$app->post('/admin/subscriptions/create(/)', function() {
	User::verifyLogin();
    User::Accessgranted();
    $subscription = new Subscription();
	$_POST["subscription_active"] = (isset($_POST["subscription_active"])) ? 1 : 0;
	$subscription->setData($_POST);
	$subscription->save();

	if ((int)$_FILES["file"]["size"] > 0) {
        $subscription->setPhotos($_FILES["file"]);
    }

	header("Location: /admin/subscriptions/create");
	exit;
});


$app->get("/admin/subscriptions/:id_subscription/delete(/)", function($id_subscription) {
	User::verifyLogin();
    User::Accessgranted();

	$subscription = new Subscription();
	$subscription->get((int)$id_subscription);
	$subscription->delete();
	header("Location: /admin/subscriptions");
	exit;
});


$app->get("/admin/subscriptions/:id_subscription(/)", function($id_subscription) {
	User::verifyLogin();
    User::Accessgranted();
    $user = new User();
    $user = User::getFromSession();
	$subscription = new Subscription();
	$departments = Department::getDepartments();
	$subscription->get((int)$id_subscription);
	// $alert= Consult::checkForNewRecords();
	$page = new PageAdmin();
	$page->setTpl("subscriptions-update", [
		"subscription"=>$subscription->getValues(),
		"user"=>$user->getValues(),
		// "alert"=>$alert,
		"subscriptionimg"=>$subscription->getValues(),
		"departments"=>$departments,
		
	]);
});


$app->post("/admin/subscriptions/:id_subscription(/)", function($id_subscription) {
	User::verifyLogin();
    User::Accessgranted();
	$subscription = new Subscription();	
	$subscription->get((int)$id_subscription);
	$_POST["subscription_active"] = (isset($_POST["subscription_active"])) ? 1 : 0;
	$subscription->setData($_POST);
	$subscription->update();
	if ((int)$_FILES["file"]["size"] > 0) {
        $subscription->setPhotos($_FILES["file"]);
    }
	
  if (isset($_POST['photos_to_delete']) && $_POST['photos_to_delete'] != '') {
      $idsToDelete = explode(',', $_POST['photos_to_delete']);
      foreach ($idsToDelete as $id_photo) {
          $event->deletePhoto((int)$id_photo); 
      }
  }
	header("Location: /admin/subscriptions/$id_subscription");
	exit;
});
  



// $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1:0;
