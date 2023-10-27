<?php

function getAttributes($attibutes = []) {
    $attr = '';

    foreach ($attibutes as $key => $value) {
        $attr .= ' ' . $key . '="' . $value . '"';
    }

    return $attr;
}
