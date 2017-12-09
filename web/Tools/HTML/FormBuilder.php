<?php

namespace Web\Tools\HTML;

class FormBuilder
{
    public $input;

    public function __construct()
    {
        $this->input = new InputBuilder();
    }

    public function input($type = 'text')
    {
        return new InputBuilder($type);
    }
}