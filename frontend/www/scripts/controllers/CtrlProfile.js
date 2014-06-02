(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    // Set up as CtrlCampusPicker
    controllers.controller('Gj.Leftovers.Controllers.CtrlProfile',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location',
        function($scope, $rootScope, $http, localStorageService, $location)
        {

            $rootScope.Title = "Mijn Profiel";

            var apiUrl = $rootScope.linkAPI + "user/2?jsonp=JSON_CALLBACK";

            $http.jsonp(apiUrl).
                success(function(data, status, headers, config){
                    $scope.profile = data;
                    console.log(data);
                    $scope.profileInitialized = true;
                }).
                error(function(data, status, headers, config){
                    alert('Gebruiker kon niet gevonden worden.');
                });

        }])
})()