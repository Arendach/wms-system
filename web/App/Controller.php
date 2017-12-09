<?php

namespace Web\App;

abstract class Controller extends Entity
{
    /**
     * @var View
     */
    public $view;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Session
     */
    public $session;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View;
        $this->session = new Session;
        $this->request = new Request;
    }

    /**
     * @return string
     */
    public function url()
    {
        return my_site_url() . $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public function full_url()
    {
        $request = parse_url($_SERVER['REQUEST_URI']);
        return $request['scheme'] . $request['host'] . $request['path'];
    }

    public function not_found()
    {
        http_status(404);
        exit;
    }

    public function access_denied()
    {
        http_status('403');
        exit;
    }
}

?>