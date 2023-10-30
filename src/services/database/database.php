<?php

interface Database
{
    function connect();
    function exec($sql);
    function query($sql);
}
