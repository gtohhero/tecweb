<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    require 'vendor/autoload.php';
    
    $app = AppFactory::create();
    $app->setBasepath("/tecweb/practicas/p13");

    $app->get('/', function($request, $response, $args) {
        $response->getBody()->write("Hola, Mundo Slim");
        return $response;
    });

    $app->get("/hola[/{nombre}]", function($request, $response, $args) {
        $response->getBody()->write("Hola, " . $args["nombre"]);
        return $response;
    });

    $app->post('/pruebapost', function($request, $response, $args) {
        $reqPost = $request->getParsedBody();
        $val1 = $reqPost["val1"];
        $val2 = $reqPost["val2"];
        
        $response->getBody()->write("Valores: " . $val1 . " " . $val2);
        return $response;
    });

    //VIDEO - GET
    $app->get("/testjson", function($request, $response, $args) {
        $data[0]["nombre"]="Francisco";
        $data[0]["apellidos"]="Zatarain Amador";
        $data[1]["nombre"]="Jose Efren";
        $data[1]["apellidos"]="Sanchez Lopez";
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));

        return $response;
    });

    //EVIDENCIAS - POST
    $app->post('/jsontest', function($request, $response, $args) {
        $reqPost = $request->getParsedBody();

        $data[0]["nombre"]=$reqPost["name1"];
        $data[0]["apellidos"]=$reqPost["lstname1"];
        $data[1]["nombre"]=$reqPost["name2"];
        $data[1]["apellidos"]=$reqPost["lstname2"];
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));

        return $response;
    });

    $app->run();
?>