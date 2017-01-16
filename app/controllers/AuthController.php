<?php

namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;

class AuthController extends Controller
{
    public function index(ViewFactory $view)
    {
        if($this->gatekeeper->isLoggedIn())
        {
            return $this->redirectResponse('/app/dashboard');
        }
        $flash = $this->session->getFlash('message');
        return $view->create('auth.login', ['message' => $flash]);
    }

    public function login()
    {
        $username = $this->request->post('username');
        $password = $this->request->post('password');

        $successful = $this->gatekeeper->login($username, $password);
        if($successful == 1) { 
            return $this->redirectResponse('/app/dashboard');
        }
        else {
            $this->session->putFlash('message', 'Username/password is incorrect.');
            return $this->redirectResponse('/');
        }
    }

    public function logout()
    {
        $this->gatekeeper->logout();
        return $this->redirectResponse('/');
    }

    public function createUsers()
    {
        $this->gatekeeper->createUser('ordillos@gmail.com', 'admin', 'password', true);
        //$this->gatekeeper->createUser('ordillos@gmail.com', 'admin', 'password', true);
        //$this->gatekeeper->createUser('ordillos@gmail.com', 'admin', 'password', true);
    }
}