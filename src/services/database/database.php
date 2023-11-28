<?php

interface Database
{
    function connect();
    function exec(string $sql): bool;
    function insert(string $table, array $values): bool;
    function query(string $sql);
    function begin();
    function commit();
    function rollback();
}
