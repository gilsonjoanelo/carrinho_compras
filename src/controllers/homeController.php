<?php
include '../base/config.inc.php';
include '../base/token.inc.php';

$config = new Configuracao();
$token = new Token();
$tokenData = $token->getBearerToken();
$validacaoRetorno = $token->validateJWT($tokenData);
if($validacaoRetorno->isValido) {
    include '../models/produto.model.inc.php';
    include '../services/dao/produto.dao.inc.php';
    $dao = new ProdutoDao();

    if($config->getMethod() == "GET") {
        if($config->getMethodName() == "loadGridView") {
            try {
                $fields= $_GET["fields"];
                $orders= isset($_GET["order"]) ? $_GET["order"] : "id ASC";

                $retorno = $dao->retornarLista($fields, $orders);
                $config->setRetorno($retorno->mensagem, $retorno->mensagemTipo, $retorno->data);
            } catch (Exception $e) {
                $config->setErroInterno($e);
            }
        } else if($config->getMethodName() == "retornarItem") {
            try {
                if(isset($_GET["id"])){
                    $id = $_GET["id"];
                    if(is_int($id)) {
                        $retorno = $dao->retornarItem($id);
                        $config->setRetorno($retorno->mensagem, $retorno->mensagemTipo, $retorno->data);
                    } else {
                        $config->setRetorno("ID inválido. Verifique.", "E");
                    }
                } else {
                    $config->setRetorno("Parâmetros inválidos", "E");
                }
            } catch (Exception $e) {
                $config->setErroInterno($e);
            }
        }
    } else if($config->getMethod() == "POST" || $config->getMethod() == "PUT") {
        try {
            $data = file_get_contents('php://input');
            if($config->isJson($data)) {
                $retorno = $dao->salvarItem($data);
                $config->setRetorno($retorno->mensagem, $retorno->mensagemTipo);
            } else {
                $config->setRetorno("Os parâmetros informados não estão no formato correto", "E");
            }
        } catch (Exception $e) {
            $config->setErroInterno($e);
        }
    } else if($config->getMethod() == "DELETE") {
        try {
            if(isset($_GET["id"])){
                $id = $_GET["id"];
                if(is_int($id)) {
                    $retorno = $dao->excluirItem($id);
                    $config->setRetorno($retorno->mensagem, $retorno->mensagemTipo);
                } else {
                    $config->setRetorno("ID inválido. Verifique.", "E");
                }
            } else {
                $config->setRetorno("Parâmetros inválidos", "E");
            }
        } catch (Exception $e) {
            $config->setErroInterno($e);
        }
    } else {
        $config->setAcessoNegado();
    }
} else {
    $config->setTokenInvalido();
}