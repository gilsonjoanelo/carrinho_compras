<?php
include '../services/database.inc.php';
//https://www.devmedia.com.br/crud-com-php-pdo/28873
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
        $sql .= "WHERE prod.id = $id ";
        $sql .= "ORDER BY $ordenacao ";
        $stmp = parent::getConexao()->prepare($sql);
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

        $sql = "DELETE FROM produtos WHERE id = $id ";
        $stmt = parent::getConexao()->prepare($sql);
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
        // $json = json_decode($data);
    }
}