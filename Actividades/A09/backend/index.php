<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php'; 
require __DIR__ . '/Create/Create.php';
require __DIR__ . '/Read/Read.php';
require __DIR__ . '/Update/Update.php';
require __DIR__ . '/Delete/Delete.php';

$app = AppFactory::create();
$app->setBasePath('/tecweb/Actividades/A09/backend');  // ¡Añade esta línea después de crear $app!
$app->addBodyParsingMiddleware(); // Para leer JSON en las requests

//Mostrar todos los productos
$app->get('/products', function (Request $request, Response $response) {
    $read = new Backend\Read\Read();
    $result = $read->listProduct();
    $response->getBody()->write($result);
    return $response->withHeader('Content-Type', 'application/json');
});

//Buscar productos
$app->get('/products/{search}', function (Request $request, Response $response, array $args) {
    $read = new Backend\Read\Read();
    $result = $read->searchProduct($args['search']);
    $response->getBody()->write($result);
    return $response->withHeader('Content-Type', 'application/json');
});

//Obtener producto por ID
$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $read = new Backend\Read\Read();
    $result = $read->singleProduct($args['id']);
    $response->getBody()->write($result);
    return $response->withHeader('Content-Type', 'application/json');
});

//Crear producto (post)
$app->post('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $create = new Backend\Create\Create();
    $result = $create->addProduct(
        $data['nombre'],
        $data['marca'],
        $data['modelo'],
        $data['precio'],
        $data['detalles'],
        $data['unidades'],
        $data['imagen']
    );
    $response->getBody()->write($result);
    return $response->withHeader('Content-Type', 'application/json');
});

//Actualizar producto (put)
$app->put('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $update = new Backend\Update\Update();
    $result = $update->editProduct(
        $data['id'],
        $data['nombre'],
        $data['marca'],
        $data['modelo'],
        $data['precio'],
        $data['detalles'],
        $data['unidades'],
        $data['imagen']
    );
    $response->getBody()->write($result);
    return $response->withHeader('Content-Type', 'application/json');
});

//Eliminar producto (delete)
$app->delete('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $delete = new Backend\Delete\Delete();
    $result = $delete->deleteData($data['id']);
    $response->getBody()->write($result);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();