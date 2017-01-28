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
        $scope.viewSaleDetails = function (or_number, created_at) {
            Sales.summary(or_number).then(function (response) {
                $scope.created_at_reprint = created_at;
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
                    mywindow.document.write('<h3><center>RECEIPT</center></h3>');
                    mywindow.document.write('<table style="border: none; width: 90%; margin-left: 50px;"><tr><td style="width: 85%">No. ' + $scope.paymentOR_number + '</td><td>Date ' + newdate + '</td></tr></table>');
                    //mywindow.document.write('<p style="text-indent: 10px;">Received from <span class="underliner" style="margin-left:100px"></span></p>');
                    //mywindow.document.write('<p >the sum of Pesos <span class="underliner" style="margin-left:100px">'+ response.data.amountText +'</span></p>');
                    mywindow.document.write('<table style="border: none; width: 90%; padding: 3; margin-left:50px;"><tr><td style="text-align:justify; text-indent:5px">Received from<td><td width="80%" style="border-bottom:1px solid black"></td></tr>');
                    mywindow.document.write('<tr><td style="text-align:justify;">the sum of Pesos<td><td width="80%" style="border-bottom:1px solid black">' + response.data.amountText + '</td></tr>');
                    mywindow.document.write('<tr><td style="text-align:justify;">as payment for<td><td width="80%" style="border-bottom:1px solid black">' + $scope.paymentData.notes + '</td></tr>');
                    mywindow.document.write('</table><br>');
                    mywindow.document.write('<div style="margin-left:100px;">P<span style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>');
                    mywindow.document.write('<div style="margin-left:800px;"><span style="text-decoration:overline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>');
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

        $scope.reprint = function (or_number, printableArea) {
            var dateObj = new Date($scope.created_at_reprint);
            var month = dateObj.getUTCMonth() + 1; //months from 1-12
            var day = dateObj.getUTCDate();
            var year = dateObj.getUTCFullYear();

            var newdate = month + "/" + day + "/" + year;
            var mywindow = window.open('', 'PRINT', 'height=600,width=800');
            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('<style>table {width: 90%; margin-left:70px;} table, th, tr, td {padding: 0.2em; border: 1px solid black; border-collapse: collapse;} </style>');
            //mywindow.document.write('.customerName {margin-left: 50px;}</style>')
            mywindow.document.write('</head><body >');
            mywindow.document.write('<div style="width: 90%; margin-left:70px;"><span style="font-style: large;">TRUST RECEIPT AGREEMENT</span>');
            mywindow.document.write('<span style="float: right;">No.  <b>' + or_number + '</b></span></div><br><br>');
            mywindow.document.write('<table><tr><td style="width: 80%">Entrusted To: </td><td>' + newdate + '</td></tr>');
            mywindow.document.write('<tr><td colspan="2">By:</td></tr></table><br>');
            //mywindow.document.write('<span class="orNumber">' + or_number + '</span>');
            mywindow.document.write(document.getElementById(printableArea).innerHTML);
            mywindow.document.write('<br>');
            mywindow.document.write('<div style="font-size: small;"><p style="text-indent: 30px;">Received from ________________________(Entruster) the merchandise listed and described above and in consideration thereof the undersigned hereby agrees to hold the said merchandise IN TRUST for the Entruster for the purpose specified herein.');
            mywindow.document.write('<p style="text-indent: 30px;">The undersigned hereby agrees to sell the merchandise listed and described above and to turn over to the Entruster the proceeds of such sale to the extent specified above on or before its due date which shall be ___________________ from date of execution hereof. Before remittance of the sales proceeds to the Entruster, the undersigned shall hold such proceeds in trust for the Enteruster. Any commission or rebate shall be forfeited upon failure of the undersigned to remit to the Entruster full amount specified above on or before the due date. I ncase the merchandise listed and described above are not sold on the date, the undersigned shall deliver such unsold merchandise to the Entruster.</p>');
            mywindow.document.write('<p style="text-indent: 30px;">Any action arising out of or in connection with this Trust Receipt shall be instituted in any court.</p></div><br><br>');
            mywindow.document.write("<span style='text-decoration:overline; text-align:center;'><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entrustee's Signature over Printed Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></span>");
            mywindow.document.write('</body></html>');

            // mywindow.document.close(); // necessary for IE >= 10
            //mywindow.focus(); // necessary for IE >= 10*/

            $timeout(function () {
                //mywindow.print();
                jsPrintSetup.print();
                jsPrintSetup.setOption('headerStrLeft', '');
                jsPrintSetup.setOption('headerStrRight', 'Some text here');
                jsPrintSetup.setOption('footerStrLeft', '');
                jsPrintSetup.setOption('footerStrRight', '');
                jsPrintSetup.setOption('marginTop', 1.016);
                jsPrintSetup.setOption('marginLeft', 0);
                mywindow.close();
                return true;
            }, 10);
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