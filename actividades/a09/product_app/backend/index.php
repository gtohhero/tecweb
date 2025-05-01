<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    use TecWeb\MyApi\Read\Read as Read;
    use TecWeb\MyApi\Create\Create as Create;
    use TecWeb\MyApi\Update\Update as Update;
    use TecWeb\MyApi\Delete\Delete as Delete;

    require 'vendor/autoload.php';
    
    $app = AppFactory::create();
    $app->setBasepath("/tecweb/actividades/a09/product_app/backend");

    // ->

    $app->get('/products', function($request, $response, $args){
        $productos = new Read('bookstore');
        $productos->list();
        $data = $productos->getData();
        
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/products/{search}', function($request, $response, $args){
        $search = $args['search'];

        $productos = new Read('bookstore');
        $productos->search($search);
        $data = $productos->getData();
        
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/product/{id}', function($request, $response, $args){
        $id = $args['id'];

        $productos = new Read('bookstore');
        $productos->single($id);
        $data = $productos->getData();
        
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/product', function ($request, $response, $args) {
        $data = json_decode($request->getBody()->getContents(), true);

        $productos = new Create('bookstore');
        $productos->add( json_decode( json_encode($data) ) );
        $response->getBody()->write($productos->getData());
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->put('/product', function ($request, $response, $args) {
        $data = json_decode($request->getBody()->getContents(), true);

        $productos = new Update('bookstore');
        $productos->edit( json_decode( json_encode($data) ) );
        $response->getBody()->write($productos->getData());
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->delete('/product', function ($request, $response, $args) {
        $data = json_decode($request->getBody()->getContents(), true);

        $productos = new Delete('bookstore');
        $productos->delete($data);
        $response->getBody()->write($productos->getData());
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->run();
?>