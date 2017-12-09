<?php

namespace Web\Tools\HTML;

abstract class Builder
{
    protected $object;

    /**
     * @param $class_name
     */
    public function addClass($class_name)
    {
        $this->object = preg_replace('/%c/', " $class_name%c", $this->input);
        return $this;
    }
    /**
     * Display
     */
    public function display()
    {
        $this->object = preg_replace('/%[a-z]/', '', $this->object);
        $this->object = preg_replace('/[\s]+/', ' ', $this->object);
        echo $this->object;
    }

    /**
     * @return mixed|string
     */
    public function get()
    {
        $this->object = preg_replace('/%[a-z]/', '', $this->object);
        $this->object = preg_replace('/[\s]+/', ' ', $this->object);
        return $this->object;
    }

    /**
     * @param $class_name
     * @return $this
     */
    public function setClass($class_name)
    {
        $this->object = preg_replace('/%c/', " class='$class_name%c' ", $this->object);
        return $this;
    }

    /**
     * @param $id_name
     */
    public function id($id_name)
    {
        $this->object = preg_replace('/%i/', " id='$id_name' ", $this->object);
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->object = preg_replace('/%v/', " value='$value' ", $this->object);
        return $this;
    }

    /**
     * @param $name
     * @param $value
     */
    public function addData($name, $value)
    {
        $this->object = preg_replace('/%d/', " data-$name='$value' %d", $this->object);
        return $this;
    }
}