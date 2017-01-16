<?php

namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;

use app\models\Customer;
use app\models\Product;
use app\models\Log;

class LogController extends Controller
{
    public function beforeAction()
    {
        if($this->gatekeeper->isGuest())
        {
            return $this->redirectResponse('/');
        }
    }

    public function showAll()
    {
        $logs = Log::all();
        return $this->jsonResponse($logs);
    }
}