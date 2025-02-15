<?php

class DatabaseSqlite implements Database
{
    private static $instance;
    protected $connection;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function connect()
    {
        try {
            $this->connection = new SQLite3($GLOBALS['DATABASE']['dbPath'] . '/' . $GLOBALS['DATABASE']['dbname'] . '.db');

            // $this->setup();
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function begin()
    {
        $this->exec('BEGIN');
    }

    function commit()
    {
        $this->exec('COMMIT');
    }

    function rollback()
    {
        $this->exec('ROLLBACK');
    }

    function exec(string $sql): bool
    {
        try {
            return $this->connection->exec($sql);
        } catch (Exception $ex) {
            return false;
        }
    }

    function find(string $sql)
    {
        $res = $this->connection->querySingle($sql, true);

        if (!$res) {
            return null;
        }

        return $res;
    }

    function insert(string $table, array $values): bool
    {
        return $this->exec('INSERT INTO ' . $table . ' (' . join(', ', array_keys($values)) . ') VALUES (' . join(', ', array_values($values)) . ')');
    }

    function query(string $sql)
    {
        $res = $this->connection->query($sql);

        $docs = [];

        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $docs[] = $row;
        }

        return $docs;
    }

    private function setup()
    {
        $sqlCreate = [
            'CREATE TABLE IF NOT EXISTS administrador ( id INTEGER PRIMARY KEY, nome TEXT, email TEXT, senha TEXT, tentativas INTEGER DEFAULT 0, ultimo_acesso DATETIME DEFAULT CURRENT_TIMESTAMP, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS compressor ( id INTEGER PRIMARY KEY, codigo INTEGER NOT NULL, marca TEXT, modelo TEXT, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS funca_funci ( id_funcionario INTEGER NOT NULL, id_funcao INTEGER NOT NULL, PRIMARY KEY (id_funcionario, id_funcao), createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS funcao ( id INTEGER PRIMARY KEY, id_tipo INTEGER, nome TEXT NOT NULL, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS funcionario ( id INTEGER PRIMARY KEY, id_grupo INTEGER, cpf TEXT NOT NULL, nome TEXT, entrada TEXT, saida TEXT, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS grupo ( id INTEGER PRIMARY KEY, numero INTEGER NOT NULL, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS manutencao ( id INTEGER PRIMARY KEY, id_maquina_costura INTEGER, id_compressor INTEGER, descricao TEXT, data_manutencao TEXT, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS mapa ( id INTEGER PRIMARY KEY, largura_mapa INTEGER NOT NULL, altura_mapa INTEGER NOT NULL, largura_mc INTEGER NOT NULL, altura_mc INTEGER NOT NULL, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS maquina_costura ( id INTEGER PRIMARY KEY, id_tipo INTEGER NOT NULL, codigo INTEGER NOT NULL, modelo TEXT, marca TEXT, chassi TEXT, aquisicao DATE, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS maquina_costura_mapa ( id INTEGER PRIMARY KEY, id_maquina_costura INTEGER NOT NULL, posicionado INTEGER DEFAULT 0, x INTEGER DEFAULT 0, y INTEGER DEFAULT 0, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
            'CREATE TABLE IF NOT EXISTS tipo ( id INTEGER PRIMARY KEY, nome TEXT NOT NULL, createAt DATETIME DEFAULT CURRENT_TIMESTAMP )',
        ];

        foreach ($sqlCreate as $sql) {
            $this->exec($sql);
        }
    }
}
