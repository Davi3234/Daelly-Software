<?php

function getAttributes($attributes = [])
{
    $attr = '';

    foreach ($attributes as $key => $value) {
        $attr .= ' ' . $key . '="' . $value . '"';
    }

    return $attr;
}
