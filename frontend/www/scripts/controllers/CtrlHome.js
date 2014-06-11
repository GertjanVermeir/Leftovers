(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlHome',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$timeout', '$location',
        function($scope, $rootScope, $http, localStorageService, $timeout, $location)
        {

            $rootScope.Title = "Leftovers";

        }])
})()