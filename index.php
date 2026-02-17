<?php 
$path_env = __DIR__ . '/.env';
if (file_exists($path_env)) {
    $env = parse_ini_file($path_env);
    foreach ($env as $key => $value) {
        putenv("$key=$value");
        $_ENV[$key] = $value; 
    }
}
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);


// Fix para compatibilidade do Slim 2 com PHP 8.2+
if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc() {
        return false; // Sempre falso, pois magic quotes não existem mais desde o PHP 5.4
    }
}

// PHP 8.3 - Atualizado para maior rigor de tipos e compatibilidade
session_start();

require_once("vendor/autoload.php");

// Importações mantidas (Certifique-se que as classes em /src usam PSR-4)
use Slim\Slim;
use Php\Page;
use Php\PageAdmin;

// $app = new Slim();
$app = new Slim(array(
    'debug' => false // Alterar para false em produção
));

// No PHP 8, o debug exibe erros de depreciação. 
// Mantenha true apenas em desenvolvimento.
$app->config('debug', true);

// Slim 2 usa Closures. No PHP 8.3, o escopo de variáveis dentro de use() continua igual.
$app->notFound(function () use ($app) {
    $page = new Page([
        "header" => true,
        "footer" => true
    ]);
    $page->setTpl('erro-404');
});

// Removi a duplicidade para evitar conflitos de renderização.
// Inclusão de arquivos de rotas
$routeFiles = [
    "admin.php", "admin-convenants.php", "admin-notifications.php",
    "admin-communications.php", "admin-events.php", "admin-birthdays.php",
    "admin-reports.php", "admin-popups.php", "admin-posts.php",
    "admin-ramais.php", "admin-department.php", "admin-unit.php", "admin-internacionalsecurity.php",
    "admin-patientsecurity.php", "admin-incident.php", "admin-conclusion.php",
    "admin-problem.php", "admin-consult.php", "admin-factoccurred.php",
    "admin-occurrence.php", "admin-degree_damg.php", "admin-subscriptions.php", "admin-security.php",
    "admin-users.php", "functions.php", "site.php"
];

foreach ($routeFiles as $file) {
    if (file_exists($file)) {
        require_once($file);
    }
}

$app->run();
