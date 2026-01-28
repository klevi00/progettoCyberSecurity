<?php

namespace Controller;

use Model\ProdottoRepository;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Util\Authenticator;

class AdminController{

    private $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listAll(Request $request, Response $response, array $args): Response
    {
        $engine = $this->container->get('template');
        $prodotti = ProdottoRepository::listAll();
        $response->getBody()->write($engine->render('pannelloAdmin',
            [
                'prodotti' => $prodotti
            ]
        ));
        return $response;
    }

    public function formProdotto(Request $request, Response $response, array $args): Response
    {
        $engine = $this->container->get('template');
        $prodotto = null;
        if ($args != null)
            $prodotto = ProdottoRepository::getProdotto($args['id']);
        $response->getBody()->write($engine->render('formProdotto',
            [
                'prodotto' => $prodotto
            ])
        );
        return $response;
    }

    public function addProdotto(Request $request, Response $response, array $args): ?Response{
        $params = (array)$request->getParsedBody();

        $directory = $this->container->get('images');

        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['immagine'];
        $name = sha1($uploadedFile->getClientFilename() . rand()) . '.jpg';
        //Viene aggiunto il nome dell'immagine per poterla memorizzare nel DB
        $params['image'] = $name;


        $filename = $directory . '/' . $name;
        
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

            $uploadedFile->moveTo($filename);

            if ($args != null)
                ProdottoRepository::update($args['id'], $params);
            else
                ProdottoRepository::add($params);
        }
        $response = $response->withStatus(302);
        return $response->withHeader('Location', BASE_PATH . '/admin');
    }

    public function deleteProdotto(Request $request, Response $response, array $args): Response{
        $id = $args['id'];
        ProdottoRepository::delete($id);
        $response = $response->withStatus(302);
        return $response->withHeader('Location', BASE_PATH . '/admin');
    }

    public function login(Request $request, Response $response, array $args): Response{
        $engine = $this->container->get('template');
        $response->getBody()->write($engine->render('login'));
        return $response;
    }

    public function logout(Request $request, Response $response, array $args): Response{
        Authenticator::logout();
        $response = $response->withStatus(302);
        return $response->withHeader('Location', BASE_PATH . '/negozio');
    }
}
