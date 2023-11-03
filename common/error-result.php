<?php

class ErrorModel extends Exception
{
    private $title;
    private $description;
    private $stack;
    private $causes;

    function __construct()
    {
    	parent::__construct();

        $this->title = null;
        $this->message = null;
        $this->description = null;
        $this->code = 400;
        $this->stack = [];
        $this->causes = [];
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

    function getError() {
        return new ErrorResult($this->title, $this->message, $this->description, $this->stack, $this->code, $this->causes);
    }

    function finally()
    {
        return $this->getError()->getError();
    }
}

class ErrorResult
{
    private $title;
    private $message;
    private $description;
    private $stack;
    private $causes;
    private $code;

    function __construct($title = null, $message = null, $description = null, $stack = null, $code = 400, $causes = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->description = $description;
        $this->stack = $stack;
        $this->causes = $causes;
        $this->code = $code;
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
        return (object) ['title' => $this->title, 'message' => $this->message, 'description' => $this->description, 'stack' => $this->stack, 'code' => $this->code, 'causes' => $this->causes];
    }
}