(function () {
    'use strict';

    angular
        .module('ordillosInventoryApp')
        .controller('SaleCtrl', SaleCtrl)
        .factory('Customer', Customer)
        .factory('Product', Product)
        .factory('Sale', Sale)
        .directive('ngConfirmClick', ngConfirmClick);

    function SaleCtrl($scope, DTOptionsBuilder, $timeout, Customer, Product, Sale) {
        // DataTables configurable options
        $scope.dtOptions = DTOptionsBuilder.newOptions()
            .withDisplayLength(10)
            .withOption('bLengthChange', false);
        $scope.saleData = {
            'quantity': 0,
            'price': 0,
            'amount': 0
        };
        $scope.customers = [];
        $scope.products = [];
        $scope.invoiceData = [];

        $scope.selectCustomer = function () {
            Customer.getCustomers()
                .then(function (response) {
                    $('#addCustomerModal').openModal();
                    $scope.customers = response.data;
                }, function (error) {
                    console.log(error);
                });

        }

        $scope.addCustomer = function (customer_id) {
            Customer.getOneCustomer(customer_id).then(function (response) {
                console.log(response)
                $scope.saleData.customer_id = response.data.customer_id;
                $scope.saleData.customer_name = response.data.customer_name;
                $('#addCustomerModal').closeModal();
            }, function (error) {
                console.log(error);
            })
        }

        $scope.selectProduct = function () {
            Product.getProducts()
                .then(function (response) {
                    $('#addProductModal').openModal();
                    $scope.products = response.data;
                }, function (error) {
                    console.log(error);
                });
        }

        $scope.addProduct = function (product_id) {
            Product.getOneProduct(product_id).then(function (response) {
                console.log(response)
                $scope.saleData.product_id = response.data.product_id;
                $scope.saleData.product_code = response.data.product_code;
                $scope.saleData.product_name = response.data.product_name;
                $scope.saleData.price = response.data.product_price;
                $('#addProductModal').closeModal();
            }, function (error) {
                console.log(error);
            })
        }

        $scope.addToCart = function () {
            if ($scope.saleData.customer_name == null) {
                Materialize.toast('<i class="mdi-navigation-close left"></i> Select a Customer', 3000, 'red darken-2 white-text');
                return true;
            } else if ($scope.saleData.quantity == 0 || $scope.saleData.quantity == null) {
                Materialize.toast('<i class="mdi-navigation-close left"></i> Invalid Quantity', 3000, 'red darken-2 white-text');
                return true;
            }
            var invoiceDataArray = $.grep($scope.invoiceData, function (e) {
                return e.product_id === $scope.saleData.product_id;
            });
            Product.getOneProduct($scope.saleData.product_id).then(function (response) {
                console.log(response.data);
                var currentQuantity = response.data.product_quantity;
                if (currentQuantity >= $scope.saleData.quantity) {
                    var addNew = {
                            'customer_id': $scope.saleData.customer_id,
                            'product_name': $scope.saleData.product_name,
                            'product_id': $scope.saleData.product_id,
                            'product_price': $scope.saleData.price,
                            'product_quantity': $scope.saleData.quantity,
                            'product_amount': $scope.saleData.quantity * $scope.saleData.price,
                        }
                        // Check if it's already in the cart so update the quantity
                    if (invoiceDataArray.length === 0) {
                        $scope.invoiceData.push(addNew);
                    } else if (invoiceDataArray.length === 1) {
                        var newQuantity = $scope.saleData.quantity + invoiceDataArray[0].product_quantity;
                        // check if total quantity fits to the current quantity
                        if (newQuantity > currentQuantity) {
                            speak('Quantity is low.');
                            Materialize.toast('<i class="mdi-navigation-close left"></i> Quantity is low. ' + currentQuantity + ' items left', 3000, 'red darken-2 white-text');
                        } else {
                            Materialize.toast('<i class="mdi-navigation-check left"></i> Quantity updated.', 3000, 'green darken-2 white-text');
                            invoiceDataArray[0].product_quantity = newQuantity;
                        }

                    }
                    // add to cart
                    $scope.saleData.quantity = 0;
                    var totalAmount = function () {
                        var total = 0;
                        for (var i = 0; i < $scope.invoiceData.length; i++) {
                            var product = $scope.invoiceData[i];
                            total += product.product_amount;
                        }
                        return total;
                    }
                    $scope.saleData.totalAmount = totalAmount();
                } else {
                    speak('Quantity is low.');
                    Materialize.toast('<i class="mdi-navigation-close left"></i> Quantity is low. ' + currentQuantity + ' items left', 3000, 'red darken-2 white-text');
                }
            }, function (error) {
                console.log(error);
            })
        }

        $scope.removeItem = function (inv) {
            var index = $scope.invoiceData.indexOf(inv);
            $scope.invoiceData.splice(index, 1);
            var totalAmount = function () {
                var total = 0;
                for (var i = 0; i < $scope.invoiceData.length; i++) {
                    var product = $scope.invoiceData[i];
                    total += product.product_amount;
                }
                return total;
            }
            $scope.saleData.totalAmount = totalAmount();
        }

        $scope.printReturn = function (printableArea) {
            $("#totalAmountSale").css("display", "block");
            //date
            var dateObj = new Date();
            var month = dateObj.getUTCMonth() + 1; //months from 1-12
            var day = dateObj.getUTCDate();
            var year = dateObj.getUTCFullYear();

            var newdate = month + "/" + day + "/" + year;
            // end date
            var type = function () {
                if ($scope.isCash === true) {
                    return 0;
                } else {
                    return 1;
                }
            }
            $scope.invoiceData[0].transaction_type = type();
            //$scope.or_number = null; 
            Sale.new($scope.invoiceData).then(function (response) {
                //$scope.or_number = response.data.or_number;
                var mywindow = window.open('', 'PRINT', 'height=600,width=800');

                mywindow.document.write('<html><head><base href="/" /><title>' + document.title + '</title>');
                // mywindow.document.write('<link rel="stylesheet" href="assets/css/custom/sales-styles.css" type="text/css" />');
                mywindow.document.write('<style>table {width: 100%;} table, th, tr, td {padding: 0.2em; border: 1px solid black; border-collapse: collapse;}');
                mywindow.document.write('a {text-decoration: none; color: black;} .hideonPrint {display: none;}</style>')
                    //mywindow.document.write('.customerName {margin-left: 50px;}</style>')
                mywindow.document.write('</head><body >');
                mywindow.document.write('<span style="font-style: large;">TRUST RECEIPT AGREEMENT</span><br>');
                mywindow.document.write('<span style="float: right;">No.  <b>' + response.data.or_number + '</b></span><br><br>');
                mywindow.document.write('<table><tr><td style="width: 80%">Entrusted To: <b>' + $scope.saleData.customer_name + '</b></td><td>' + newdate + '</td></tr>');
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
                    mywindow.close();
                    $scope.invoiceData = [];
                    $scope.saleData.totalAmount = 0;
                    Materialize.toast('<i class="mdi-navigation-check left"></i> Sale success!', 3000, 'green darken-2 white-text');
                    $("#totalAmountSale").css("display", "none");
                    return true;
                }, 10);
                console.log(response);
            }, function (error) {
                console.log(error);
            })

        }
    }

    function Customer($http) {
        return {
            getCustomers: function () {
                return $http.get('/api/customers');
            },
            getOneCustomer: function (customer_id) {
                return $http.get('/api/customers/' + customer_id);
            },
        }
    }

    function Product($http) {
        return {
            getProducts: function () {
                return $http.get('/api/products');
            },
            getOneProduct: function (product_id) {
                return $http.get('/api/products/' + product_id);
            }
        }
    }

    function Sale($http) {
        return {
            new: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/sales',
                    data: data
                });
            }
        }
    }

    function ngConfirmClick() {
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind('click', function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        }
    }

})();