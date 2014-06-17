(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlProfile',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location',
        function($scope, $rootScope, $http, localStorageService, $location)
        {

            $rootScope.Title = "Mijn Profiel";

            $scope.profile = $rootScope.loggedUser;
            $scope.profileInitialized = true;

            $scope.number = 3;

        }])
})()