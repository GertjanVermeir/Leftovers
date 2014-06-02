(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    // Set up as CtrlCampusPicker
    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipes',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location',
        function($scope, $rootScope, $http, localStorageService, $location)
        {

            $rootScope.Title = "Recepten";

        }])
})()