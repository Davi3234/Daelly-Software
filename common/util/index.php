<?php

function line()
{
    echo '<br>';
}

function formatterPath($path)
{
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function log_message(mixed $message)
{
    error_log(json_encode($message), 3, 'logs/log.txt');
}

function remove_string($search, $subject)
{
    return str_replace($search, '', $subject);
}

function remove_start_str($search, $subject)
{
    if (!$search) {
        return $subject;
    }

    if (isStartsWith($search, $subject)) {
        return substr($subject, strlen($search));
    }

    return $subject;
}

function isStartsWith($search, $subject)
{
    return str_starts_with($subject, $search);
}

function isEndsWith($search, $subject)
{
    return str_ends_with($subject, $search);
}

function remove_end_str($search, $subject)
{
    if (isEndsWith($search, $subject)) {
        return substr($subject, 0, -strlen($search));
    }

    return $subject;
}

function arrayHasAttributes(array $array, ...$attributes)
{
    foreach ($attributes as $att) {
        if (!array_key_exists($att, $array)) {
            return false;
        }
    }

    return true;
}

enum NativeTypes: string
{
    case Boolean = 'boolean';
    case Integer = 'integer';
    case Double = 'double';
    case String = 'string';
    case Array = 'array';
    case Object = 'object';
    case Resource = 'resource';
    case Null = 'NULL';
    case Unknown = 'unknown type';
}

function isNaN(mixed $value)
{
    return !isNumber($value);
}

function isNumber(mixed $value)
{
    return isInteger($value) || isDouble($value);
}

function isTruthy(mixed $value = null)
{
    return !isFalsy($value);
}

function isFalsy(mixed $value = null)
{
    if (isNumber($value)) {
        return $value == 0;
    }

    if (isBoolean($value)) {
        return !$value;
    }

    if (isString($value)) {
        return strlen($value) == 0 || strlen(trim($value)) == 0;
    }

    if (isArray($value)) {
        return count($value) == 0;
    }

    if (isObject($value)) {
        return empty(get_object_vars($value));
    }

    return !isNull($value) || !isUnknown($value) || !isset($value);
}

function isBoolean(mixed $value)
{
    return NativeTypes::Boolean->value == gettype($value);
}

function isInteger(mixed $value)
{
    return NativeTypes::Integer->value == gettype($value);
}

function isDouble(mixed $value)
{
    return NativeTypes::Double->value == gettype($value);
}

function isString(mixed $value)
{
    return NativeTypes::String->value == gettype($value);
}

function isArray(mixed $value)
{
    return NativeTypes::Array->value == gettype($value);
}

function isObject(mixed $value)
{
    return NativeTypes::Object->value == gettype($value);
}

function isResource(mixed $value)
{
    return NativeTypes::Resource->value == gettype($value);
}

function isNull(mixed $value)
{
    return NativeTypes::Null->value == gettype($value);
}

function isUnknown(mixed $value)
{
    return NativeTypes::Unknown->value == gettype($value);
}

function console(mixed $obj)
{
?> <script>
        console.log(<?= json_encode($obj) ?>)
    </script> <?php
            }
