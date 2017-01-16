(function () {
    'use strict';

    angular
        .module('ordillosInventoryApp')
        .controller('ReturnReportCtrl', ReturnReportCtrl)
        .factory('Reports', Reports)
        .factory('Sales', Sales)
        .filter('dateToISO', dateToISO);

    function ReturnReportCtrl($scope, $timeout, Reports, Sales) {
        $scope.returns = [];
        $scope.getTotal = null;
        $scope.dateData = {};
        $scope.reportTitle = "Today's Returns Report";
        $scope.loadReturns = function (data) {
            Reports.getReturns(data).then(function (response) {
                console.log(response.data)
                $scope.returns = response.data;
                $scope.getTotalReturns = function () {
                    var total = 0;
                    for (var i = 0; i < response.data.length; i++) {
                        var product = response.data[i];
                        total += product.quantity;
                    }
                    return total;
                }
                if(data != null) { $scope.reportTitle = "Returns Report From " + data.fromDate + " - " + data.toDate }
            }, function (error) {
                console.log(error);
            })
            //Returns to Company
            Reports.getCompanyReturns(data).then(function (response) {
                $scope.companyReturns = response.data;
                $scope.getTotalReturnsToCompany = function () {
                    var total = 0;
                    for (var i = 0; i < response.data.length; i++) {
                        var product = response.data[i];
                        total += product.quantity;
                    }
                    return total;
                }
                if(data != null) { $scope.reportTitle = "Returns Report To Company " + data.fromDate + " - " + data.toDate }
            }, function (error) {
                console.log(error);
            })
        }
        
        $scope.returnDate = function () {
            console.log($scope.dateData)
            var data = {
                'fromDate': $scope.dateData.fromDate,
                'toDate': $scope.dateData.toDate
            }
            $scope.loadReturns(data);
        }
        $scope.printReturn = function (printableArea) {
            var mywindow = window.open('', 'PRINT', 'height=600,width=800');


            mywindow.document.write('<html><head><base href="/" /><title>' + document.title + '</title>');
            //mywindow.document.write('<link rel="stylesheet" href="assets/css/printstyles.css" type="text/css"/>');
            mywindow.document.write('<style>table {width: 100%; border-collapse: collapse;}');
            mywindow.document.write('table, th, td {border: 1px solid black; padding: 1px;}');
            mywindow.document.write('a {text-decoration: none; color: black;}</style>')
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h4> Returns Report </h4>');
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
            Sales.summary(or_number).then(function(response) {
                console.log(response.data)
                $scope.saleData = response.data;
                $scope.or_number = or_number;
                $('#viewSalesSummaryModal').openModal();
            }, function(error) {
                console.log(error);
            })
        }
    }

    function Reports($http) {
        return {
            getReturns: function (data) {
                return $http({
                    url: '/api/reports/returns',
                    method: "GET",
                    params: data
                });
            },
            getCompanyReturns: function (data) {
                return $http({
                    url: '/api/reports/returns-to-company',
                    method: "GET",
                    params: data
                });
            }
        }
    }

    function Sales($http) {
        return {
            all: function(customer_id) {
                return $http.get('api/reports/sales/' + customer_id)
            },
            summary: function(or_number) {
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