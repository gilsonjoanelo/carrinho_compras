<?php
class Configuracao
{
    private $method = "";
    private $methodName = "";
    private $sessionName = "";

    function __construct()    
    {
        $this->definirConfiguracao();
        $this->enableCors();
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getMethodName()
    {
        return $this->methodName;
    }

    public function setAcessoNegado()
    {
        http_response_code(405);
        $resultCode = new stdClass();
        $resultCode->sucesso = false;
        $resultCode->mensagem = "O método selecionado não é permitido";
        $resultCode->mensagemTipo = "E";

        echo json_encode($resultCode);
    }

    public function setNaoEncontrado()
    {
        http_response_code(404);
        $resultCode = new stdClass();
        $resultCode->sucesso = false;
        $resultCode->mensagem = "Você tentou acessar um recurso não disponível";
        $resultCode->mensagemTipo = "E";

        echo json_encode($resultCode);
    }

    public function setTokenInvalido()
    {
        http_response_code(401);
        $resultCode = new stdClass();
        $resultCode->sucesso = false;
        $resultCode->mensagem = "Token de autenticação expirado";
        $resultCode->mensagemTipo = "E";
    
        echo json_encode($resultCode);
    }

    public function setErroInterno($e)
    {
        http_response_code(200);
        $resultCode = new stdClass();
        $resultCode->sucesso = false;
        $resultCode->mensagem = "Ocorreu um falha não tratada na execução de sua solicitação. Tente novamente.";
        $resultCode->mensagemProgramador = $e->getMessage();
        $resultCode->mensagemTipo = "E";
    
        echo json_encode($resultCode);
    }

    public function isJson($jsonData)
    {
        $testeJson = json_decode($jsonData);
        $sucesso = json_last_error() === JSON_ERROR_NONE;
        if (! $sucesso) {
            echo json_last_error_msg();
        }
        return $sucesso;
    }

    public function setRetorno($mensagem, $mensagemTipo, $dados = null)
    {
        http_response_code(200);
        $resultCode = new stdClass();
        $resultCode->sucesso = $mensagemTipo !== "E";
        $resultCode->mensagem = $mensagem;
        $resultCode->mensagemTipo = $mensagemTipo;
        if ($dados != null) {
            $resultCode->dados = $dados;
        }
        echo json_encode($resultCode);
    }

    public function getSenhaHash($senha)
    {
        $options = [
            'cost' => 11
        ];
        return password_hash($senha, PASSWORD_BCRYPT, $options);
    }
    
    public function isSenhaValida($senha, $hash)
    {
        return password_verify($senha, $hash);
    }

    private function definirConfiguracao()
    {
        // padrões e configurações
        header('Content-Type: text/html; charset=utf-8');
        date_default_timezone_set("America/Sao_Paulo");
        error_reporting(E_ALL | E_STRICT);

        //configura a sessão
        $this->sessionName = md5('seg' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
        session_name($this->sessionName);
        session_cache_expire(60);
        session_start();

        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->methodName = $_GET["methodName"];
    }

    private function enableCors()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            // header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            exit(0);
        }
    }
}
