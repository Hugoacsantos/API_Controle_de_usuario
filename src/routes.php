<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use src\Endereco;
use src\EnderecoDao;
use src\EnderecoServices;
use src\User;
use src\UserDao;
use src\UserServices;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$userDao = new UserDao($pdo);
$userServices = new UserServices($userDao);
$Endereco = new EnderecoDao($pdo);
$EnderecoServices = new EnderecoServices($Endereco,$userDao);

$app->get('/', function (Request $request, Response $response, $args) use ($userServices) {
    
    $response->getBody()->write($userServices->listAll());
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

});

$app->post('/create', function (Request $request, Response $response, $args) use ($userServices){
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];
    $id = '';
    $newUser = new User($id,$nome,$email);
    $userServices->add($newUser);

    return $response->withStatus(201);
});

$app->put('/update/{id}',function (Request $request, Response $response, $args) use ($userServices){
    $id = $args['id'];
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];

    $newUser = new User($id,$nome,$email);
    $userServices->update($newUser);

    return $response->withStatus(204);
});

$app->delete('/delete/{id}',function (Request $request, Response $response, $args) use ($userServices){
    $id = $args['id'];

    $userServices->delete($id);

    return $response->withStatus(200);
});


$app->get('/user/{id}', function(Request $request, Response $response, $args) use ($userServices, $EnderecoServices) {
    $id = $args['id'];
    $us = $userServices->get($id);
    $end = $EnderecoServices->find($id);
    $endereco = new Endereco($end['id_user'],$end['rua'],$end['numero'],$end['bairro'],$end['cidade'],$end['estado']);
    $endereco->id = $end['id'];
    $user = new User($us['id'],$us['nome'],$us['email'],$endereco);
    
    print_r(json_encode($user));
    
    return $response->withStatus(200);
});

$app->delete('/delete/endereco/{id}', function (Request $request, Response $response, $id) {

    

});

$app->run();