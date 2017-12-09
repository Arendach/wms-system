<?php

namespace Web\Tools\HTML;

class InputBuilder extends Builder
{
    /**
     * InputBuilder constructor.
     */
    public function __construct($type = 'text')
    {
        $this->object = "<input type='$type' %c %i %d %v>";
    }

}