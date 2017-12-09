<?php

namespace Web\Tools\HTML;

class FormGroupBuilder extends Builder
{
    private $form_group;

    public function __construct()
    {
        $this->form_group = '
            <div class="form-group%c">
                <label for="%i">%l</label>
                %e
            </div>';
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->form_group = preg_replace('/%i/', $id, $this->form_group);
        return $this;
    }

    /**
     * @param $element
     * @return $this
     */
    public function setElement($element)
    {
        $this->form_group = preg_replace('/%e/', $element, $this->form_group);
        return $this;
    }
}