<?php

namespace Gc\Resources\Controller;

abstract class Controller
{

    protected $view;

    function __construct($action)
    {
        //autenticação
        $this->$action();
    }

    function content()
    {
        parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH) . '\..\src\Views\Layouts\layout.phtml';
    }

    function render($view, $layout)
    {
        $pathLayouts =  parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH) . '\\..\\src\\Views\\layouts\\' . $layout . '.phtml';
        $this->view = $view;

        require_once $pathLayouts;
    }

    public function contents()
    {
        $classAtual = get_class($this);
        $classAtual = str_replace('Thiagorviero\\Gc\\Controllers\\', '', $classAtual);
        $classAtual = strtolower(str_replace('Controller', '', $classAtual));
        $pathView =  parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH) . '\\..\\src\\Views\\' . $classAtual . '\\' . $this->view . '.phtml';

        require_once $pathView;
    }
}
