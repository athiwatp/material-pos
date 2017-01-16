(function () {
    'use strict';

    angular
        .module('ordillosInventoryApp')
        .controller('parentCtrl', parentCtrl);

    function parentCtrl($scope, $http) {
        $scope.logs = [];
        $scope.logNavOut = function () {
            $("#sidemenu").trigger("click");
            $http({
                method: "GET",
                url: "/api/logs"
            }).then(function mySucces(response) {
                $scope.logs = response.data;
                console.log(response.data);
            }, function myError(response) {
                console.log(response.statusText);
            });
        }
        
    }

})();