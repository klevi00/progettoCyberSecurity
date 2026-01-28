<?php

use Controller\AdminController;
use DI\Container as Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Factory\AppFactory;


use Controller\ProdottoController;
use Controller\CarrelloController;




require 'vendor/autoload.php';
require_once  'conf/config.php';
use League\Plates\Engine;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Util\Authenticator;

$container = new Container();

// Da inserire prima della create di AppFactory
AppFactory::setContainer($container);

$app = AppFactory::create();

//Questa parte deve contenere il percorso della
//sottocartella dove si trova l'applicazione in questo caso inserito nella
//variabile di configurazione BASE_PATH
$app->setBasePath(BASE_PATH);

$container->set('template', function (){
    $engine = new Engine('templates', 'tpl');
    $engine->addData(['base_path' => BASE_PATH]);
    $user = Authenticator::getUser();
    $username = isset($user['username']) ? $user['username'] : null;
    $engine->addData(['user' => $username]);
    return $engine;
});

$container->set('images', IMAGES);

//Gestione del middleware di autenticazione

$authMiddleware = function(Request $request, RequestHandler $handler) use ($app): Response {

    $routeName = $request->getUri()->getPath();

    // Route della parte pubblica
    $publicRoute = BASE_PATH . '/negozio';

    //Se è una route pubblica non fa nulla
    if (str_starts_with($routeName, $publicRoute)) {
        return $handler->handle($request);
    }

    $user = Authenticator::getUser();

    if ($routeName === BASE_PATH . '/login') {
        return $handler->handle($request);
    }
    if ($routeName === BASE_PATH . '/') {
        return $handler->handle($request);
    }
    if ($user !== null) {
        //Vengono "agganciate" le informazioni sul nome
        $request = $request->withAttribute('user', $user);
        return $handler->handle($request);
    }
    else{
        throw new HttpUnauthorizedException($request);
    }

};

$app->add($authMiddleware);

$app->addRoutingMiddleware();


// Define Custom Error Handler
$customErrorHandler = function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $engine = $app->getContainer()->get('template');

    if ($exception instanceof \Slim\Exception\HttpNotFoundException) {
        $response->getBody()->write(
            $engine->render('404', $payload)
        );
    }else if($exception instanceof HttpUnauthorizedException){
        $response->getBody()->write(
            $engine->render('non_autorizzato', [])
        );
    }
    return $response;
};

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
if (MY_ERROR_HANDLER)
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);



//Esempi di route

$app->get('/', ProdottoController::class . ':listAll');

$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write('Hello ' . $name);
    return $response;
});


$app->get('/saluti/{name}', function (Request $request, Response $response, $args) {
    $template = $this->get('template');
    $response->getBody()->write($template->render('saluti',
            [
                'name' => $args['name']
            ]
        )
    );
    return $response;
});

$app->get('/negozio',ProdottoController::class . ':listAll');

$app->get('/negozio/genere/{genere}', ProdottoController::class . ':listAllByGenre');

$app->get('/admin', AdminController::class . ':listAll');

$app->get('/admin/prodotto[/{id}]', AdminController::class . ':formProdotto');

$app->post('/admin/prodotto[/{id}]', AdminController::class . ':addProdotto');

$app->get('/admin/prodotto/{id}/delete', AdminController::class . ':deleteProdotto');

$app->get('/negozio/prodotto[/{id}]', ProdottoController::class . ':showProdotto');

$app->get('/negozio/carrello/add/{id}', CarrelloController::class . ':addProdotto');


//Parte per l'autenticazione

$app->get('/login', AdminController::class . ':login');

$app->post('/auth', AdminController::class . ':listAll');

$app->get('/logout', AdminController::class . ':logout');


$app->run();
