(function () {
    'use strict';

    angular
        .module('ordillosInventoryApp')
        .controller('SaleReportCtrl', SaleReportCtrl)
        .factory('Sales', Sales)
        .filter('dateToISO', dateToISO);

    function SaleReportCtrl($scope, $timeout, Sales) {
        $scope.sales = [];
        $scope.getTotal = null;
        $scope.dateData = {};
        $scope.reportTitle = "Today's Sales Report";
        $scope.loadSales = function (data) {
            Sales.getSales(data).then(function (response) {
                console.log(response.data)
                $scope.sales = response.data;
                $scope.getTotalSales = function () {
                    var total = 0;
                    for (var i = 0; i < response.data.length; i++) {
                        var sale = response.data[i];
                        total += sale.sales_total;
                    }
                    return total;
                }
                if (data != null) {
                    $scope.reportTitle = "Sales Report From " + data.fromDate + " - " + data.toDate
                }
            }, function (error) {
                console.log(error);
            })
        }

        $scope.saleDate = function () {
            console.log($scope.dateData)
            var data = {
                'fromDate': $scope.dateData.fromDate,
                'toDate': $scope.dateData.toDate
            }
            $scope.loadSales(data);
        }
        $scope.printReturn = function (printableArea) {
            var mywindow = window.open('', 'PRINT', 'height=600,width=800');


            mywindow.document.write('<html><head><base href="/" /><title>' + document.title + '</title>');
            //mywindow.document.write('<link rel="stylesheet" href="assets/css/printstyles.css" type="text/css"/>');
            mywindow.document.write('<style>table {width: 90%; border-collapse: collapse; margin-left:70px;}');
            mywindow.document.write('table, th, td {border: 1px solid black; padding: 1px;}');
            mywindow.document.write('a {text-decoration: none; color: black;}</style>')
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h4> Sales Report </h4>');
            mywindow.document.write(document.getElementById(printableArea).innerHTML);
            mywindow.document.write('</body></html>');

            // mywindow.document.close(); // necessary for IE >= 10
            //mywindow.focus(); // necessary for IE >= 10*/
            // CHROME
            $timeout(function () {
                jsPrintSetup.print();
                mywindow.close();
            }, 10);
            return true;

        }

        $scope.saleData = [];
        $scope.viewSaleDetails = function (or_number) {
            Sales.summary(or_number).then(function (response) {
                console.log(response.data)
                $scope.saleData = response.data;
                $scope.or_number = or_number;
                $scope.date = response.data[0].created_at;
                $scope.orTotal = function () {
                    var total = 0;
                    for (var i = 0; i < response.data.length; i++) {
                        var sale = response.data[i];
                        total += sale.total_price;
                    }
                    return total;
                }
                $('#viewSalesSummaryModal').openModal();                
            }, function (error) {
                console.log(error);
            })
        }


    }

    function Sales($http) {
        return {
            getSales: function (data) {
                return $http({
                    url: '/api/reports/sales',
                    method: "GET",
                    params: data
                });
            },
            summary: function (or_number) {
                return $http.get('api/reports/sale_summary/' + or_number);
            }
        }
    }

    function dateToISO() {
        return function (input) {
            input = new Date(input).toISOString();
            return input;
        };
    }

})();