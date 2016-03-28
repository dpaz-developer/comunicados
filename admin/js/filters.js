'use strict';

/* Filters */

var module = angular.module('ComunicadosAdminFilters', []);

module.filter('formatDate', function () {
    return function (input) {
        var date = new Date(input);
        var day = date.getDate().toString().length < 2 ? "0" + date.getDate() : date.getDate();
        var currMonth = date.getMonth() + 1;
        var month = currMonth.toString().length < 2 ? "0" + currMonth : currMonth;
        var year = date.getFullYear();

        return day + "/" + month + "/" + year;
    }
});
