(function () {
    'use strict';

    angular
        .module('ordillosInventoryApp', ["datatables"])
        .config(config);

    function config($interpolateProvider) {
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    };

})();