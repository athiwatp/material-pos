<?php

namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;
use mako\utility\Str;

use NumberToWords\NumberToWords;

use app\models\Customer;
use app\models\Product;
use app\models\Sale;
use app\models\SaleSummary;
use app\models\Payment;

class SaleController extends Controller
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
        return $view->create('sale.index');
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        $sale_total = 0;
        $finalSale = new Sale();
        $finalSale->customer_id = $data[0]->customer_id;
        $finalSale->sales_total = $sale_total;
        $finalSale->transaction_type = $data[0]->transaction_type;
        $finalSale->account_id = $this->gatekeeper->getUser()->getId();
        $finalSale->or_number = 0;
        if($finalSale->save()) {
            $updateSaleOR = Sale::get($finalSale->sales_id);
            $updateSaleOR->or_number = str_pad($finalSale->sales_id, 8, '0', STR_PAD_LEFT);
            if($updateSaleOR->save()) {
                foreach($data as $value) {
                    $sale = new SaleSummary();
                    $sale->product_id = $value->product_id;
                    $sale->product_name = $value->product_name;
                    $sale->sale_quantity = $value->product_quantity;
                    $sale->or_number = $updateSaleOR->or_number;
                    $sale->current_price = $value->product_price;
                    $sale->total_price = $value->product_quantity * $value->product_price;
                    $sale_total += $sale->total_price;
                    // Save sale and deduct to current quantity
                    if($sale->save()) {
                        $product = Product::get($value->product_id);
                        $newQuantity = $product->product_quantity - $value->product_quantity;
                        $product->product_quantity = $newQuantity;
                        if($product->save()) {
                            $updateEachOrNumber = SaleSummary::get($sale->sale_id);
                            $updateEachOrNumber->or_number = $updateSaleOR->or_number ;
                            $updateEachOrNumber->save();
                        }
                    }
                }
                $updateSaleTotal = Sale::get($finalSale->sales_id);
                $updateSaleTotal->sales_total = $sale_total;
                if($updateSaleTotal->save()) {
                    $result = array('success' => true, 'message' => 'Sale added.', 'data' => $data, 'or_number' => $updateSaleOR->or_number);
                }
                else {
                    $result = array('success' => false, 'message' => 'Problem with OR. Contact Developer.', 'data' => $data);
                }
            }
            else {
                 $result = array('success' => false, 'message' => 'Problem with OR. Contact Developer.', 'data' => $data);
            }
            
        }
        else {
            $result = array('success' => false, 'message' => 'Sale not added.', 'data' => $data);
        }

        return $this->jsonResponse($result);
    }

    public function pay()
    {
        $data = json_decode(file_get_contents("php://input"));
        $checkAmount = Sale::get($data->sales_id);
        $paymentTotal = 0;
        $checkPayments = Payment::where('or_number', '=', $data->or_number)->all();
        foreach($checkPayments as $cp) {
            $paymentTotal += $cp->payment_amount;
        }
        $finalAddedPayments = $paymentTotal + $data->amount;
        if($finalAddedPayments > $checkAmount->sales_total) {
            $result = array('success' => false, 'message' => 'Amount is higher than balance.');
        }
        else {
            $numberToWords = new NumberToWords();
            $numberTransformer = $numberToWords->getNumberTransformer('en');
            $payment = new Payment();
            $payment->payment_amount = $data->amount;
            $payment->or_number = $data->or_number;
            $payment->notes = $data->notes;
            $payment->account_id = $this->gatekeeper->getUser()->getId();
            if($payment->save()) {
                $result = array('success' => true, 'message' => 'Payment success', 'amountText' => $numberTransformer->toWords($data->amount));
            }
            else {
                $result = array('success' => false, 'message' => 'Payment error. Contact Admin');
            }
        }

        return $this->jsonResponse($result);
    }

    public function paymentHistory()
    {
        $data = json_decode(file_get_contents("php://input"));
        $connection = $this->database->connection();
        $query = $connection->builder();
        $paymentHistory = $query->table('payment_history as ph')
        ->select(['*', 'ph.created_at as sdate'])
        ->join('users', 'ph.account_id', '=', 'users.id')
        ->where('or_number', '=', $data->or_number)->all();
        return $this->jsonResponse($paymentHistory);
    }

    public function test()
    {
        return $this->checkOR('qwe123');
    }
}