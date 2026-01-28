<?php

namespace Controller;

use Model\ProdottoRepository;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CarrelloController
{

    private $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function addProdotto(Request $request, Response $response, array $args): Response
    {
        $engine = $this->container->get('template');
        $prodotto = ProdottoRepository::getProdotto($args['id']);
        setcookie($prodotto['id'], $prodotto['nome'] . ":" . $prodotto['prezzo'], time()+60*60*24*30);
        $response->getBody()->write($engine->render('carrello',
            [
                'nome' => $prodotto['nome'],  

            ]
        ));
        return $response;
    }

     public function addProdotto(Request $request, Response $response, array $args): Response{
        $_COOKIE
     }
}