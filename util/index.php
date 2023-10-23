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
    ?> <script>console.log(<?= json_encode($obj) ?>)</script> <?php
}

function remove_string($search, $subject)
{
    return str_replace($search, '', $subject);
}

function remove_start_str($search, $subject)
{
    if (str_starts_with($subject, $search)) {
        return substr($subject, strlen($search));
    }

    return $subject;
}

function remove_end_str($search, $subject)
{
    if (str_ends_with($subject, $search)) {
        return substr($subject, 0, -strlen($search));
    }

    return $subject;
}