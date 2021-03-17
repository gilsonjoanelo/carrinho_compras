<?php
require '../services/database.inc.php';
class ProdutoDao extends Database {
    function __construct() {
        parent::__construct();
    }

    public function retornarLista($colunas, $ordenacao) {
        $retorno = parent::getRetorno();
        $retorno->data = null;

        $sql = "SELECT ";
        $sql .= "COUNT(prod.id) id ";
        $sql .= "FROM produtos prod ";
        $sql .= "INNER JOIN fornecedores forn on prod.fabricanteId = forn.id ";
        
        $stmp = parent::getConexao()->prepare($sql);
        $stmp->execute();
        $row = $stmp->fetchObject('ProdutoVM');
        if($row) {
            $retorno->rowsCount = $row->id;
        }

        if($retorno->rowsCount > 0) {
            $sql = "SELECT $colunas ";
            $sql .= "FROM produtos prod ";
            $sql .= "INNER JOIN fornecedores forn on prod.fabricanteId = forn.id ";
            $sql .= "ORDER BY $ordenacao ";
            $stmp = parent::getConexao()->prepare($sql);
            $stmp->execute();

            $produtos = $stmp->fetchAll(PDO::FETCH_CLASS, 'ProdutoVM');
            if ($produtos) {
                $data = array();
                while($row = $produtos) {
                    array_push($data, $row);
                }
                setRetorno("", "C", $data);
            } else {
                $retorno->mensagem = "Nenhum produto cadastrado para os parâmetros informados";
            }
        } else {
            $retorno->mensagem = "Nenhum produto cadastrado";
        }
        return $retorno;
    }

    public function retornarItem($id) {
        $retorno = parent::getRetorno();
        $retorno->data = null;

        $sql = "SELECT $colunas ";
        $sql .= "FROM produtos prod ";
        $sql .= "INNER JOIN fornecedores forn on prod.fabricanteId = forn.id ";
        $sql .= "WHERE prod.id = :id ";
        $sql .= "ORDER BY $ordenacao ";
        $stmp = parent::getConexao()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmp->execute();

        $produto = $stmp->fetchObject('ProdutoVM');
        if ($produto) {
            setRetorno("", "C", $produto);
        } else {
            $retorno->mensagem = "Produto não encontrado";
        }
        return $retorno;
    }

    public function excluirItem($id) {
        $retorno = parent::getRetorno();
        $retorno->data = null;

        $sql = "DELETE FROM produtos WHERE id = :id ";
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
            $sql = "INSERT INTO produtos (codigo, nome, descricao, codigoBarras, fabricanteId, dataValidade) "
                 . "VALUES(:codigo, :nome, :descricao, :codigoBarras, :fabricanteId, :dataValidade)";
        }else {
            $sql = "UPDATE produtos SET nome=:nome, descricao=:descricao, codigoBarras=:codigoBarras, "
                 . "fabricanteId=:fabricanteId,dataValidade=:dataValidade "
                 . "WHERE id=:id";
        }

        $stmt = parent::getConexao()->prepare($sql);
        if ($dados->id === 0) {
            $stmt->bindParam(':id', $json->id);

            $codigo = $this->getProximoCodigo();
            $stmt->bindParam(':codigo', $codigo);
        }
        $stmt->bindParam(':nome', $json->nome);
        $stmt->bindParam(':descricao', $json->descricao);
        $stmt->bindParam(':codigoBarras', $json->codigoBarras);
        $stmt->bindParam(':fabricanteId', $json->fabricanteId);
        $stmt->bindParam(':dataValidade', $json->dataValidade != "" ? $json->dataValidade : "");
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $retorno->mensagemTipo = $dados->id === 0 ? "RI" : "RU";
            $retorno->mensagem = $dados->id === 0 ? "Item incluido com sucesso" : "Item modificado com sucesso";
        } else {
            $retorno->mensagemTipo = $dados->id === 0 ? "FI" : "FU";
            $retorno->mensagem = $dados->id === 0 ? "Ocorreu uma falha na tentativa de incluir o item" : "Ocorreu uma falha na tentativa de modificar o item";
        }
    }

    private function getProximoCodigo() {
        $sql = "SELECT (COUNT(codigo) + 1) codigo FROM produtos";
        $stmp = parent::getConexao()->prepare($sql);
        $stmp->execute();

        $produto = $stmp->fetchObject('ProdutoVM');
        return $produto>codigo;
    }
}