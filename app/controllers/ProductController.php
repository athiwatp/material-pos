<?php

namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;

use app\models\Product;
use app\models\Log;

class ProductController extends Controller
{
    public function beforeAction()
    {
        if($this->gatekeeper->isGuest())
        {
            return $this->redirectResponse('/');
        }
    }

    public function logProduct($product_id, $quantity, $action, $orNumber)
    {
        $connection = $this->database->connection();
        $query = $connection->builder();
        $log = $query->table('product_history');
        $orNumber = ($orNumber == "") ? "Not Provided" : $orNumber;
        $log->insert([
            'product_id' => $product_id, 
            'type' => $action,
            'quantity' => $quantity,
            'or_number' => $orNumber,
            'account_id' => $this->gatekeeper->getUser()->getId()
        ]);
    }

    public function index(ViewFactory $view)
    {
        return $view->create('product.index');
    }

    public function showAll()
    {
        $products = Product::all();
        return $this->jsonResponse($products);
    }

    public function show($product_id)
    {
        $product = Product::get($product_id);
        return $this->jsonResponse($product);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        $product = new Product();
        $product->product_code = $data->code;
        $product->product_name = $data->name;
        $product->product_price = $data->price;

        if($product->save()) {
            $this->logProduct($product->product_id, 0, 0, null);
            $result = array('success' => true, 'message' => 'Product '.$data->name.' has been added.', 'product_id' => $product->product_id);
            
        }
        else {
            $result = array('success' => false, 'message' => 'Error adding product.');
        }
        return $this->jsonResponse($result);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;
        $product = Product::get($id);
        
        $product->product_code = $data->code;
        $product->product_name = $data->name;
        $product->product_price = $data->price;

        if($product->save()) {
            $this->logProduct($product->product_id, 0, 4, null);
            $result = array('success' => true, 'message' => 'Product '.$id.' has been updated.');
        }
        else {
            $result = array('success' => false, 'message' => 'Error updating product.');
        }
        return $this->jsonResponse($result);
    }

    public function addQuantity()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;
        $qty = $data->quantity;
        $orNumber = $data->or_number;
        $product = Product::get($id);
        $newQuantity = $qty + $product->product_quantity;
        $product->product_quantity = $newQuantity;
        $type = ($data->type == 1) ? 1 : 2;
        if($product->save()) {
            $this->logProduct($product->product_id, $qty, $type, $orNumber);
            $result = array('success' => true, 'message' => $qty." items added to Product " . $id);
        }
        else {
            $result = array('success' => false, 'message' => 'Error updating product.');
        }
        return $this->jsonResponse($result);
    }

    /*
    * deductQuantity
    *
    * Deducts items that will be returned to the company
    */
    public function deductQuantity()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;
        $qty = $data->quantity;
        $orNumber = $data->or_number;
        $product = Product::get($id);
        $newQuantity = $product->product_quantity - $qty;
        $product->product_quantity = $newQuantity;
        if($product->save()) {
            $this->logProduct($product->product_id, $qty, 3, $orNumber);
            $result = array('success' => true, 'message' => $qty." items deducted to Product " . $id);
        }
        else {
            $result = array('success' => false, 'message' => 'Error updating product.');
        }
        return $this->jsonResponse($result);
    }

    public function checkProductCode($product_code)
    {
        $product = Product::where('product_code', '=', $product_code)->first();
        if($product) {
            $result = array('success' => true);
        }
        else {
            $result = array('success' => false);
        }
        return $this->jsonResponse($result);
    }
}