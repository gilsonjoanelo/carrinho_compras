<?php
include '../services/database.inc.php';

class UsuarioDao extends Database {
    
    function __construct() {
        parent::__construct();
    }

    public function efetuarLogin($data, $config) {
        $json = json_decode($data);

        $retorno = parent::getRetorno();
        $retorno->data = null;
        $usuario = "'" . $json->usuario . "'";
        $sql = "SELECT ";
        $sql .= "id, nome, senha ";
        $sql .= "FROM usuarios WHERE UPPER(login) = UPPER($usuario) LIMIT 1";
        $stmp = parent::getConexao()->prepare($sql);
        $stmp->execute();
        $row = $stmp->fetchObject('stdClass');
        if ($row) {
            if ($config->IsSenhaValida($json->senha, $row->senha)) {
                $retorno->data = new stdClass();
                $retorno->data->UsuarioID = $row->id;
                $retorno->data->UsuarioNome = $row->nome;
                $retorno->sucesso = true;
                $retorno->mensagemTipo = "C";
            } else {
                $retorno->mensagem = "Usuário não encontrado";
            }
        } else {
            $retorno->mensagem = "Nenhum usuário encontrado para os dados informados";
        }
        return $retorno;
    }

    public function cadastrarUsuario($data, $config) {
        $retorno = parent::getRetorno();
        $json = json_decode($data);

        if(!filter_var($json->email, FILTER_VALIDATE_EMAIL)){
            $retorno->mensagem = "O e-mail informado não é válido";
        } else if($this->validarUsuario($json->nome)) {
            $retorno->mensagem = "Já existe um usuário cadastrado para o Usuário informado";
        } else if ($this->validarEmail($json->email)) {
            $retorno->mensagem = "Já existe um usuário cadastrado para o E-mail informado";
        } else {
            $sql = "INSERT INTO usuarios( ";
            $sql .= "nome, email, senha, login ";
            $sql .= ") VALUES (?, ?, ?, ?)";
            $senha = $config->getSenhaHash($json->senha);

            $stmt = parent::getConexao()->prepare($sql);
            $stmt->bindParam(1, $json->nome);
            $stmt->bindParam(2, $json->email);
            $stmt->bindParam(3, $senha);
            $stmt->bindParam(4, $json->usuario);
          
            $stmt->execute();
            if( $stmt->rowCount() > 0) {
                $retorno->mensagemTipo = "RI";
                $retorno->sucesso = true;
            } else {
                $retorno->mensagem = "Ocorreu uma falha na tentativa de cadastrar o usuário";
            }
        }
        return $retorno;
    }

    private function validarUsuario($login) {
        $usuario = "'" . $login . "'";

        $sql = "SELECT ";
        $sql .= "COUNT(id) id ";
        $sql .= "FROM usuarios WHERE UPPER(login) = UPPER($usuario) LIMIT 1";
        $stmp = parent::getConexao()->prepare($sql);
        $stmp->execute();
        $row = $stmp->fetchObject('stdClass');
        if ($row) {
            return $row->id > 0;
        } else {
            return false;
        }
    }

    private function validarEmail($mail) {
        $email = "'" . $mail . "'";

        $sql = "SELECT ";
        $sql .= "COUNT(id) id ";
        $sql .= "FROM usuarios WHERE UPPER(email) = UPPER($email) LIMIT 1";
        $stmp = parent::getConexao()->prepare($sql);
        $stmp->execute();
        $row = $stmp->fetchObject('stdClass');
        if ($row) {
            return $row->id > 0;
        } else {
            return false;
        }
    }
}