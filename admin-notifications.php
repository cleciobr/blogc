<?php

use \Php\PageAdmin;
use \Php\Model\Notificacao;
use \Php\Model\Canal;
use \Php\Model\Department;
use \Php\Model\User;
use \Php\Model\Patientsecurity;
use \Php\Model\Problem;
use \Php\Model\Process;
use \Php\Model\Incident;
use \Php\Model\Occurrence;
use \Php\Model\Degree_damg;
use \Php\Model\Class_occ;
use \Php\Model\Factoccurred;
use \Php\Model\Internacionalsecurity;
use \Php\Model\Conclusion;
/**
 * Get Route List all Notifications stored
 */

 //GET notificação total
$app -> get("/admin/notifications", function() {
  User::verifyLogin();
  User::verifyAccess() ;
  $user = new User();
  $user = User::getFromSession();

  $notifications = Notificacao::getNotifications();


  $page = new PageAdmin();
	$page->setTpl("notifications", array(
		"notifications"=>$notifications,
		"user"=>$user->getValues()

	));
});



 $app -> get("/admin/notifications/kept", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
  
	$notifications = Notificacao::getNotificationskept();
  
  
	$page = new PageAdmin();
	  $page->setTpl("notifications-kept", array(
		  "notifications"=>$notifications,
		  "user"=>$user->getValues()
  
	  ));
  });
  

  
 $app -> get("/admin/notifications/ontime", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
  
	$notifications = Notificacao::getNotificationsontime();
  
	$page = new PageAdmin();
	  $page->setTpl("notifications-ontime", array(
		  "notifications"=>$notifications,
		  "user"=>$user->getValues()
  
	  ));
  });


//GET notificação year
$app -> get("/admin/notifications/year", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
  
	$notificationsyear = Notificacao::getNotificationsyear();
  
	$page = new PageAdmin();
	  $page->setTpl("notifications-year", array(
		  "notificationsyear"=>$notificationsyear,
		  "user"=>$user->getValues()
  
	  ));
  });
  
  
  
	  //GET notificação month
  $app -> get("/admin/notifications/month", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
  
	$notificationsmonth = Notificacao::getNotificationsmonth();
  
  
	$page = new PageAdmin();
	  $page->setTpl("notifications-month", array(
		  "notificationsmonth"=>$notificationsmonth,
		  "user"=>$user->getValues()
  
	  ));
  });
  
  
	  //GET notificação today
  $app -> get("/admin/notifications/today", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
  
	$notificationstoday = Notificacao::getNotificationstoday();
	
  
	$page = new PageAdmin();
	  $page->setTpl("notifications-today", array(
		  "notificationstoday"=>$notificationstoday,
		  "user"=>$user->getValues()
  
	  ));
  });
  

// $success = isset($_GET['success']) ? $_GET['success'] : 0;
// $error = isset($_GET['error']) ? $_GET['error'] : 0;
// "success"=>$success,
// "error"=>$error



//POST criação / salvar
// $app -> post("/admin/notifications/create(/)", function() {
// 	User::verifyLogin();
// 	User::verifyNoUser1();
// 	User::verifyNoTele3();
// 	$notification = new Notificacao();
// 	$notification -> setData($_POST);
// 	$notification -> save();
// 	header("Location: /admin/notifications/create");
// 	exit;
// });


//  $app->post('/admin/notifications/create(/)', function() {
//  	User::verifyLogin();
//  	User::verifyAccess();
//  	$notificacao = new Notificacao();
//  	$notificacao->setData($_POST);

//  	$notificacao->save();
//  	$notificacao->sendNotification();
//  	header('Location: /admin/notifications/create?success=1');
//      exit;

//  	 if((int)$_FILES['file']['size'] > 0){
//  	 if((int)$_FILES['file']['size'] < 4194304){
//  	 $notificacao->save();
//       $notificacao->attachEmail($_FILES['file']);
//  	 $notificacao->sendNotification();
//  	     header('Location: /admin/notifications/create?success=1');
//  	     exit;
//     }
//  	   header('Location: /admin/notifications/create?error=1');
//  	   exit;
//  	  }else {
//  	   $notificacao->save();
//       $notificacao->sendNotification();
//  	   header('Location: /admin/notifications/create?success=1');
//  	   exit;
//  	}
//  });

//GET Criação da notificação página adiminstrativa
$app -> get('/admin/notifications/create', function() {
	$success = isset($_GET['success']) ? $_GET['success'] : 0;
	$error = isset($_GET['error']) ? $_GET['error'] : 0;
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$notifications = Notificacao::getNotifications();
	$departments = Department::getDepartments();
	$incidents = Incident::getIncidents();
	$occurrences = Occurrence::getOccurrences();
	$degree_damgs = Degree_damg::getDegree_damgs();
	
	$page = new PageAdmin();
	$page->setTpl("notifications-create", [
		"notifications"=>$notifications,
		"user"=>$user->getValues(),
		"departments"=>$departments,
		"degree_damgs"=>$degree_damgs,
		"incidents"=>$incidents,
		"occurrences"=>$occurrences,
		"success"=>$success,
   		"error"=>$error
		
	]);
});


 $app->post('/admin/notifications/create(/)', function() {
     User::verifyLogin();
     User::verifyAccess();
    
     $notificacao = new Notificacao();
     $notificacao->setData($_POST);

     // Verifica se um arquivo foi enviado
     if(isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
         // Verifica se o tamanho do arquivo é aceitável
         if($_FILES['file']['size'] < 4194304) {
             // Salva a notificação e anexa o arquivo
             $notificacao->save();
            //  $notificacao->attachEmail($_FILES['file']);
         } else {
             // Redireciona se o tamanho do arquivo for grande demais
             header('Location: /admin/notifications/create?error=1');
             exit;
         }
     } else {
		 // Se nenhum arquivo foi enviado, apenas salva a notificação
         $notificacao->saveadmin();
		}
		
		// Envie a notificação e redirecione para a página de sucesso
    //  $notificacao->sendNotification();
     header('Location: /admin/notifications/create?success=1');
     exit;
 });


 $app -> get('/admin/multiplenotifications/create', function() {
    $success = isset($_GET['success']) && $_GET['success'] == 'true';
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$notification = new Notificacao();
	
	$departments = Department::getDepartments();
	$factoccurreds = Factoccurred::getFactoccurreds();
	$incidents = Incident::getIncidents();
	$occurrences = Occurrence::getOccurrences();
	$degree_damgs = Degree_damg::getDegree_damgs();
	$processs = Process::getProcesss();
	$notifications = Notificacao::getNotifications();
	$patientsecuritys = Patientsecurity::getPatientsecuritys();
	$problems = Problem::getProblems();
	$conclusions = Conclusion::getConclusions();
	$internacionalsecuritys = Internacionalsecurity::getInternacionalsecuritys();
	
	
	$page = new PageAdmin();
	$page->setTpl("multiplenotifications-create", [
		"user"=>$user->getValues(),
		"notification"=>$notification->getValues(),
		"departments"=>$departments,
		"factoccurreds"=>$factoccurreds,
		"degree_damgs"=>$degree_damgs,
		"incidents"=>$incidents,
		"occurrences"=>$occurrences,
		"processs"=>$processs,
		"success"=>$success,
		"notifications"=>$notifications,
		"patientsecuritys"=>$patientsecuritys,
		"internacionalsecuritys"=>$internacionalsecuritys,
		"problems"=>$problems,
		"conclusions"=>$conclusions
		
	]);
});

$app->post('/admin/multiplenotifications/create(/)', function() use ($app) {
    User::verifyLogin();
    User::verifyAccess();
   
    $notificacao = new Notificacao();
    $notificacao->setData($_POST);
	
  
    if(isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
        
        if($_FILES['file']['size'] < 4194304) {
           
            $quant_rg = $_POST['quant_rg'];
            $notificacao->saveMultipleNotifications($quant_rg);
            // $notificacao->attachEmail($_FILES['file']);
        } else {
           
            header('Location: /admin/multiplenotifications/arquivo_very_bigcreate?error=1');
            exit;
        }
    } else {
       
        $quant_rg = $_POST['quant_rg']; 
        $notificacao->saveMultipleNotifications($quant_rg);
		header('Location: /admin/notifications/today?create?success=1');
		exit;
	    
    }
   
   
    header('Location: /admin/notifications?create?success=1');
    exit;
});




//  $app->post('/admin/multiplenotifications/create(/)', function() {
// 	User::verifyLogin();
// 	User::verifyAccess() ;
   
// 	$notificacao = new Notificacao();
// 	$notificacao->setData($_POST);

// 	// Verifica se um arquivo foi enviado
// 	if(isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
// 		// Verifica se o tamanho do arquivo é aceitável
// 		if($_FILES['file']['size'] < 4194304) {
// 			// Salva a notificação e anexa o arquivo
// 			$notificacao-> saveMultipleNotifications();
// 			$notificacao->attachEmail($_FILES['file']);
// 		} else {
// 			// Redireciona se o tamanho do arquivo for grande demais
// 			header('Location: /admin/multiplenotifications/arquivo_very_bigcreate?error=1');
// 			exit;
// 		}
// 	} else {
// 		// Se nenhum arquivo foi enviado, apenas salva a notificação
// 		$notificacao-> saveMultipleNotifications();
// 		header('Location: /admin/multiplenotifications/create?success=1');
// 		exit;
// 	   }
	   
// 	   // Envie a notificação e redirecione para a página de sucesso
// 	// $notificacao->sendNotification();
// 	header('Location: /admin/multiplenotifications/create?success=1');
// 	exit;
// });




 //GET notificação Classificados
 $app -> get("/admin/notifications/finished", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();

	$notificationsfinished = Notificacao::getNotificationsfinished();
	$page = new PageAdmin();
	  $page->setTpl("notifications-finished", array(
		  "notificationsfinished"=>$notificationsfinished,
		  "user"=>$user->getValues()
 
		));
  });
	

//GET notificação Não Classificados
$app -> get("/admin/notifications/noclass", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();

	$notificationsnoclass = Notificacao::getNotificationsnoclass();

	$page = new PageAdmin();
	$page->setTpl("notifications-noclass", array(
		"notificationsnoclass"=>$notificationsnoclass,
		"user"=>$user->getValues()

	));
});
 

//GET classificação imcompleta
$app -> get("/admin/notifications/classincomplet", function() {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
  
	$notificationsclassincomplet = Notificacao::getNotificationsclassincomplet();
  
	$page = new PageAdmin();
	  $page->setTpl("notifications-classincomplet", array(
		  "notificationsclassincomplet"=>$notificationsclassincomplet,
		  "user"=>$user->getValues()
  
	  ));
  });
  

//GET classificação da notificação página administrativa
$app -> get('/admin/notifications/:id_notificacao(/)', function($id_notificacao) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();

	$notification = new Notificacao();
	$notification -> get((int)$id_notificacao);
	
	$incidents = Incident::getIncidents();
	$occurrences = Occurrence::getOccurrences();
	$degree_damgs = Degree_damg::getDegree_damgs();
	$notifications = Notificacao::getNotifications();
	$factoccurreds = Factoccurred::getFactoccurreds();
	$internacionalsecuritys = Internacionalsecurity::getInternacionalsecuritys();
	$patientsecuritys = Patientsecurity::getPatientsecuritys();
	$problems = Problem::getProblems();
	$processs = Process::getProcesss();
	$conclusions = Conclusion::getConclusions();

	$page = new PageAdmin();
	$page->setTpl("notification-details", array(
		"notification"=>$notification->getValues(),
		"user"=>$user->getValues(),
		"notifications"=>$notifications,
		"patientsecuritys"=>$patientsecuritys,
		"internacionalsecuritys"=>$internacionalsecuritys,
		"problems"=>$problems,
		"processs"=>$processs,
		"incidents"=>$incidents,
		"factoccurreds"=>$factoccurreds,
		"occurrences"=>$occurrences,
		"degree_damgs"=>$degree_damgs,
		"conclusions"=>$conclusions,
		
	));
	
	
});


// POST salvando a classificação
$app->post("/admin/notifications/:id_notificacao(/)", function($id_notificacao) {
	User::verifyLogin();
	User::verifyAccess();
	$notification = new Notificacao();	
	$notification->get($id_notificacao);
	$notification->setData($_POST);
	$notification->update();
	// header("Location: /admin/notifications/class/$id_notificacao");
	header("Location: /admin/notifications/noclass");
	exit;
});






 //GET para impressão
$app -> get('/admin/notifications/class/:id_notificacao(/)', function($id_notificacao) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();

 	$notification = new Notificacao();
 	$notification -> get((int)$id_notificacao);
	
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	
	$page->setTpl("notifications-class", [
		"user"=>$user->getValues(),
		"notification"=>$notification->getValues(),
		
	]);
});


//GET para impressão direta da página de lista de notificações
$app -> get('/admin/notifications/class/:id_notificacao/print(/)', function($id_notificacao) {
	User::verifyLogin();
	User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
 	$notification = new Notificacao();
 	$notification -> get((int)$id_notificacao);
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("notifications-class", [
		"user"=>$user->getValues(),
		"notification"=>$notification->getValues(),	
	]);
});
