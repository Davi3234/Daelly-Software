<?php

class ResultException extends Exception
{
    private $title;
    private $description;
    private $stack;
    private $causes;

    function __construct(ErrorModel $err)
    {
        parent::__construct();

        $this->title = $err->getTitle();
        $this->message = $err->getMessage();
        $this->description = $err->getDescription();
        $this->code = $err->getCode();
        $this->stack = $err->getStack();
        $this->causes = $err->getCauses();
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
        return ['title' => $this->title, 'message' => $this->message, 'description' => $this->description, 'stack' => $this->stack, 'code' => $this->code, 'causes' => $this->causes];
    }
}