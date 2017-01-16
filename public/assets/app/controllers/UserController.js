(function() {
    'use strict';
    
angular
    .module('ordillosInventoryApp')
    .controller('UserCtrl', UserCtrl);

function UserCtrl($scope) {
    $scope.doLogin = function() {
        alert('aw');
    }
}

})();