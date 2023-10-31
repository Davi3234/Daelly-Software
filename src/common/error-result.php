<?php

class ErrorModel
{
    private $title;
    private $message;
    private $description;
    private $stack;
    private $causes;

    private function __construct()
    {
        $this->title = null;
        $this->message = null;
        $this->description = null;
        $this->stack = null;
        $this->causes = [];
    }

    static function getInstance()
    {
        return new ErrorModel();
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

    function getStack()
    {
        return $this->stack;
    }

    function getCauses()
    {
        return $this->causes;
    }

    function finally()
    {
        $err = new ErrorResult($this->title, $this->message, $this->description, $this->stack, $this->causes);

        return $err->getError();
    }
}

class ErrorResult
{
    private $title;
    private $message;
    private $description;
    private $stack;
    private $causes;

    function __construct($title = null, $message = null, $description = null, $stack = null, $causes = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->description = $description;
        $this->stack = $stack;
        $this->causes = $causes;
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
    function getStack()
    {
        return $this->stack;
    }
    function getCauses()
    {
        return $this->causes;
    }

    function getError()
    {
        return (object) ['title' => $this->title, 'message' => $this->message, 'description' => $this->description, 'stack' => $this->stack, 'causes' => $this->causes];
    }
}
