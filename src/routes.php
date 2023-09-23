<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use src\User;
use src\UserDao;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$user = new UserDao($pdo);


$app->get('/', function (Request $request, Response $response, $args) use ($user) {
    $list = $user->listAll();
    $list = json_encode($list);
    // print_r(json_encode($list));
    $response->getBody()->write($list);
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->post('/create', function (Request $request, Response $response, $args) use ($user){
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];
    $id = '';
    $newUser = new User($id,$nome,$email);
    $user->create($newUser);

    return $response->withStatus(201);
});

$app->put('/update/{id}',function (Request $request, Response $response, $args) use ($user){
    // $id = $request->getQueryParams()['id'];
    $id = $args['id'];
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];

    $newUser = new User($id,$nome,$email);
    $user->update($newUser);

    return $response->withStatus(204);
});

$app->delete('/delete/{id}',function (Request $request, Response $response, $args) use ($user){
    $id = $args['id'];

    $user->delete($id);

    return $response->withStatus(200);
});



$app->run();