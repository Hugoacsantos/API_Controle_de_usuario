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
    var_dump($list);

    return $response;
});

$app->post('/create', function (Request $request, Response $response, $args) use ($user){
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];
    $id = '';
    $newUser = new User($id,$nome,$email);
    $user->create($newUser);

    echo 'Inserido';
    return $response;
});

$app->put('/update/{id}',function (Request $request, Response $response, $args) use ($user){
    // $id = $request->getQueryParams()['id'];
    $id = $args['id'];
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];

    $newUser = new User($id,$nome,$email);
    $user->update($newUser);

    echo 'Atualizado com sucesso';
    return $response;
});

$app->delete('/delete/{id}',function (Request $request, Response $response, $args) use ($user){
    $id = $args['id'];

    $user->delete($id);

    echo 'Excluido';
    return $response;
});



$app->run();