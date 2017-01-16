<?php

$routes->get('/', 'app\controllers\AuthController::index');
$routes->post('/auth/login', 'app\controllers\AuthController::login');
$routes->get('/auth/logout', 'app\controllers\AuthController::logout');

$routes->get('/app/customers', 'app\controllers\CustomerController::index');

$routes->get('/api/customers', 'app\controllers\CustomerController::showAll');
$routes->get('/api/customers/{customer_id}', 'app\controllers\CustomerController::show');
$routes->post('/api/customers', 'app\controllers\CustomerController::create');
$routes->put('/api/customers', 'app\controllers\CustomerController::update');
$routes->post('/api/customers/update_status', 'app\controllers\CustomerController::updateStatus');

$routes->get('/app/dashboard', 'app\controllers\DashboardController::index');

$routes->get('/app/products', 'app\controllers\ProductController::index');

$routes->get('/api/products', 'app\controllers\ProductController::showAll');
$routes->get('/api/products/{product_id}', 'app\controllers\ProductController::show');
$routes->post('/api/products', 'app\controllers\ProductController::create');
$routes->put('/api/products', 'app\controllers\ProductController::update');
$routes->post('/api/products/add_quantity', 'app\controllers\ProductController::addQuantity');
$routes->post('/api/products/deduct_quantity', 'app\controllers\ProductController::deductQuantity');
$routes->get('/api/check_code/{product_code}', 'app\controllers\ProductController::checkProductCode');


$routes->get('/api/reports/returns', 'app\controllers\ReportController::showReturns');
$routes->get('/api/reports/added_products', 'app\controllers\ReportController::showAddedProducts');
$routes->get('/api/reports/added_quantities', 'app\controllers\ReportController::showAddedQuantities');
$routes->get('/api/reports/test', 'app\controllers\ReportController::test');

$routes->get('/api/reports/returns-to-company', 'app\controllers\ReportController::showReturnsToCompany');
$routes->get('/api/reports/sales', 'app\controllers\ReportController::showSales');
$routes->get('/api/reports/sales/{customer_id}', 'app\controllers\ReportController::customerSales');
$routes->get('/api/reports/sale_summary/{or_number}', 'app\controllers\ReportController::saleSummary');

$routes->get('/app/reports/returns-from-dealer', 'app\controllers\ReportController::returnsReportView');
$routes->get('/app/reports/returns-to-company', 'app\controllers\ReportController::returnsToCompanyReportView');
$routes->get('/app/reports/sales', 'app\controllers\ReportController::salesReportView');

$routes->get('/app/sales', 'app\controllers\SaleController::index');
$routes->post('/api/sales', 'app\controllers\SaleController::create');
$routes->post('/api/sales/payment', 'app\controllers\SaleController::pay');
$routes->post('/api/sales/payment_history', 'app\controllers\SaleController::paymentHistory');


$routes->get('/test', 'app\controllers\SaleController::test');

$routes->get('/api/create_users', 'app\controllers\AuthController::createUsers');