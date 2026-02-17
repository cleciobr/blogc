<?php


use \Php\PageAdmin;
use \Php\Model\Report;
use \Php\Model\User;
use \Php\Model\Department;
use \Php\Model\Incident;
use \Php\Model\Class_occ;
use \Php\Model\Degree_damg;
use \Php\Model\Process;
use \Php\Model\Occurrence;
use \Php\Model\Consult;
use \Php\Model\Post;


$app->get('/admin/dashboardrealtime', function () {
    User::verifyLogin();
    User::verifyActive();
    User::verifyAccess();
    $alerts = new Consult;
    $user = User::getFromSession();
    $post = Post::listAllLimit();
    $alert = Consult::checkMaxSequenceOracle();
    $alertconsult = Consult::retrieveLastCheckMaxSequenceFromDatabase();
    $posts = new Post();

    $page = new PageAdmin([
        "headerfull" => true, 
        "footerfull" => true, 
        "header" => false, 
        "footer" => false, 
    ]);

    $page->setTpl("dashboardrealtime", array(
        "header"=>false,
        "footer"=>false,
        "user" => $user->getValues(),
        "alert" => $alert,
        "alertconsult" => $alertconsult,
        "posts" => $posts->getValues(),
        "posts" => Post::checkList($post)
    ));
});



//  $app->get('/admin/reports(/)', function() {
//    $success = isset($_GET['success']) ? $_GET['success'] : 0;
//    $error = isset($_GET['error']) ? $_GET['error'] : 0;

//    $departments = Department::getDepartments();
//    $user = User::getFromSession();

//    $statusNotificationsByMonth = Report::getStatusNotificationsByMonth($month, $year);

//    $statusNotificationsByYear = Report::getStatusNotificationsByYear();
//    $notificationsByMonth = Report::getNotificationsByMonth();

//    $page = new PageAdmin();
//    $page->setTpl("reports", array(
//        "user" => $user->getValues(),
//        "departments" => $departments,
//        "success" => $success,
//        "error" => $error,
//        "statusNotificationsByMonth" => $statusNotificationsByMonth,
//        "statusNotificationsByYear" => $statusNotificationsByYear,
//        "notificationsByMonth" => $notificationsByMonth
//    ));
//  });


// $app->get('/admin/reports(/)', function($request, $response, $args) {
//   $success = $request->getQueryParam('success') ?? 0;
//   $error = $request->getQueryParam('error') ?? 0;

//   $departments = Department::getDepartments();
//   $user = User::getFromSession();

//   // Obtenha os valores de mês e ano dos parâmetros da rota
//   $month = $request->getQueryParam('month');
//   $year = $request->getQueryParam('year');

//   // Verificar se o mês e o ano foram passados na URL
//   if ($month !== null && $year !== null) {
//       // Se sim, chame a função com os valores de mês e ano
//       $statusNotificationsByMonth = Report::getStatusNotificationsByMonth($month, $year);
//   } else {
//       // Caso contrário, chame a função sem passar os valores de mês e ano
//       $statusNotificationsByMonth = Report::getStatusNotificationsByMonth();
//   }

//   $statusNotificationsByYear = Report::getStatusNotificationsByYear();
//   $notificationsByMonth = Report::getNotificationsByMonth();

//   $page = new PageAdmin();
//   $page->setTpl("reports", array(
//       "user" => $user->getValues(),
//       "departments" => $departments,
//       "success" => $success,
//       "error" => $error,
//       "statusNotificati
//       onsByMonth" => $statusNotificationsByMonth,
//       "statusNotificationsByYear" => $statusNotificationsByYear,
//       "notificationsByMonth" => $notificationsByMonth
//   ));

//   return $response;
// });


$app->get('/admin/dashboardrealtime/results(/)', function() {
    $success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
    User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$departments = Department::getDepartments();

    
    $page = new PageAdmin();
   
    $page->setTpl("generate-report", array(
        "user" => $user->getValues(),
        "departments" => $departments,
        "success" => $success,
        "error" => $error,
     
        ));
    
});

$app->get('/admin/dashboardrealtime(/)', function() {
    $success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
    User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$departments = Department::getDepartments();

    
    $page = new PageAdmin();
   
    $page->setTpl("reports", array(
        "user" => $user->getValues(),
        "departments" => $departments,
        "success" => $success,
        "error" => $error,
     
        ));
    
});


$app->post('/admin/dashboardrealtime/results(/)', function() use ($app) {
    $success = isset($_GET['success']) && $_GET['success'] == 'true';
	$error = isset($_GET['error']) && $_GET['error'] == 'false';
	User::verifyLogin();
    User::verifyAccess();
	$user = new User();
	$user = User::getFromSession();
	$departments = Department::getDepartments();
    $incidents = Incident::getIncidents();
	$occurrences = Occurrence::getOccurrences();
	$degree_damgs = Degree_damg::getDegree_damgs();
	$processs = Process::getProcesss();
    $names = isset($_POST['st_cante']) ? $_POST['st_cante'] : "Sem registro";
    $st_cante = $names;
    $st_cado = $names;
    $month = isset($_POST['month']) ? $_POST['month'] : "0";
    $year = isset($_POST['year']) ? $_POST['year'] : "0";

    // $resultst_cante = Report::getStatusNotificationsByMonthCante($month, $year, $names);
    // $resultst_cado = Report::getStatusNotificationsByMonthCado($month, $year, $names);
    //Cado
    $resultsCadoMonthConcluded = Report::getStatusNotificationsByMonthCadoConcluded($month, $year, $names);
    $resultsCadoMonthLate = Report::getStatusNotificationsByMonthCadoLate($month, $year, $names);
    $resultsCadoMonthOntime = Report::getStatusNotificationsByMonthCadoOntime($month, $year, $names);
    $resultsCadoYearConcluded = Report::getStatusNotificationsByYearCadoConcluded($year, $names);
    $resultsCadoYearLate = Report::getStatusNotificationsByYearCadoLate($year, $names);
    $resultsCadoYearOntime = Report::getStatusNotificationsByYearCadoOntime($year, $names);
    //Cante
    $resultsCanteMonthConcluded = Report::getStatusNotificationsByMonthCanteConcluded($month, $year, $names);
    $resultsCanteMonthLate = Report::getStatusNotificationsByMonthCanteLate($month, $year, $names);
    $resultsCanteMonthOntime = Report::getStatusNotificationsByMonthCanteOntime($month, $year, $names);
    $resultsCanteYearConcluded = Report::getStatusNotificationsByYearCanteConcluded($year, $names);
    $resultsCanteYearLate = Report::getStatusNotificationsByYearCanteLate($year, $names);
    $resultsCanteYearOntime = Report::getStatusNotificationsByYearCanteOntime($year, $names);
    //Cante total month
    $resultsTotalCanteJan = Report::getStatusNotificationsTotalCanteJan($year, $names);
    $resultsTotalCanteFev = Report::getStatusNotificationsTotalCanteFev($year, $names);
    $resultsTotalCanteMar = Report::getStatusNotificationsTotalCanteMar($year, $names);
    $resultsTotalCanteAbr = Report::getStatusNotificationsTotalCanteAbr($year, $names);
    $resultsTotalCanteMai = Report::getStatusNotificationsTotalCanteMai($year, $names);
    $resultsTotalCanteJun = Report::getStatusNotificationsTotalCanteJun($year, $names);
    $resultsTotalCanteJul = Report::getStatusNotificationsTotalCanteJul($year, $names);
    $resultsTotalCanteAgo = Report::getStatusNotificationsTotalCanteAgo($year, $names);
    $resultsTotalCanteSet = Report::getStatusNotificationsTotalCanteSet($year, $names);
    $resultsTotalCanteOut = Report::getStatusNotificationsTotalCanteOut($year, $names);
    $resultsTotalCanteNov = Report::getStatusNotificationsTotalCanteNov($year, $names);
    $resultsTotalCanteDez = Report::getStatusNotificationsTotalCanteDez($year, $names);
    //Cado
    $concludedmonthcado = !empty($resultsCadoMonthConcluded) ? strval($resultsCadoMonthConcluded[0]['Total']) : "0";
    $latemonthcado = !empty($resultsCadoMonthLate) ? strval($resultsCadoMonthLate[0]['Total']) : "0";
    $ontimemonthcado = !empty($resultsCadoMonthOntime) ? strval($resultsCadoMonthOntime[0]['Total']) : "0";
    $concludedyearcado = !empty($resultsCadoYearConcluded) ? strval($resultsCadoYearConcluded[0]['Total']) : "0";
    $lateyearcado = !empty($resultsCadoYearLate) ? strval($resultsCadoYearLate[0]['Total']) : "0";
    $ontimeyearcado = !empty($resultsCadoYearOntime) ? strval($resultsCadoYearOntime[0]['Total']) : "0";
    
    //Cante
    $concludedmonthcante = !empty($resultsCanteMonthConcluded) ? strval($resultsCanteMonthConcluded[0]['Total']) : "0";
    $latemonthcante = !empty($resultsCanteMonthLate) ? strval($resultsCanteMonthLate[0]['Total']) : "0";
    $ontimemonthcante = !empty($resultsCanteMonthOntime) ? strval($resultsCanteMonthOntime[0]['Total']) : "0";
    $concludedyearcante = !empty($resultsCanteYearConcluded) ? strval($resultsCanteYearConcluded[0]['Total']) : "0";
    $lateyearcante = !empty($resultsCanteYearLate) ? strval($resultsCanteYearLate[0]['Total']) : "0";
    $ontimeyearcante = !empty($resultsCanteYearOntime) ? strval($resultsCanteYearOntime[0]['Total']) : "0";

    //Cante total month
    $totalmonthcantejan = !empty($resultsTotalCanteJan) ? strval($resultsTotalCanteJan[0]['Jan']) : "0";
    $totalmonthcantefev = !empty($resultsTotalCanteFev) ? strval($resultsTotalCanteFev[0]['Fev']) : "0";
    $totalmonthcantemar = !empty($resultsTotalCanteMar) ? strval($resultsTotalCanteMar[0]['Mar']) : "0";
    $totalmonthcanteabr = !empty($resultsTotalCanteAbr) ? strval($resultsTotalCanteAbr[0]['Abr']) : "0";
    $totalmonthcantemai = !empty($resultsTotalCanteMai) ? strval($resultsTotalCanteMai[0]['Mai']) : "0";
    $totalmonthcantejun = !empty($resultsTotalCanteJun) ? strval($resultsTotalCanteJun[0]['Jun']) : "0";
    $totalmonthcantejul = !empty($resultsTotalCanteJul) ? strval($resultsTotalCanteJul[0]['Jul']) : "0";
    $totalmonthcanteago = !empty($resultsTotalCanteAgo) ? strval($resultsTotalCanteAgo[0]['Ago']) : "0";
    $totalmonthcanteset = !empty($resultsTotalCanteSet) ? strval($resultsTotalCanteSet[0]['Setem']) : "0";
    $totalmonthcanteout = !empty($resultsTotalCanteOut) ? strval($resultsTotalCanteOut[0]['Outub']) : "0";
    $totalmonthcantenov = !empty($resultsTotalCanteNov) ? strval($resultsTotalCanteNov[0]['Nov']) : "0";
    $totalmonthcantedez = !empty($resultsTotalCanteDez) ? strval($resultsTotalCanteDez[0]['Dez']) : "0";

    // Atribuir valores padrão se os resultados estiverem vazios
    //Cado
    if (empty($resultsCadoMonthConcluded)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCadoMonthLate)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCadoMonthOntime)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCadoYearConcluded)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCadoYearLate)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCadoYearOntime)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    //Cante
    if (empty($resultsCanteMonthConcluded)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCanteMonthLate)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCanteMonthOntime)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCanteYearConcluded)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCanteYearLate)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    if (empty($resultsCanteYearOntime)) {
        $month = $month;
        $year = $year;
        $names = $names;
    }
    //Total month cante
    if (empty($resultsTotalCanteJan)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteFev)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteMar)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteAbr)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteMai)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteJun)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteJul)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteAgo)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteSet)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteOut)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteNov)) {
        $year = $year;
        $names = $names;
    }
    if (empty($resultsTotalCanteDez)) {
        $year = $year;
        $names = $names;
    }

    if ($error) {
        header("Location: /admin/reports");
        exit;
    }

    $selector = $year;
    $page = new PageAdmin();
    $page->setTpl("reports", [
        "names" => $names,
        "month" => $month,
        "year" => $year,
        "selector" => $selector,
        "concludedmonthcado" => $concludedmonthcado,
        "latemonthcado" => $latemonthcado,
        "ontimemonthcado" => $ontimemonthcado,
        "concludedyearcado" => $concludedyearcado,
        "lateyearcado" => $lateyearcado,
        "ontimeyearcado" => $ontimeyearcado,
        "concludedmonthcante" => $concludedmonthcante,
        "latemonthcante" => $latemonthcante,
        "ontimemonthcante" => $ontimemonthcante,
        "concludedyearcante" => $concludedyearcante,
        "lateyearcante" => $lateyearcante,
        "ontimeyearcante" => $ontimeyearcante,
        "totalmonthcantejan" => $totalmonthcantejan,
        "totalmonthcantefev" => $totalmonthcantefev,
        "totalmonthcantemar" => $totalmonthcantemar,
        "totalmonthcanteabr" => $totalmonthcanteabr,
        "totalmonthcantemai" => $totalmonthcantemai,
        "totalmonthcantejun" => $totalmonthcantejun,
        "totalmonthcantejul" => $totalmonthcantejul,
        "totalmonthcanteago" => $totalmonthcanteago,
        "totalmonthcanteset" => $totalmonthcanteset,
        "totalmonthcanteout" => $totalmonthcanteout,
        "totalmonthcantenov" => $totalmonthcantenov,
        "totalmonthcantedez" => $totalmonthcantedez,
        "user" => $user->getValues(),
        "degree_damgs"=>$degree_damgs,
		"incidents"=>$incidents,
		"occurrences"=>$occurrences,
		"processs"=>$processs,
        "departments" => $departments,
        "success" => $success,
        "error" => $error,
    ]);
   
});






// $app->post('/admin/reports', function() use ($app) {
//     $success = isset($_GET['success']) && $_GET['success'] == 'true';
// 	$error = isset($_GET['error']) && $_GET['error'] == 'false';
// 	User::verifyLogin();
// 	$user = new User();
// 	$user = User::getFromSession();
// 	$departments = Department::getDepartments();
//     $names = $_POST['st_cante'];
//     $st_cante = $names;
//     $st_cado = $names;
//     $month = $_POST['month'];
//     $year = $_POST['year'];
//     // Chame a função para obter os dados do relatório
//     // $resultst_cante = Report::getStatusNotificationsByMonthCante($month, $year, $st_cante);
//     // $resultst_cado = Report::getStatusNotificationsByMonthCado($month, $year, $st_cado);
//     $resultsConcluida = Report::getStatusNotificationsByMonthCadoConcluido($month, $year, $st_cado);
//     // $results = $_GET['temporary_results'] = $resultsConcluida;
//     if (!$error && !empty($resultsConcluida)=="") {
//         $error = isset($_GET['error']) && $_GET['error'] == 'false';
//         header("Location: /admin/generate/report");
//         exit;
        
//     } else{
//     $concludedmonth = $resultsConcluida[0]['Total'];
//     $page = new PageAdmin();
// 	$page->setTpl("reports", [
//         "concludedmonth"=>$concludedmonth,
//         "user" => $user->getValues(),
//         "departments" => $departments,
//         "success" => $success,
//         "error" => $error,
//         // Redirecione para a página do relatório com os parâmetros na URL
//     // $app->redirect("/admin/reports/{$st_cante}?month={$month}&year={$year}");
//     ]);}
// });

// $app->post('/admin/reports', function() {
//     // Obtenha o corpo da solicitação
//     $requestData = file_get_contents('php://input');
//     var_dump($requestData);
//     exit;
//     // Verifique se há dados no corpo da solicitação
//     if(!empty($requestData)) {
//         // Parse dos dados
//         parse_str($requestData, $params);
    
//         // Verifique se os parâmetros foram recebidos corretamente
//         if(isset($params['st_cante']) && isset($params['month']) && isset($params['year'])) {
//             $st_cante = $params['st_cante'];
//             $month = $params['month'];
//             $year = $params['year'];
//             getStatusNotificationsByMonth($month, $year, $st_cante );
//             // Redirecione para a página do relatório com os parâmetros na URL
//             header("Location: /admin/report/{$department}?month={$month}&year={$year}");
//             exit;
//         } else {
//             // Se os parâmetros não estiverem presentes, retorne um erro ou redirecione para uma página de erro
//             header("HTTP/1.1 400 Bad Request");
//             echo 'Erro: Parâmetros ausentes';
//             exit;
//         }
//     } else {
//         // Se o corpo da solicitação estiver vazio, retorne um erro
//         header("HTTP/1.1 400 Bad Request");
//         echo 'Erro: Corpo da solicitação vazio';
//         exit;
//     }
// });


 
//  $app->post('/admin/reports', function() {
//     // Obtenha o corpo da solicitação
//     $requestData = file_get_contents('php://input');
    
//     // Verifique se há dados no corpo da solicitação
//     if(!empty($requestData)) {
//         // Parse dos dados
//         parse_str($requestData, $params);
    
//         // Verifique se os parâmetros foram recebidos corretamente
//         if(isset($params['st_cante']) && isset($params['month'])) {
//             $department = $params['st_cante'];
//             $month = $params['month'];
            
//             // Redirecione para a página do relatório com os parâmetros na URL
//             header("Location: /admin/report/{$department}?month={$month}");
//             exit;
//         } else {
//             // Se os parâmetros não estiverem presentes, retorne um erro ou redirecione para uma página de erro
//             header("HTTP/1.1 400 Bad Request");
//             echo 'Erro: Parâmetros ausentes';
//             exit;
//         }
//     } else {
//         // Se o corpo da solicitação estiver vazio, retorne um erro
//         header("HTTP/1.1 400 Bad Request");
//         echo 'Erro: Corpo da solicitação vazio';
//         exit;
//     }
// });

// $app->post('/admin/reports2', function() {
//     // Obtenha os parâmetros do formulário
  
// });


// $app->post('/admin/reports2(/)', function($array= array(2){["st_cante"]["month"]}) {
//     
//     $params = $array;
//     var_dump($params);
//     exit;
//     
//     if(isset($params['st_cante']) && isset($params['month'])) {
//         $department = $params['st_cante'];
//         $month = $params['month'];
        
//        
//         return $department->withRedirect("/admin/report/['st_cante']?month");
//     } else {
//       
//         header('Location: /admin/erro-404');
//         exit;
//     }
// });

// $app->post('/admin/reports2', function($request, $response) {
    
//     $params = $request->getParsedBody();
    
   
//     if(isset($params['st_cante']) && isset($params['month'])) {
//         $department = $params['st_cante'];
//         $month = $params['month'];
        
       
//         return $response->withRedirect("/admin/report/{$department}?month={$month}");
//     } else {
       
//         return $response->withStatus(400)->write('/admin/erro-404');
//     }
// });


// // Mapear as rotas para a função de retorno correspondente
// $app->map(['GET', 'POST'], '/admin/reports', function($request, $response) {
//     // Verificar o método HTTP da solicitação
//     if ($request->isGet()) {
//         // Se for uma solicitação GET, renderizar o formulário para gerar o relatório
//         // Código para renderizar o formulário...
//         return $response->write('Formulário para gerar relatório');
//     } elseif ($request->isPost()) {
//         // Se for uma solicitação POST, processar os dados do formulário
//         // Obtenha os parâmetros do formulário
//         $params = $request->getParsedBody();
        
//         // Verifique se os parâmetros foram recebidos corretamente
//         if(isset($params['st_cante']) && isset($params['month'])) {
//             $department = $params['st_cante'];
//             $month = $params['month'];
            
//             // Redirecione para a página do relatório com os parâmetros na URL
//             return $response->withRedirect("/admin/report/{$department}?month={$month}");
//         } else {
//             // Se os parâmetros não estiverem presentes, retorne um erro ou redirecione para uma página de erro
//             return $response->withStatus(400)->write('Erro: Parâmetros ausentes');
//         }
//     } else {
//         // Se for qualquer outro método, retorne um erro 405 (Method Not Allowed)
//         return $response->withStatus(405)->write('Método não permitido');
//     }
// });







// $app->get('/admin/reports(/)', function() {
//   $success = isset($_GET['success']) ? $_GET['success'] : 0;
//   $error = isset($_GET['error']) ? $_GET['error'] : 0;

//   $departments = Department::getDepartments();
//   $user = new User();
// 	$user = User::getFromSession();
//   $page = new PageAdmin();
//   $page->setTpl("index", array(
//     "user"=>$user->getValues(),
//     "departments" => $departments,
//     "success"=>$success,
//      "error"=>$error
//   ));
// });



// $app->get('/admin/reports(/)', function() {
//   $success = isset($_GET['success']) ? $_GET['success'] : 0;
//   $error = isset($_GET['error']) ? $_GET['error'] : 0;

//   $degree_damgs = Degree_damg::getDegree_damgs();

//   $page = new PageAdmin();
//   $page->setTpl("index", array(
//     "degree_damgs" => $degree_damgs,
//     "success"=>$success,
//      "error"=>$error
//   ));
// });
// $app->post('/admin/reports(/)', function() {
//   $notificacao = new Notificacao();
//   $notificacao->setData($_POST);
//   $notificacao->save();
//   $notificacao->sendNotification();

//   header('Location: /?success=1');
//   exit;

//    if ((int)$_FILES['file']['size'] > 0) {
//    if((int)$_FILES['file']['size'] < 4194304) {
//      $notificacao->save();
//      $notificacao->attachEmail($_FILES['file']);
//      $notificacao->sendNotification();
//        header('Location: /?success=1f');
//        exit;
//    }
//      header('Location: /?error=1');
//      exit;
//     }else {
//      $notificacao->save();
//      $notificacao->sendNotification();
//      header('Location: /?success=1');
//      exit;
//   }
// });


// $app->get("/admin/reports(/)", function () {
//   User::verifyLogin();
//   User::verifyLogin2();
//   User::verifyNoTele3();
//   $user = User::getFromSession();

//   $reports = Report::listAll();

//   $page = new PageAdmin();
//   $page->setTpl("reports", [
//     "reports" => $reports,
//     "user" => $user->getValues()
//   ]);
// });

// $app->get("/admin/reports/create(/)", function () {
//   User::verifyLogin();
//   User::verifyLogin2();
  
//   User::verifyNoTele3();
//   $user = new User();
//   $user = User::getFromSession();

//   $report = new Report();

//   $page = new PageAdmin();
//   $page->setTpl("reports-create", [
//     "user" => $user->getValues(),
//     "report" => $report->getImageCreate()
//   ]);
// });

// $app->post('/admin/reports/create(/)', function () {
//   User::verifyLogin();
//   User::verifyLogin2();
  
//   User::verifyNoTele3();
//   $report = new Report();
//   $report->setData($_POST);
//   $report->save();
//   if ((int)$_FILES["files"]["size"] > 0) {
//     $report->setPhotos($_FILES["files"], 1);
//   }
//   header("Location: /admin/reports/create");
//   exit;
// });

// $app->get("/admin/reports/:id_report/delete(/)", function ($id_report) {
//   User::verifyLogin();
//   User::verifyLogin2();
  
//   User::verifyNoTele3();
//   $report = new Report();
//   $report->get((int)$id_report);
//   $report->delete();

//   header("Location: /admin/reports");
//   exit;
// });

// $app->get("/admin/reports/:id_report(/)", function ($id_report) {
//   User::verifyLogin();
//   User::verifyLogin2();
  
//   User::verifyNoTele3();
//   $user = new User();
//   $user = User::getFromSession();

//   $report = new Report();
//   $report->get((int)$id_report);
//   $report->getPhotos();

//   $page = new PageAdmin();
//   $page->setTpl("reports-update", [
//     "user" => $user->getValues(),
//     "report" => $report->getValues(),
//     "reports" => $report->getPhotos()
//   ]);
// });

// $app->post("/admin/reports/:id_report(/)", function ($id_report) {
//   User::verifyLogin();
//   User::verifyLogin2();
  
//   User::verifyNoTele3();
//   $report = new Report();
//   $report->get((int)$id_report);
//   $report->setData($_POST);
//   $report->update();
//   $report->setPhotos($_FILES["files"], $id_report);

//   header("Location: /admin/reports/$id_report");
//   exit;
// });
