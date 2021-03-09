<?php
include '../base/config.inc.php';

$config = new Configuracao();
if($config->getMethod() == "POST") {
    if($config->getMethodName() == "efetuarLogin") {
        try {
            $data = file_get_contents('php://input');
            if($config->isJson($data)) {
                include '../services/dao/usuario.dao.inc.php';
                $dao = new UsuarioDao();
                $retorno = $dao->efetuarLogin($data, $config);
                if($retorno->Sucesso) {
                    include '../base/token.inc.php';
                    $token = new Token();
                    $retorno->data = $token->createJWT($retorno->data->UsuarioID, $retorno->data->UsuarioNome);
                }
                $config->setRetorno($retorno->Mensagem, $retorno->MensagemTipo, $retorno->data);
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
                include '../services/dao/usuario.dao.inc.php';
                $dao = new UsuarioDao();
                $retorno = $dao->cadastrarUsuario($data);
                $config->setRetorno($retorno->Mensagem, $retorno->MensagemTipo);
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