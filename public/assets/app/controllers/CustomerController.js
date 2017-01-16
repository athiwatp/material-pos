(function () {
    'use strict';

    angular
        .module('ordillosInventoryApp')
        .controller('CustomerCtrl', CustomerCtrl)
        .factory('Customers', Customers)
        .factory('Sales', Sales);

    function CustomerCtrl($scope, $timeout, DTOptionsBuilder, Customers, Sales) {

        $scope.customers = {};
        $scope.customerData = {}; // set add customer data values to none
        $scope.ucustomerData = {}; // set add customer data values to none

        // DataTables configurable options
        $scope.dtOptions = DTOptionsBuilder.newOptions()
            .withDisplayLength(10)
            .withOption('bLengthChange', false);

        $scope.loadCustomers = function () {
            Customers.getCustomers()
                .then(function (response) {
                    $scope.customers = response.data;
                    $scope.loaderWrapper = true;
                    $scope.customerSpinner = true;
                }, function (error) {
                    console.log(error);
                });
        }

        $scope.openAddCustomerModal = function () {
            $('#addCustomerModal').openModal();
        }

        $scope.addCustomer = function () {
            if ($scope.customerData.full_name != null) {
                var data = {
                    'name': $scope.customerData.full_name,
                    'company': $scope.customerData.company,
                    'address': $scope.customerData.address,
                    'credit_limit': $scope.customerData.credit_limit,
                    'email': $scope.customerData.email,
                    'contact': $scope.customerData.contact
                };

                Customers.addCustomer(data)
                    .then(function (response) {
                        $scope.customerSpinner = true;
                        var message = response.data.message;
                        console.log(response);
                        // start add to array
                        var addData = {
                            'customer_id': response.data.customer_id,
                            'customer_name': $scope.customerData.full_name,
                            'customer_credit_limit': $scope.customerData.credit_limit,
                        }
                        $scope.customers.push(addData);
                        // end add to array
                        $scope.customerData = {};
                        Materialize.toast('<i class="mdi-navigation-check left"></i> ' + message, 3000, 'green darken-2 white-text');
                    }, function (error) {
                        console.log(error);
                    });
            } else {
                Materialize.toast('<i class="mdi-navigation-close left"></i> Full name is required', 3000, 'red darken-2 white-text');
            }
        }

        $scope.openViewCustomerModal = function (customer_id, index) {
            Customers.getOneCustomer(customer_id)
                .then(function (response) {
                    $scope.ucustomerData = response.data;
                    $scope.indexData = index;
                    Customers.getCustomerStatus(response.data.status);
                    $('#viewCustomerModal').openModal();
                }, function (error) {
                    console.log(error);
                })
        }

        $scope.updateCustomer = function (customer_id) {
            if ($scope.ucustomerData.customer_name != "") {
                var data = {
                    'id': $scope.ucustomerData.customer_id,
                    'name': $scope.ucustomerData.customer_name,
                    'company': $scope.ucustomerData.customer_company,
                    'address': $scope.ucustomerData.customer_address,
                    'email': $scope.ucustomerData.customer_email,
                    'contact': $scope.ucustomerData.customer_contact,
                    'credit_limit': $scope.ucustomerData.customer_credit_limit
                }
                Customers.updateCustomer(data)
                    .then(function (response) {
                        console.log(response);
                        $scope.customers[$scope.indexData] = $scope.ucustomerData;
                        var message = response.data.message;
                        Materialize.toast('<i class="mdi-navigation-check left"></i> ' + message, 3000, 'green darken-2 white-text');
                    }, function (error) {
                        console.log(error);
                    });
            } else {
                Materialize.toast('<i class="mdi-navigation-close left"></i> Full name is required', 3000, 'red darken-2 white-text');
            }
        }

        $scope.updateCustomerStatus = function (status, customer_id) {
            var data = {
                'status': status,
                'customer_id': customer_id
            }
            Customers.updateCustomerStatus(data)
                .then(function (response) {
                    $('#viewCustomerModal').closeModal();
                    $scope.loadCustomers();
                    var message = response.data.message;
                    Materialize.toast('<i class="mdi-navigation-check left"></i> ' + message, 3000, 'green darken-2 white-text');
                }, function (error) {
                    console.log(error);
                });
        }

        $scope.sales = [];
        $scope.openSalesModal = function (customer_id) {
            Sales.all(customer_id).then(function (response) {
                console.log(response.data);
                $scope.sales = response.data;
                $scope.customerId = customer_id;
                $('#viewSalesModal').openModal();
            }, function (error) {
                console.log(error);
            })
        }

        $scope.saleData = [];
        $scope.viewSaleDetails = function (or_number) {
            Sales.summary(or_number).then(function (response) {
                console.log(response.data)
                $scope.saleData = response.data;
                $scope.or_number = or_number;
                $scope.totalAmount = function () {
                    var total = 0;
                    for (var i = 0; i < $scope.saleData.length; i++) {
                        var quantity = $scope.saleData[i].total_price;
                        total += quantity;
                    }
                    return total;
                }
                $('#viewSalesSummaryModal').openModal();
            }, function (error) {
                console.log(error);
            })
        }

        $scope.selectOR = function (or_number, sales_id) {
            $scope.paymentOR_number = or_number;
            $scope.sales_id = sales_id
            $('#paymentModal').openModal();
        }

        $scope.payOR = function (sales_id) {
            //date
            var dateObj = new Date();
            var month = dateObj.getUTCMonth() + 1; //months from 1-12
            var day = dateObj.getUTCDate();
            var year = dateObj.getUTCFullYear();

            var newdate = month + "/" + day + "/" + year;
            // end date
            Sales.payment(sales_id, $scope.paymentData.amount, $scope.paymentOR_number, $scope.paymentData.notes).then(function (response) {
                var message = response.data.message;
                if (response.data.success === false) {
                    Materialize.toast('<i class="mdi-navigation-close left"></i> ' + message, 3000, 'red darken-2 white-text');
                } else {
                    $scope.paymentData.amount = null;
                    $('#paymentModal').closeModal();
                    var mywindow = window.open('', 'PRINT', 'height=600,width=800');
                    mywindow.document.write('<html><head><base href="/" /><title>' + document.title + '</title>');
                    mywindow.document.write('<style>.underliner{ border-bottom: 1px solid black; width: 80%; display: block; }</style>');
                    mywindow.document.write('</head><body >');
                    mywindow.document.write('<h2><center><b>RECEIPT</b></center></h2>');
                    mywindow.document.write('<table style="border: none; width: 100%;"><tr><td style="width: 85%">No. ' + $scope.paymentOR_number + '</td><td>Date ' + newdate + '</td></tr></table>');
                    //mywindow.document.write('<p style="text-indent: 10px;">Received from <span class="underliner" style="margin-left:100px"></span></p>');
                    //mywindow.document.write('<p >the sum of Pesos <span class="underliner" style="margin-left:100px">'+ response.data.amountText +'</span></p>');
                    mywindow.document.write('<table style="border: none; width: 100%; padding: 5"><tr><td style="text-align:justify; text-indent:2px">Received from<td><td width="80%" style="border-bottom:1px solid black"></td></tr>');
                    mywindow.document.write('<tr><td style="text-align:justify;">the sum of Pesos<td><td width="85%" style="border-bottom:1px solid black">'+ response.data.amountText +'</td></tr>');
                    mywindow.document.write('<tr><td style="text-align:justify;">as payment for<td><td width="85%" style="border-bottom:1px solid black">'+ $scope.paymentData.notes +'</td></tr>');
                    mywindow.document.write('</table>');
                    mywindow.document.write('</body></html>');
                    $timeout(function () {
                        jsPrintSetup.print();
                        jsPrintSetup.setOption('headerStrLeft', '');
                        jsPrintSetup.setOption('headerStrRight', '');
                        jsPrintSetup.setOption('footerStrLeft', '');
                        jsPrintSetup.setOption('footerStrRight', '');
                        jsPrintSetup.setOption('marginTop', 1.016);
                        $scope.paymentData = {};
                        mywindow.close();
                        Materialize.toast('<i class="mdi-navigation-check left"></i> ' + message, 3000, 'green darken-2 white-text');
                        return true;
                    }, 10);
                }

            }, function (error) {
                console.log(error)
            })
        }

        $scope.viewPaymentHistory = function (or_number) {
            Sales.paymentHistory(or_number).then(function (response) {
                $scope.paymentHistoryData = response.data;
                $scope.payment_or_number = or_number;
                console.log(response);
                $scope.paymentTotal = function () {
                    var total = 0;
                    for (var i = 0; i < $scope.paymentHistoryData.length; i++) {
                        var amount = $scope.paymentHistoryData[i].payment_amount;
                        total += amount;
                    }
                    return total;
                }
                $('#viewPaymentHistoryModal').openModal();
            }, function (error) {
                console.log(error);
            })
        }


    };

    function Customers($http) {
        return {
            getCustomers: function () {
                return $http.get('/api/customers');
            },
            getOneCustomer: function (customer_id) {
                return $http.get('/api/customers/' + customer_id);
            },
            addCustomer: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/customers',
                    data: data
                });
            },
            deleteCustomer: function (customer_id) {
                return $http.get('/api/customers/' + customer_id + '/delete');
            },
            updateCustomer: function (data) {
                return $http({
                    method: 'PUT',
                    url: '/api/customers',
                    data: data
                });
            },
            updateCustomerStatus: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/customers/update_status',
                    data: data
                });
            },
            getCustomerStatus: function (data) {
                if (data == 0) {
                    speak('Customer is not active.', {
                        variant: "f5"
                    });
                } else {
                    speak('Customer is active.'), {
                        variant: "f5"
                    };
                }
            }
        };
    };

    function Sales($http) {
        return {
            all: function (customer_id) {
                return $http.get('api/reports/sales/' + customer_id)
            },
            summary: function (or_number) {
                return $http.get('api/reports/sale_summary/' + or_number);
            },
            payment: function (sales_id, amount, or_number, notes) {
                return $http({
                    method: 'POST',
                    url: '/api/sales/payment',
                    data: {
                        'sales_id': sales_id,
                        'amount': amount,
                        'or_number': or_number,
                        'notes': notes
                    }
                });
            },
            paymentHistory: function (or_number) {
                return $http({
                    method: 'POST',
                    url: '/api/sales/payment_history',
                    data: {
                        'or_number': or_number
                    }
                });
            }
        }
    }

})();