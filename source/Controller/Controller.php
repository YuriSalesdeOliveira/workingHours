<?php


namespace Source\Controller;


use Source\Classes\View;
use Source\Model\User;

abstract class Controller
{
    protected $view;
    protected $router;
    protected $user;

    public function __construct($router)
    {
        $this->view = new View(PATHS['view'], 'php');

        $this->router = $router;

        $this->view->addData(['router' => $this->router]);

        if (isset($_SESSION['user']) && $user = User::find(['id' => $_SESSION['user']])) {

            $this->user = $user;
        }
    }
}