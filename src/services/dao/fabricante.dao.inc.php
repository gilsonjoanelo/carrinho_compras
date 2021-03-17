<?php
require '../services/database.inc.php';
class FabricanteDao extends Database {
    function __construct() {
        parent::__construct();
    }

    public function retornarLista($colunas, $ordenacao) {
        $retorno = parent::getRetorno();
        $retorno->data = null;

        $sql = "SELECT ";
        $sql .= "COUNT(id) id ";
        $sql .= "FROM fornecedores ";
        
        $stmp = parent::getConexao()->prepare($sql);
        $stmp->execute();
        $row = $stmp->fetchObject('FabricanteVM');
        if($row) {
            $retorno->rowsCount = $row->id;
        }

        if($retorno->rowsCount > 0) {
            $sql = "SELECT $colunas ";
            $sql .= "FROM fornecedores ";
            $sql .= "ORDER BY $ordenacao ";
            $stmp = parent::getConexao()->prepare($sql);
            $stmp->execute();

            $produtos = $stmp->fetchAll(PDO::FETCH_CLASS, 'FabricanteVM');
            if ($produtos) {
                $data = array();
                while($row = $produtos) {
                    array_push($data, $row);
                }
                setRetorno("", "C", $data);
            } else {
                $retorno->mensagem = "Nenhum fabricante cadastrado para os parâmetros informados";
            }
        } else {
            $retorno->mensagem = "Nenhum fabricante cadastrado";
        }
        return $retorno;
    }

    public function retornarItem($id) {
        $retorno = parent::getRetorno();
        $retorno->data = null;

        $sql = "SELECT $colunas ";
        $sql .= "FROM fornecedores ";
        $sql .= "WHERE id = :id ";
        $sql .= "ORDER BY $ordenacao ";
        $stmp = parent::getConexao()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmp->execute();

        $produto = $stmp->fetchObject('FabricanteVM');
        if ($produto) {
            setRetorno("", "C", $produto);
        } else {
            $retorno->mensagem = "Fabricante não encontrado";
        }
        return $retorno;
    }

    public function excluirItem($id) {
        $retorno = parent::getRetorno();
        $retorno->data = null;

        $sql = "DELETE FROM fornecedores WHERE id = :id ";
        $stmt = parent::getConexao()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $retorno->mensagemTipo = "RD";
            $retorno->mensagem = "Item excluido com sucesso";
        } else {
            $retorno->mensagemTipo = "FD";
            $retorno->mensagem = "Ocorreu uma falha na tentativa de excluir o item";
        }
        return $retorno;
    }

    public function salvarItem($dados) {
        $json = json_decode($data);
        if ($dados->id === 0) {
            $sql = "INSERT INTO fornecedores (nome) VALUES(:nome)";
        }else {
            $sql = "UPDATE fornecedores SET nome=:nome WHERE id=:id";
        }

        $stmt = parent::getConexao()->prepare($sql);
        if ($dados->id === 0) {
            $stmt->bindParam(':id', $json->id);
        }
        $stmt->bindParam(':nome', $json->nome);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $retorno->mensagemTipo = $dados->id === 0 ? "RI" : "RU";
            $retorno->mensagem = $dados->id === 0 ? "Item incluido com sucesso" : "Item modificado com sucesso";
        } else {
            $retorno->mensagemTipo = $dados->id === 0 ? "FI" : "FU";
            $retorno->mensagem = $dados->id === 0 ? "Ocorreu uma falha na tentativa de incluir o item" : "Ocorreu uma falha na tentativa de modificar o item";
        }
    }
}