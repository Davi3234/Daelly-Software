<?php

class ErrorModel
{
    private $title;
    private $message;
    private $description;
    private $stack;
    private $causes;
    private $code;

    function __construct($inherit = [])
    {
        $this->title = !isset($inherit['title']) ? null : $inherit['title'];
        $this->message = !isset($inherit['message']) ? null : $inherit['message'];
        $this->description = !isset($inherit['description']) ? null : $inherit['description'];
        $this->code = !isset($inherit['code']) ? 400 : $inherit['code'];
        $this->stack = !isset($inherit['stack']) ? [] : $inherit['stack'];
        $this->causes = !isset($inherit['causes']) ? [] : $inherit['causes'];
    }

    function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    function setStack($stack)
    {
        $this->stack = $stack;

        return $this;
    }

    function addCause($cause)
    {
        $this->causes[] = $cause;

        return $this;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getMessage()
    {
        return $this->message;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getCode()
    {
        return $this->code;
    }

    function getStack()
    {
        return $this->stack;
    }

    function getCauses()
    {
        return $this->causes;
    }

    function getError() {
        return ['title' => $this->title, 'message' => $this->message, 'description' => $this->description, 'stack' => $this->stack, 'code' => $this->code, 'causes' => $this->causes];
    }
}