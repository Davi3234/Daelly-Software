<?php

function line()
{
    echo '<br>';
}

function formatterPath($path)
{
    return str_replace("/", DIRECTORY_SEPARATOR, $path);
}

function printObject($obj, $prefix = '')
{
    foreach ($obj as $key => $value) {
        if (!is_array($value)) {
            echo $prefix . '"' . $key . '": "' . $value . '"';
        } else {
            printObject($value, '"' . $key . '": ');
        }
        line();
    }
}

function remove_string($search, $subject)
{
    return str_replace($search, '', $subject);
}
