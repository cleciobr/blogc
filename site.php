<?php

use \Php\Page;
use \Php\DB\Sql;
use \Php\Model\Post;
use \Php\Model\Event;
use \Php\Model\Birthday;
use \Php\Model\Popup;
use \Php\Model\Ramal;
use \Php\Model\Convenant;
use \Php\Model\Department;
use \Php\Model\Notificacao;
use \Php\Model\Canal;
use Php\Model\User;
use \Php\Model\Incident;
use \Php\Model\Occurrence;
use \Php\Model\Degree_damg;
use \Php\Model\Subscription;
use \Php\Model\Unit;

//  $app->get('/', function() {
//  	$ramal = Ramal::listAll();
//  	$department = Department::listAll();
//  	$posts = Post::listAllLimit2();
//  	$popups = Popup::getLast2Popups();

//  	$birthday = Birthday::lastBirthday();
//  	$birthdayId = Birthday::lastBirthdayId();
//  	 $a = array_pop($birthdayId);
//  	 //$b = array_product($a);
//  	 $photos = new Birthday();
//  	 //$photos->get((int)$b);

//  	$event = Event::lastEvent();
//  	$eventId = Event::lastEventId();
//  	$a = array_pop($eventId);
//  	//$b = array_product($a);
//  	$photos = new Event();
//  	//$photos->get((int)$b);

//  	$page = new Page();
//  	$page->setTpl("index", array(
//  		"ramal" => $ramal,
//  		"department" => $department,
//  		"posts" => Post::checkList($posts),
//  		"popups" => Popup::checkList($popups),
//  		"birthday" => $birthday,
//  		"event" => $event,
//  		"photos" => $photos->getSixPhotos(),
//  		"displayBannerControl" => 1,
//  		"displayPopupControl" => 1,
//  		"classActiveControl" => 2,
//  		"classBirthdayActive" => 1,
//  	));
//  });

$app->hook('slim.before.dispatch', function () use ($app) {  
    $resourceUri = $app->request()->getResourceUri();

    $blackList = [
        '/subscriptions',
        '/treinamentos',
        '/admin/pagina-bloqueada'
    ];

    foreach ($blackList as $url) {
        if (strpos($resourceUri, $url) === 0) {
            $destino = (strpos($resourceUri, '/admin') === 0) ? '/admin' : '/';
            
            $app->redirect($destino);
        }
    }
});




$app->get('/', function() {
 	$ramal = Ramal::listAll();
 	$department = Department::listAll();
 	$posts = Post::listAllLimit2();
 	$popups = Popup::getLast2Popups();
 	
    $birthday = Birthday::lastBirthday();
    foreach ($birthday as &$b) {
        $birthdayObj = new Birthday();
        $birthdayObj->setData($b); 
        $b['photos'] = $birthdayObj->getPhotos(); 
    }
 
 	$event = Event::lastEvent();
 	$eventPhotos = []; // Inicializa a lista de fotos vazia

    // Verifica se existe um evento retornado
 	if (!empty($event)) {
        $photosEvent = new Event();
        
        //lastEvent() provavelmente retorna um array de 1 item, pegamos o primeiro
        $eventData = is_array($event) ? $event : [$event];
        
        // Define os dados do evento no objeto de fotos para que ele saiba qual ID usar
        $photosEvent->setData($eventData[0]); 
        
        // Agora o getSixPhotos() funcionará, pois o ID do evento está definido
        $eventPhotos = $photosEvent->getSixPhotos();
    }
    // ----------------------------------------------------

 	$page = new Page();
 	$page->setTpl("index", array(
 		"ramal" => $ramal,
 		"department" => $department,
 		"posts" => Post::checkList($posts),
 		"popups" => Popup::checkList($popups),
 		"birthday" => $birthday,
 		"event" => $event,
 		"photos" => $eventPhotos, // Agora a variável contém as fotos do evento
 		"displayBannerControl" => 1,
 		"displayPopupControl" => 1,
 		"classActiveControl" => 2,
 		"classBirthdayActive" => 1,
 	));
 });




$app->get('/blog/:id_post/:url_slug(/)', function($id_post, $url_slug) {
	$page = new Page([
		"header"=>false,
		"footer"=>false
	]);
	$post = new Post();
	$post->getFromURL($id_post, $url_slug);
	$posts = Post::getLast3Posts();
	$page->setTpl("post", [
		"post"=>$post->getValues(),
		"posts"=>Post::checkList($posts)		
	]);
});

$app->get('/blog(/)', function() {
	$page = new Page([
		"header"=>false,
		"footer"=>false
	]);
	$pagina = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	$post = Post::listAll();
	$posts = new Post();
	$pagination = $posts->getPostsPage($pagina);
	$pages = [ 
		'antes' => [
			'link'=>'/blog'.'?page='.($pagina - 1)
		],
		'depois' => [
			'link'=>'/blog'.'?page='.($pagina + 1) 
		] 
	];
	if($pagina > $pagination['pages'] || $pagina < 1 ) {
		header('Location: /blog');
		exit;
	}
	$page->setTpl("blog", array(
		"posts"=>Post::checkList($post),
		"posts"=>$pagination['data'],
		"paginas"=>$pagination['pages'],
		"pages"=>$pages,
		"pagina"=>$pagina
	));
});




// Notifications page main
  $app->get('/notificacao(/)', function() {
  	$success = isset($_GET['success']) ? $_GET['success'] : 0;
  	$error = isset($_GET['error']) ? $_GET['error'] : 0;

  	$departments = Department::getDepartments();
	$incidents = Incident::getIncidents();
	$occurrences = Occurrence::getOccurrences();
	$degree_damgs = Degree_damg::getDegree_damgs();
	
  	$page = new Page();
  	$page->setTpl("notificacao", array(
  		"departments" => $departments,
		"degree_damgs" => $degree_damgs,
		"incidents"=>$incidents,
		"occurrences"=>$occurrences,
  		"success"=>$success,
   		"error"=>$error
  	));
  });
 

  $app->post('/notificacao(/)', function() {
  	$notificacao = new Notificacao();
  	$notificacao->setData($_POST);
  	$notificacao->save();
  	$notificacao->sendNotification();

  	header('Location: /?success=1');
  	exit;

  	 if ((int)$_FILES['file']['size'] > 0) {
  	 if((int)$_FILES['file']['size'] < 4194304) {
  	   $notificacao->save();
       $notificacao->attachEmail($_FILES['file']);
  	   $notificacao->sendNotification();
  	     header('Location: /?success=1f');
  	     exit;
     }
  	   header('Location: /?error=1');
  	   exit;
  	  }else {
  	   $notificacao->save();
       $notificacao->sendNotification();
  	   header('Location: /?success=1');
  	   exit;
  	}
  });





$app->get("/docs(/)", function() {
	$page = new Page([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("docs");
});



$app->get("/subscriptions(/)", function() {
	$page = new Page([
		"header"=>false,
		"footer"=>false
	]);
	$units = Unit::getUnits();
	$departments = Department::getDepartments();
	$event = Event::lastEvent();
	$subscriptions = Subscription::listAll();
    $subscriptions = Subscription::checkList($subscriptions);


 	$eventPhotos = []; 


 	if (!empty($event)) {
        $photosEvent = new Event();
        
        $eventData = is_array($event) ? $event : [$event];
        
        $photosEvent->setData($eventData[0]); 
        
        $eventPhotos = $photosEvent->getSixPhotos();
    }

	$page->setTpl("subscriptions-create", array(
		"units" => $units,
		"departments" => $departments,
 		"photos" => $eventPhotos,
		"subscriptions" => $subscriptions
       
 	));
});

$app->get("/treinamentos(/)", function() {
	$page = new Page([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("treinamentos");
});


$app->get("/convenios(/)", function () {
	$convenant = Convenant::listAll();

	$page = new Page([
		"header" => false,
		"footer" => false
	]);
	$page->setTpl("convenants-list", [
		"convenant" => $convenant
	]);
});

$app->get("/birthdays(/)", function () {
	$birthday = Birthday::listAll();

	$page = new Page([
		"header" => false,
		"footer" => false
	]);
	$page->setTpl("birthdays-list", [
		"birthday" => $birthday
	]);
});


// $app -> get("/events(/)", function() {
// 	$page = new Page([
// 		"header" => false,
// 		"footer" => false
// 	]);

// 	$pagina = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
// 	$event = Event::listAll();
// 	$events = new Event();
// 	$events -> getFirstPhoto();

// 	$pagination = $events -> getEventsPage($pagina);
// 	$pages = [
// 		'antes' => [
// 			'link' => '/events' . '?page=' . ($pagina - 1) 
// 		],
// 		'depois' => [
// 			'link' => '/events' . '?page=' . ($pagina + 1)
// 		]
// 	];

// 	if($pagina > $pagination['pages'] || $pagina < 1) {
// 		header('Location: /events');
// 		exit;
// 	}

$app->get("/events(/)", function() {
    $page = new Page([
        "header" => false,
        "footer" => false
    ]);

    $pagina = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $eventModel = new Event();

    $pagination = $eventModel->getEventsPage($pagina);

    $events = (isset($pagination['data']) && !empty($pagination['data'])) ? $pagination['data'] : [];
    $totalPaginas = (isset($pagination['pages'])) ? (int)$pagination['pages'] : 0;


    if ($totalPaginas > 0 && ($pagina > $totalPaginas || $pagina < 1)) {
        header('Location: /events');
        exit;
    }

    $pages = [
        'antes' => [
            'link' => '/events?page=' . ($pagina - 1) 
        ],
        'depois' => [
            'link' => '/events?page=' . ($pagina + 1)
        ]
    ];

    $page->setTpl("events", [
        "events"  => $events,
        "pagina"  => $pagina,
        "paginas" => $totalPaginas,
        "pages"   => $pages
    ]);
});

 

$app->get('/event/:id_event/:url_slug(/)', function ($id_event, $url_slug) {
	$page = new Page([
		"header" => false,
		"footer" => false
	]);

	$event = new Event();
	$event -> getFromURL($id_event, $url_slug);
	$event -> get((int)$id_event);
	$event -> getPhotos();
	
	$page->setTpl("event", [
		"event" => $event -> getValues(),
		"events" => $event -> getPhotos()
	]);
});




/* Communication */


//   $app->get('/(/)', function() {
//   	$success = isset($_GET['success']) ? $_GET['success'] : 0;
//   	$error = isset($_GET['error']) ? $_GET['error'] : 0;

//   	$departments = Department::getDepartments();
	
//   	$page = new Page();
//   	$page->setTpl("index", array(
//   		"departments" => $departments,
//   		"success"=>$success,
//    		"error"=>$error
//  	));
//   });

//   $app->post('/(/)', function() {
//   	$communication = new Canal();
//    	$communication->setData($_POST);

	   
//    	$communication->save();
//    	$communication->sendCommunication();
//    	header("Location: ?success=1");
//    	exit;

//    	 if ((int)$_FILES["file"]["size"] > 0) {
//    	 if((int)$_FILES["file"]["size"] < 4194304) {
//    	   $communication->save();
//        $communication->attachEmail($_FILES["file"]);
//    	   $communication->sendCommunication();
//    	     header("Location: /?success=1f");
//    	     exit;
//       }
//    	   header("Location: /?error=1");
//    	   exit;
//    	  }else {
//    	   $communication->save();
//        $notificacao->sendCommunication();
//    	   header("Location: /?success=1");
//    	   exit;
//    	}
//    });






//    $app->post('/(/)', function() {
// 	$notificacao = new Canal();
// 	 $notificacao->setData($_POST);

	 
// 	 $notificacao->save();
// 	 $notificacao->sendCommunication();
// 	 header('Location: ?success=1');
// 	 exit;

// 	  if ((int)$_FILES['file']['size'] > 0) {
// 	  if((int)$_FILES['file']['size'] < 4194304) {
// 		$notificacao->save();
// 	 $notificacao->attachEmail($_FILES['file']);
// 		$notificacao->sendCommunication();
// 		  header('Location: /?success=1f');
// 		  exit;
// 	}
// 		header('Location: /?error=1');
// 		exit;
// 	   }else {
// 		$notificacao->save();
// 	 $notificacao->sendCommunication();
// 		header('Location: /?success=1');
// 		exit;
// 	 }
//  });


 //Teste Notifi
	// $app->post('/(/)', function() {
	//   	$notificacao = new Notificacao();
	//   	$notificacao->setData($_POST);
	
	//   	$notificacao->save();
	//   	$notificacao->sendNotification();
	
	//   	header('Location: /?success=1');
	//   	exit;
	
	//   	 if ((int)$_FILES['file']['size'] > 0) {
	//   	 if((int)$_FILES['file']['size'] < 4194304) {
	//   	   $notificacao->save();
	//        $notificacao->attachEmail($_FILES['file']);
	//   	   $notificacao->sendNotification();
	//   	     header('Location: /?success=1f');
	//   	     exit;
	//      }
	//   	   header('Location: /?error=1');
	//   	   exit;
	//   	  }else {
	//   	   $notificacao->save();
	//        $notificacao->sendNotification();
	//   	   header('Location: /?success=1');
	//   	   exit;
	//   	}
	//   });




//   var_dump ($sql);
//   exit;

