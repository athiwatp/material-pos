<?php

namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;
use mako\database\query\Raw;
use mako\utility\Str;

use app\models\Sale;
use app\models\SaleSummary;

class ReportController extends Controller
{
    /**
    * beforeAction
    *
    * Check if authenticated
    */
    public function beforeAction()
    {
        if($this->gatekeeper->isGuest())
        {
            return $this->redirectResponse('/');
        }
    }

    public function returnsReportView(ViewFactory $view)
    {
        return $view->create('report.return');
    }

    public function returnsToCompanyReportView(ViewFactory $view)
    {
        return $view->create('report.return-to-company');
    }

    public function salesReportView(ViewFactory $view)
    {
        return $view->create('report.sale');
    }

    /**
    * reportQuery
    *
    * Returns the product reports
    *
    * @type the report type
    * @from from date
    * @to to date
    */
    public function reportQuery($type, $from, $to)
    {

        $connection = $this->database->connection();
        $query = $connection->builder();
        $from = ($from==null) ? date('Y-m-d') : $from;
        $to = ($to==null) ? date('Y-m-d') : $to;
        $reports = $query->table('product_history as ph')
        ->select(['*', 'ph.created_at as phdate'])
        ->join('products', 'products.product_id', '=', 'ph.product_id')
        ->join('users', 'users.id', '=', 'ph.account_id')
        ->between(new Raw('Date(ph.created_at)'), $from, $to)
        ->where('ph.type', '=', $type)->all();
        return $reports;
    }

    /**
    * showReturns
    *
    * Returns the returns report
    */
    public function showReturns()
    {
        // 2 = returns
        $to = $this->request->get('toDate');
        $from = $this->request->get('fromDate');
        $returns = $this->reportQuery(2, $from, $to);
        return $this->jsonResponse($returns);
    }

    /**
    * showReturns
    *
    * Returns the returns report
    */
    public function showReturnsToCompany()
    {
        // 2 = returns
        $to = $this->request->get('toDate');
        $from = $this->request->get('fromDate');
        $returns = $this->reportQuery(3, $from, $to);
        return $this->jsonResponse($returns);
    }

    /**
    * showAddedProducts
    *
    * Returns the added products report
    */
    public function showAddedProducts()
    {
        $addedProducts = $this->reportQuery(0);
        return $this->jsonResponse($addedProducts);
    }

    /**
    * showAddedQuantities
    *
    * Returns the added items report
    */
    public function showAddedQuantities()
    {
        $addedQuantities = $this->reportQuery(1);
        return $this->jsonResponse($addedQuantities);
    }

    /**
    * showSales
    *
    * Returns sales report
    */
    public function showSales()
    {
        $connection = $this->database->connection();
        $query = $connection->builder();
        $to = $this->request->get('toDate');
        $from = $this->request->get('fromDate');
        $fromDate = ($from==null) ? date('Y-m-d') : $from;
        $toDate = ($to==null) ? date('Y-m-d') : $to;
        $sales = $query->table('sales as s')
        ->select(['*', 's.created_at as sdate'])
        ->join('customers', 's.customer_id', '=', 'customers.customer_id')
        ->join('users', 's.account_id', '=', 'users.id')
        ->between(new Raw('Date(s.created_at)'), $fromDate, $toDate)->all();
        return $this->jsonResponse($sales);
    }

    public function customerSales($customer_id)
    {
        $sales = Sale::where('customer_id', '=', $customer_id)->all();
        return $this->jsonResponse($sales);
    }

    public function saleSummary($or_number)
    {
        $saleSummary = SaleSummary::where('or_number', '=', $or_number)->all();
        return $this->jsonResponse($saleSummary);
    }

    public function test()
    {
        return Str::random(Str::NUMERIC, 5);
    }
}