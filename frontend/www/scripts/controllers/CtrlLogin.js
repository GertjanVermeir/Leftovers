(function(){
    'use strict';

    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlLogin',['$scope', '$rootScope', '$http','$location','localStorageService', function($scope, $rootScope, $http, $location, localStorageService){


        // LOGIN
        // ------------------
        $scope.login = function (user)
        {
            // reset the error message
            $scope.error = "";

            // check if form is valid
            if($scope.loginForm.$valid){

//                console.log($httpProvider.defaults);

                // post request to api
                user = JSON.stringify(user);
                var apiUrl = $rootScope.linkAPI +"login";

                $http.post(apiUrl, user).success(function(result){
                    if(result != '"mislukt"')
                    {
                        $rootScope.loggedUser = result;
                        localStorageService.set('user', result);
                        $location.path('/home');

                    }else{
                        $scope.error= "Incorrect password or email!";
                    }
                });
            }
            // Form invalid
            else{
                $scope.error = "The form is invalid";
            }

            // Lay-out fixes
            $scope.init = function () {
                var ch = $(document).height();
                $('#login').css({'height':ch+'px'});
            };

            window.onresize = function(event) {
                $scope.init();
            };
        };
    }]);
})();
