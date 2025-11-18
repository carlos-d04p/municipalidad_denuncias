<?php
require_once "config/Config.php";

spl_autoload_register(function($class) {
    if (file_exists("Controllers/" . $class . ".php")) {
        require_once "Controllers/" . $class . ".php";
    } elseif (file_exists("Models/" . $class . ".php")) {
        require_once "Models/" . $class . ".php";
    } elseif (file_exists("config/" . $class . ".php")) {
        require_once "config/" . $class . ".php";
    }
});

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = !empty($_GET['url']) ? $_GET['url'] : 'denuncias/index'; 
$arrUrl = explode("/", $url); 

$controller = $arrUrl[0];
$method = $arrUrl[1] ?? 'index'; 
$params = array_slice($arrUrl, 2);
$controllerName = $controller . "Controller"; 

if (file_exists("Controllers/" . $controllerName . ".php")) {
    $controller = new $controllerName();
    
    if (method_exists($controller, $method)) {
        $controller->{$method}($params);
    } else {
        die("Error: Método '$method' no encontrado en el controlador.");
    }
} else {
    die("Error: Controlador '$controllerName' no encontrado.");
}
?>