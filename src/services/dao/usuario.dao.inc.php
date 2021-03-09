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
                $retorno->Sucesso = true;
            } else {
                $retorno->Mensagem = "Usuário não encontrado";
            }
        } else {
            $retorno->Mensagem = "Nenhum usuário encontrado para os dados informados";
        }
        return $retorno;
    }

    public function cadastrarUsuario($data) {
        $retorno = parent::getRetorno();
        
        return $retorno;
    }
}