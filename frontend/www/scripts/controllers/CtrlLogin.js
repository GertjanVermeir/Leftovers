(function(){
    'use strict';

    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlLogin',['$scope', '$rootScope', '$http','$location','localStorageService', function($scope, $rootScope, $http, $location, localStorageService){


        $scope.loading = false;
        $scope.loaded = true;

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

                $scope.loading = true;

                var apiUrl = $rootScope.linkAPI +"login";

                $http.post(apiUrl, user).success(function(result){
                    if(result != '"mislukt"')
                    {
                        $rootScope.loggedUser = result;
                        localStorageService.set('user', result);
                        $scope.loading = false;
                        $location.path('/home');

                    }else{
                        $scope.error= "Verkeerde email/paswoord combinatie!";
                        $scope.loading = false;
                    }
                });
            }
            // Form invalid
            else{
                $scope.error = "Ongeldige invoer.";
            }

        };

        // Lay-out fixes
        $scope.init = function () {
            var ch = $(document).height();


            var logh = $('#form-holder').height();
            var pich = ch - logh - 29;

            $('.picture').css({'height':pich +'px'});
        };

        window.onresize = function(event) {
            $scope.init();
        };

        $scope.init();
    }]);
})();
