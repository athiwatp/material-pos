<?php

namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;

use app\models\Customer;
use app\models\Product;
use app\models\Sale;

class DashboardController extends Controller
{
    public function beforeAction()
    {
        if($this->gatekeeper->isGuest())
        {
            return $this->redirectResponse('/');
        }
    }

    public function index(ViewFactory $view)
    {
        $products = Product::all()->count();
        $active = Customer::where('status', '=', 1)->count();
        $inactive = Customer::where('status', '=', 0)->count();
        $cash = Sale::where('transaction_type', '=', 0)->count();
        $account = Sale::where('transaction_type', '=', 1)->count();
        return $view->create('dashboard', [ 
            'active' => $active, 
            'inactive' => $inactive,
            'products' => $products,
            'cash' => $cash,
            'account'=> $account
        ]);
    }
}