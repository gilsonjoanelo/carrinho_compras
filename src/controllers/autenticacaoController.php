<?php
require '../base/config.inc.php';

$config = new Configuracao();
if($config->getMethod() == "POST") {
    if($config->getMethodName() == "efetuarLogin") {
        try {
            $_SESSION["CAR_LOGADO"] = "F";
            $data = file_get_contents('php://input');
            if($config->isJson($data)) {
                require '../services/dao/usuario.dao.inc.php';
                $dao = new UsuarioDao();
                $retorno = $dao->efetuarLogin($data, $config);
                if($retorno->sucesso) {
                    require '../base/token.inc.php';
                    $token = new Token();
                    $tokenValue = $token->createJWT($retorno->data->UsuarioID, $retorno->data->UsuarioNome);
                    $config->setRetorno($retorno->mensagem, $retorno->mensagemTipo, $tokenValue);

                    $_SESSION["CAR_LOGADO"] = "T";
                } else {
                    $config->setRetorno($retorno->mensagem, $retorno->mensagemTipo);
                }
            } else {
                $config->setRetorno("Os parâmetros informados não estão no formato correto", "E");
            }
        } catch (Exception $e) {
            $config->setErroInterno($e);
        }
    } else if($config->getMethodName() == "cadastrarUsuario") {
        try {
            $data = file_get_contents('php://input');
            if($config->isJson($data)) {
                require '../services/dao/usuario.dao.inc.php';
                $dao = new UsuarioDao();
                $retorno = $dao->cadastrarUsuario($data, $config);
                $config->setRetorno($retorno->mensagem, $retorno->mensagemTipo);
            }
        } catch (Exception $e) {
            $config->setErroInterno($e);
        }
    } else {
        $config->setNaoEncontrado();
    }
} else {
    $config->setAcessoNegado();
}