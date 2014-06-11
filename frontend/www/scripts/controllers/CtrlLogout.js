(function(){
    'use strict';

    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlLogout',['$scope', '$rootScope', '$location', '$http','localStorageService',function($scope, $rootScope, $location, $http, localStorageService){
        $location.path('/login');
        // LOGOUT
        // ------------------
        // Clear all the user's traces
        if( $rootScope.loggedUser){
            $rootScope.loggedUser = undefined;
            localStorageService.clearAll();
            // Go to login
            $location.path('/login');
        }
    }]);
})();
