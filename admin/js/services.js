'use strict';

/* Services */

var module = angular.module('ComunicadosAdminServices', ['ngResource']);



module.factory('Broadcast', function ($rootScope) {
    var broadcastService = {
        broadcast:function (event) {
            $rootScope.$broadcast.apply($rootScope, arguments);
        }};
    return broadcastService;
});
