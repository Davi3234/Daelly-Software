<?php

interface Database
{
    function connect();
    function exec($sql): bool;
    function query($sql);
    function begin();
    function commit();
    function rollback();
}
