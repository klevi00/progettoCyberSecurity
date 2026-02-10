<?php

namespace Util;

use Model\UserRepository;

/**
 * Classe per gestire l'autenticazione
 */
class Authenticator{

    private function __construct()
    {
    }

    /**

     */
    private static function start(): void
    {
        if (session_id() == "")
            session_start();
        /*
        if (session_id() !== "") 
            return;
        }
        ini_set('session.use_strict_mode', '1');   // rifiuta session id non emessi dal server
        ini_set('session.use_only_cookies', '1');  // niente session id in URL
        ini_set('session.use_trans_sid', '0');     // niente inserimento SID nei link html
        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        session_set_cookie_params([
            'httponly' => true,     // cookie non accessibile da js
            'secure' => $isHttps,   // cookie viaggia solo su HTTPS
            'samesite' => 'Lax',    // limita l'invio del cookie in richieste cross-site
        ]);
        session_start();*/
           
    }

    public static function getUser():array|null{
        self::start();
        //Controllo se è in corso un tentativo di login
        //verificando la presenza dello username spedito tramite POST

        if (isset($_POST['username'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            //Verifica se le credenziali sono corrette
            $row = UserRepository::userAuthentication($username, $password);
            //Se non sono valide ritorna false
            if ($row != null) {
                //Memorizza nelle variabili di sessione tutti gli
                //attributi di un utente, ritornati dalla funzione precedente
                $_SESSION['user'] = $row;
                // Mitigazione principale contro session fixation:
                // dopo un cambio di privilegio (anonimo -> autenticato) rigenera l'id sessione
                session_regenerate_id(true);
            }
        }
        //Se non è attiva una sessione ritorna falso
        if (!isset($_SESSION['user']))
                return null;
        return $_SESSION['user'];
    }

    public static function logout(): void
    {
        self::start();
        //Distrugge la sessione per evitare che parti successive del codice
        //nello stesso script la utilizzino
        $_SESSION = [];
        //Distrugge la sessione sul server
        session_destroy();
    }


}