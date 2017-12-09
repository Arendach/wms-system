<?php

/**
 * # developed by Bohdan Pidluzhnyy
 *
 * instruction:
 * !!!work with header();
 *
 * $v = new View();
 * $v->name_news = $news;
 *
 * $v->render('template_name'); for cash;
 *
 * $v->display('template_name');
 */

namespace Web\App;

use Exception;
use Web\App\View\Facade as Template;
use Web\Tools\HTML;

class View
{
    /**
     * @var string
     */
    private $PATH = TPLDIR;

    /**
     * @var string
     */
    private $extension = ".tpl";

    /**
     * @var
     */
    private $tmp;

    /**
     * @var array
     */
    private $data = array();

    /**
     * @param $template
     * @param array $data
     * @return mixed
     */
    public function render($template, $data = array())
    {
        $this->tmp = $template;
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        } else {
            foreach ($this->data as $key => $value) {
                $$key = $value;
            }
        }

        ob_start();
        include $this->PATH . $template . $this->extension;
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
        // return Template::run($contents);
    }

    /**
     * @param $template
     * @param array $data
     */
    public function display($template, $data = array())
    {
        if (!empty($data))
            foreach ($data as $key => $value)
                $this->data[$key] = $value;

        echo $this->render($template);
    }

    /**
     * @param $name
     * @throws Exception
     */
    public function layout($name)
    {
        $path = $this->PATH . $name . $this->extension;
        if (!file_exists($path))
            throw new Exception("Error: Template file not found {$path}", 1);
        include_once $path;
    }

    /**
     * @param $name
     * @throws Exception
     */
    public function inc($name)
    {
        $path = $this->PATH . $name . $this->extension;
        if (!file_exists($path))
            throw new Exception("Error: Template file not found {$path}", 1);
        extract($this->data);
        include_once $path;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

}