<?php

function line()
{
    echo '<br>';
}

function formatterPath($path)
{
    return str_replace("/", DIRECTORY_SEPARATOR, $path);
}
