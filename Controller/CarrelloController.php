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
        setcookie($prodotto['id'], $prodotto['nome'] . ":" . $prodotto['prezzo'], [
                    'expires' => time() + 60*60*24*30,
                    'path'    => '/'
                ]);

        $response->getBody()->write($engine->render('carrelloAggiunta',
            [
                'nome' => $prodotto['nome'],  

            ]
        ));
        return $response;
    }

    public function showCarrello(Request $request, Response $response, array $args): Response
{
    $engine = $this->container->get('template');
    $cookieSessione = "PHPSESSID";
    $carrello = [];
    $totalePrezzo = 0;
    foreach ($_COOKIE as $idProdotto => $valore) {

        if ($idProdotto === $cookieSessione) {
            continue;
        }

        $decoded = urldecode($valore);
        [$nome, $prezzo] = explode(":", $decoded);

        $carrello[] = [
            'id'     => $idProdotto,
            'nome'   => $nome,
            'prezzo' => (float) $prezzo
        ];
        $totalePrezzo += $prezzo;
    }

    if (empty($carrello)) {
        //Metto l'errore
    }

    $response->getBody()->write($engine->render('carrello', [
            'carrello' => $carrello,
            'totale' => $totalePrezzo
        ])
    );

    return $response;
}


}