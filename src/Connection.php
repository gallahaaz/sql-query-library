<?php

namespace Gallahaaz\Sql;
use mysqli;

class Connection 
{

    protected $DB;
    public $result;
    public $last_id;

    public function __construct() {
        $this->connect();
    }

    /**
     * Função de conexão ao banco de dados
     *
     * return none / Instancia conexão em DB
     * */
    protected function connect() {
        $this->DB = new mysqli( DBHOST, DBLOGIN, DBPASSWORD, DBSCHEMA );
        //previne para a execução do relatório de erro caso não seja possível conectar
        if ($this->DB->connect_error) {
            die('Erro de conexão (' . $this->DB->connect_errno . ')' . $this->DB->connect_error);
        }
    }

    /**
     * 
     * @param comando sql
     * @return array sql de resultado
     * 
     */
    public function last_id() {
        return $this->last_id;
    }

    /**
     * Fecha a conexão com o banco de dados padrão
     */
    public function close() {
        $this->DB->close();
    }

    /**
     * Retorna erros ocorridos no banco ou conexão
     */
    public function error() {
        return "mysql error" . $this->DB->connect_error . ' no. ' . $this->DB->connect_errorno;
    }

    /**
     * Informa o status da conexão
     */
    public function stat() {
        echo "Status do servi&ccedil;o : " . $this->DB->stat;
    }
    
    public function server_info(){
        echo "Mysql version " . $this->DB->server_info;
    }
    
    public function host_info(){
        echo "Connected on " . $this->DB->host_info;
    }

}

?>