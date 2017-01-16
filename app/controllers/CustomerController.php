<?php

namespace app\controllers;

use mako\http\routing\Controller;
use mako\view\ViewFactory;

use app\models\Customer;
use app\models\Log;

class CustomerController extends Controller
{
    public function beforeAction()
    {
        if($this->gatekeeper->isGuest())
        {
            return $this->redirectResponse('/');
        }
    }

    public function logCustomer($customer_id, $action)
    {
        $connection = $this->database->connection();
        $query = $connection->builder();
        $log = $query->table('customer_history');
        $log->insert([
            'customer_id' => $customer_id, 
            'action' => $action,
            'account_id' => $this->gatekeeper->getUser()->getId()
        ]);
    }

    public function index(ViewFactory $view)
    {
        return $view->create('customer.index');
    }

    public function showAll()
    {
        $customers = Customer::all();
        return $this->jsonResponse($customers);
    }

    public function show($customer_id)
    {
        $customers = Customer::get($customer_id);
        return $this->jsonResponse($customers);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        $customer = new Customer();
        $customer->customer_name = $data->name;
        $customer->customer_company = (empty($data->company)) ? '' : $data->company;
        $customer->customer_address = (empty($data->address)) ? '' : $data->address;
        $customer->customer_email = (empty($data->email)) ? '' : $data->email;
        $customer->customer_contact = (empty($data->contact)) ? '' : $data->contact;
        $customer->customer_credit_limit = (empty($data->credit_limit)) ? 0 : $data->credit_limit;

        if($customer->save()) {
            $this->logCustomer($customer->customer_id, 0);
            $result = array('success' => true, 'message' => 'Customer '.$data->name.' has been added.', 'customer_id' => $customer->customer_id);
        }
        else {
            $result = array('success' => false, 'message' => 'Error adding customer.');
        }
        return $this->jsonResponse($result);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;
        $customer = Customer::get($id);

        $customer->customer_name = $data->name;
        $customer->customer_company = (empty($data->company)) ? '' : $data->company;
        $customer->customer_address = (empty($data->address)) ? '' : $data->address;
        $customer->customer_email = (empty($data->email)) ? '' : $data->email;
        $customer->customer_contact = (empty($data->contact)) ? '' : $data->contact;
        $customer->customer_credit_limit = (empty($data->credit_limit)) ? 0 : $data->credit_limit;

        if($customer->save()) {
            $this->logCustomer($customer->customer_id, 1);
            $result = array('success' => true, 'message' => 'Customer '.$id.' has been updated.');
        }
        else {
            $result = array('success' => false, 'message' => 'Error updating customer.');
        }
        return $this->jsonResponse($result);
    }

    public function updateStatus()
    {
        $data = json_decode(file_get_contents("php://input"));
        $customer = Customer::get($data->customer_id);
        $customer->status = $data->status;
        $stat = $data->status == 1 ? 'Activated' : 'Deactivated';
            
        if($customer->save()) {
            $this->logger->info($stat . " customer " . $data->customer_id);
            $result = array('success' => true, 'message' => 'Customer #'.$data->customer_id.' status '.$stat);
        }
        else {
            $result = array('success' => false, 'message' => 'Error updating customer status.');
        }
        return $this->jsonResponse($result);
    }
}