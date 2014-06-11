(function(){
    'use strict';

    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRegister',['$scope', '$rootScope', '$http', function($scope, $rootScope, $http){

        $scope.formPage = 0;


        // Registration
        // ------------------
        $scope.register = function(user){

            // check if passwords are the same
            if($scope.registerForm.password.$modelValue == $scope.registerForm.password_repeated.$modelValue)
            {
                // passwords correct
                $scope.formerror = "";

                // check form validation
                if($scope.registerForm.$valid){
                    // form valid
                    var apiUrl = $rootScope.linkAPI + "checkuser/" + $scope.registerForm.email.$modelValue;
                    var userUrl =  $rootScope.linkAPI + "user";

                    // check unique email
                    $http.get(apiUrl).success(function(result){
                        var data = result;
                        // email is not used
                        if(data != 'true')
                        {
                            user = JSON.stringify(user);

                            // sent post with registration
                            $http.post(userUrl, user).success(function(result){
                                if(result === '"gelukt!"')
                                {
                                    // registration success
                                    $scope.formPage = 1;
                                }else{
                                    // registration failed
                                    $scope.formerror = "An error has occurred. Please try again later.";
                                }
                            });
                        }
                        // email in use
                        else{ $scope.formerror = "Email already in use!"; }
                    });
                }
                // form invalid
                else{ $scope.formerror = "The form is not valid!"; }
            }
            // passwords incorrect
            else{ $scope.formerror = "Passwords don't match"; }
        };

    }]);
})();


