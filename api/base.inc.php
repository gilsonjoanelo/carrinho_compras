<?php
if (substr_count($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}

header('Content-Type: text/html; charset=utf-8');
// header('Content-Type: */*; charset=utf-8');
date_default_timezone_set("America/Sao_Paulo");

error_reporting(E_ALL | E_STRICT);

// configuração da sessão
session_name(md5('seg' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
session_cache_expire(60);
session_start();

function ativarCors()
{
    // configuração de bloqueio de acesso
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        // header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    // se informar o METHOD OPTOPIONS, retorna os métodos permitidos na api
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}
