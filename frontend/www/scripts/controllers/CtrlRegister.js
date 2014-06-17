(function(){
    'use strict';

    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRegister',['$scope', '$rootScope', '$http','localStorageService','$upload', '$location',function($scope, $rootScope, $http, localStorageService, $upload,$location){

        $scope.formPage = 0;
        var userUrl =  $rootScope.linkAPI + "user";

        // Registration
        // ------------------
        $scope.validate = function(user){

            // check if passwords are the same
            if($scope.registerForm.password.$modelValue == $scope.registerForm.password_repeated.$modelValue)
            {
                // passwords correct
                $scope.formerror = "";

                // check form validation
                if($scope.registerForm.$valid){
                    // form valid
                    var apiUrl = $rootScope.linkAPI + "checkuser/" + $scope.registerForm.email.$modelValue;

                    if($scope.fileName){
                        // check unique email
                        $http.get(apiUrl).success(function(result){
                            var data = result;
                            // email is not used
                            if(data != 'true')
                            {
                                $scope.uploadImage($scope.files,user);
                            }
                            // email in use
                            else{ $scope.formerror = "E-mailadres reeds in gebruik."; }
                        });
                    }
                    else{ $scope.formerror = "Kies een profielfoto."; }

                }
                // form invalid
                else{ $scope.formerror = "Het formulier bevat fouten."; }
            }
            // passwords incorrect
            else{ $scope.formerror = "Paswoorden zijn niet identiek."; }
        };

        $scope.register = function(user,image){
            user.picture = image;
            user = JSON.stringify(user);
            // sent post with registration
            $http.post(userUrl, user).success(function(result){
                if(result)
                {
                    localStorageService.set('user', result);
                    $rootScope.loggedUser = result;
                    // registration success
                    $location.path('/home');
                }else{
                    // registration failed
                    $scope.formerror = "Er is een fout opgetreden. Probeer later nog eens.";
                }
            });
        }

        // File Upload
        // ------------------
        $scope.onFileSelect = function($files,user) {
            $scope.fileName = $files[0].name;
            $scope.files = $files;
        };

        $scope.uploadImage = function($files,user){

            for (var i = 0; i < $files.length; i++) {
                var file = $files[i];
                var image = '';
                $scope.upload = $upload.upload({
                    url: $rootScope.linkAPI + 'image/user', //upload.php script, node.js route, or servlet url
                    data: {},
                    file: file
                }).progress(function(evt) {
                    //console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                }).success(function(data, status, headers, config) {
                    // file is uploaded successfully
                    image = data.substring(1, data.length-1);
                }).then(function() {
                    $scope.register(user,image);
                });
                //.error(...)
                //.then(success, error, progress);
                //.xhr(function(xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
            }
        };

    }]);
})();


