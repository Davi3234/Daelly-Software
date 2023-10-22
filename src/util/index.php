<?php

function line()
{
    echo '<br>';
}

function formatterPath($path)
{
    return str_replace("/", DIRECTORY_SEPARATOR, $path);
}

function printObject($obj)
{
    foreach ($obj as $key => $value) {
        echo '"' . $key . '": "' . $value . '"';
        line();
    }
}
