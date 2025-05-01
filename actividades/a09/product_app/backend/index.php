<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    require 'vendor/autoload.php';
    
    $app = AppFactory::create();
    $app->setBasepath("/tecweb/actividades/a09/product_app/backend");

    $app->run();
?>