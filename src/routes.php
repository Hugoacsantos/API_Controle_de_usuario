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
    
    print_r(json_encode($userServices->listAll()));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

});

$app->post('user/create', function (Request $request, Response $response, $args) use ($userServices){
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];
    $id = '';
    $newUser = new User($id,$nome,$email);
    $userServices->add($newUser);

    return $response->withStatus(201);
});


$app->put('user/update/{id}',function (Request $request, Response $response, $args) use ($userServices){
    $id = $args['id'];
    $data = $request->getParsedBody();
    $nome = $data['nome'];
    $email = $data['email'];

    $userUpdate = new User($id,$nome,$email);
    $userServices->update($userUpdate);

    return $response->withStatus(200);
});

$app->delete('user/delete/{id}',function (Request $request, Response $response, $args) use ($userServices){
    $id = $args['id'];
    $userServices->delete($id);
    return $response->withStatus(200);
});


$app->get('/user/{id}', function(Request $request, Response $response, $args) use ($userServices, $EnderecoServices) {
    $id = $args['id'];
    $useDb = $userServices->get($id);
    $endrecoDb = $EnderecoServices->find($id);
    $endereco = new Endereco($endrecoDb['id_user'],$endrecoDb['rua'],$endrecoDb['numero'],$endrecoDb['bairro'],$endrecoDb['cidade'],$endrecoDb['estado']);
    $endereco->id = $endrecoDb['id'];
    $user = new User($useDb['id'],$useDb['name'],$useDb['email'],$endereco);
    
    print_r(json_encode($user));
    
    return $response->withStatus(200);
});

// Endereços 


$app->get('/endereco/{id}', function(Request $request, Response $response, $args) use ($userServices, $EnderecoServices) {
    $id = $args['id'];
    $user = $userServices->getWithAdress($id);
    $endereco = $EnderecoServices->listAllAdrass($id);
    print_r(json_encode($user));
    return $response->withStatus(200);
});

$app->post('endereco/create/{id}', function(Request $request, Response $response, $args) use($EnderecoServices) {
    $iduser = $args['id'];
    $data = $request->getParsedBody();
    $rua = $data['rua'];
    $numeracao = $data['numeracao'];
    $bairro = $data['bairro'];
    $cidade = $data['cidade'];
    $estado = $data['estado'];
    $endereco = new Endereco($iduser,$rua,$numeracao,$bairro,$cidade,$estado);

    $EnderecoServices->create($iduser,$endereco);

    return $response->withStatus(201);

});

$app->delete('endereco/delete/{id}', function (Request $request, Response $response, $args) use ($userServices, $EnderecoServices) {
    $id = $args['id'];
    $user = $userServices->get($id);
    $EnderecoServices->find($user->id);
    $EnderecoServices->remove($id,$user->endereco);   

    return $response->withStatus(200);
});

$app->run();