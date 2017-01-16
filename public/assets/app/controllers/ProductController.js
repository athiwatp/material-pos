(function () {
    'use strict';

    angular
        .module('ordillosInventoryApp')
        .controller('ProductCtrl', ProductCtrl)
        .factory('Products', Products);

    function ProductCtrl($scope, Products, DTOptionsBuilder) {
        $scope.products = [];
        $scope.productData = {};
        $scope.updateQty = {};

        // DataTables configurable options
        $scope.dtOptions = DTOptionsBuilder.newOptions()
            .withDisplayLength(10)
            .withOption('bLengthChange', false);

        $scope.loadProducts = function () {
            Products.getProducts().then(function (response) {
                $scope.products = response.data;
            }, function (error) {
                console.log(error);
            })
        }

        $scope.openViewProductModal = function (product_id, index) {
            Products.getOneProduct(product_id)
                .then(function (response) {
                    $scope.uproductData = response.data;
                    $scope.indexData = index;
                    $('#viewProductModal').openModal();
                }, function (error) {
                    console.log(error);
                })
        }

        $scope.openAddProductModal = function () {
            $('#addProductModal').openModal();
        }

        $scope.addProduct = function () {
            if ($scope.productData.product_code == null || $scope.productData.product_name == null) {
                Materialize.toast('<i class="mdi-navigation-close left"></i> Product code and name are required', 3000, 'red darken-2 white-text');
            } else {
                // Check first if code is unique
                Products.checkProductCode($scope.productData.product_code).then(function (response) {
                    console.log(response);
                    if (response.data.success === true) {
                        Materialize.toast('<i class="mdi-navigation-close left"></i> Product code is already in use', 3000, 'red darken-2 white-text');
                    } else {
                        $scope.productData.product_quantity = 0;
                        var data = {
                            'code': $scope.productData.product_code,
                            'name': $scope.productData.product_name,
                            'price': $scope.productData.product_price,
                        };
                        Products.addProduct(data)
                            .then(function (response) {
                                console.log(response);
                                // add to array
                                $scope.productData.product_id = response.data.product_id;
                                $scope.products.push($scope.productData);
                                // end add to array
                                var message = response.data.message;
                                $scope.productData = {};
                                Materialize.toast('<i class="mdi-navigation-check left"></i> ' + message, 3000, 'green darken-2 white-text');
                            }, function (error) {
                                console.log(error);
                            });
                    }
                }, function (error) {
                    console.log(error);
                })
            }
        }

        $scope.updateProduct = function (product_id) {
            if ($scope.uproductData.product_name == null || $scope.uproductData.product_code == null) {
                toast('<i class="fa fa-close"></i>&nbsp; Product Name and Code are required.', 'toastError');
            } else {
                var data = {
                    'id': product_id,
                    'name': $scope.uproductData.product_name,
                    'code': $scope.uproductData.product_code,
                    'price': $scope.uproductData.product_price,
                }
                Products.updateProduct(data)
                    .then(function (response) {
                        $scope.productData = {};
                        var message = response.data.message;
                        $scope.products[$scope.indexData] = $scope.uproductData;
                        Materialize.toast('<i class="mdi-navigation-check left"></i> ' + message, 3000, 'green darken-2 white-text');
                    }, function (error) {
                        console.log(error);
                    });
            }
        }

        $scope.addQuantityModal = function (product_id, index) {
            Products.getOneProduct(product_id)
                .then(function (response) {
                    $scope.productQty = response.data;
                    $scope.index = index;
                    $('#addQtyModal').openModal();
                }, function (error) {
                    console.log(error);
                })
        }

        $scope.isReturn = false;
        $scope.addQty = function (product_id, index) {
            if ($scope.addItemData.qty == null || $scope.addItemData.qty == 0) {
                Materialize.toast('<i class="mdi-navigation-close left"></i> Invalid Quantity', 3000, 'red darken-2 white-text');
                return;
            }
            var type = function () {
                if ($scope.isReturn == true) {
                    return 2;
                } else {
                    return 1;
                }
            }
            var or_number = function () {
                if ($scope.addItemData.or_number == "" || $scope.addItemData.or_number == null) {
                    return 'Not Provided';
                } else {
                    return $scope.addItemData.or_number;
                }
            }
            var data = {
                'id': product_id,
                'quantity': $scope.addItemData.qty,
                'or_number': or_number(),
                'type': type()
            }
            Products.addQuantity(data)
                .then(function (response) {
                    var newQuantity = $scope.addItemData.qty + $scope.productQty.product_quantity;
                    $scope.productQty.product_quantity = newQuantity;
                    $scope.products[$scope.index].product_quantity = newQuantity;
                    $scope.addItemData.qty = 0;
                    $scope.isReturn = false;
                    Materialize.toast('<i class="mdi-navigation-check left"></i> ' + response.data.message, 3000, 'green darken-2 white-text');
                }, function (error) {
                    console.log(error);
                })

        }

        $scope.searchCustomer = function () {
            Products.getCustomers()
                .then(function (response) {
                    console.log(response.data.length);
                    for (var i = 0, len = response.data.length; i < len; ++i) {
                        $scope.customers.push(response.data[i].customer_name);
                    }
                    console.log($scope.customers);
                }, function (error) {
                    console.log(error)
                })
        }

        $scope.isReturnToCompany = false;
        $scope.returnToCompany = function (product_id, indexData) {
            if ($scope.returnToCompanyData.qty > $scope.uproductData.product_quantity) {
                Materialize.toast('<i class="mdi-navigation-close left"></i> Insufficient quantity', 3000, 'red darken-2 white-text');
                return true;
            }
            var or_number = function () {
                if ($scope.returnToCompanyData.or_number == "" || $scope.returnToCompanyData.or_number == null) {
                    return 'Not Provided';
                } else {
                    return $scope.returnToCompanyData.or_number;
                }
            }
            var data = {
                'id': product_id,
                'quantity': $scope.returnToCompanyData.qty,
                'or_number': or_number(),
                'type': 3
            }
            Products.deductQuantity(data).then(function (response) {
                var newQuantity = $scope.uproductData.product_quantity - $scope.returnToCompanyData.qty;
                $scope.returnToCompanyData.qty = newQuantity;
                $scope.products[indexData].product_quantity = newQuantity;
                $scope.uproductData.product_quantity = newQuantity;
                $scope.returnToCompanyData = {};
                $scope.isReturnToCompany = false;
                Materialize.toast('<i class="mdi-navigation-check left"></i> ' + response.data.message, 3000, 'green darken-2 white-text');
            }, function (error) {
                console.log(error)
            })
        }


    }

    function Products($http) {
        return {
            getProducts: function () {
                return $http.get('/api/products');
            },
            getOneProduct: function (product_id) {
                return $http.get('/api/products/' + product_id);
            },
            addProduct: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/products',
                    data: data
                });
            },
            addQuantity: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/products/add_quantity',
                    data: data
                });
            },
            updateProduct: function (data) {
                return $http({
                    method: 'PUT',
                    url: '/api/products',
                    data: data
                });
            },
            deductQuantity: function (data) {
                return $http({
                    method: 'POST',
                    url: '/api/products/deduct_quantity',
                    data: data
                });
            },
            getCustomers: function () {
                return $http.get('/api/customers');
            },
            checkProductCode: function (product_code) {
                return $http.get('/api/check_code/' + product_code)
            }
        };
    }


})();