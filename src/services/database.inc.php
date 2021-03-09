<?php
abstract class Database {
    private $database = "ar_gilson_ra_09014593";
    private $servidor = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false // indica que é para fechar a conexão no final do script
    );
    private $conn;

    function __construct() {
        $this->conn = new PDO("mysql:host=$this->servidor;dbname=$this->database", "$this->usuario", "$this->senha", $this->options);
    }

    protected function getConexao() {
        return $this->conn;
    }

    protected function getRetorno() {
        $retorno = new stdClass();
        $retorno->Sucesso = false;
        $retorno->Mensagem = "";
        $retorno->MensagemTipo = "E";
        return $retorno;
    }
}