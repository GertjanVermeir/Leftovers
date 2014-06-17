(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlProfileEdit',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$timeout', '$location','$upload',
        function($scope, $rootScope, $http, localStorageService, $timeout, $location, $upload)
        {
            $rootScope.Title = "Profiel bewerken";
            $scope.user = $rootScope.loggedUser;
            $scope.loading = false;

            $scope.validate = function(user){

                $scope.formerror = "";

                // check form validation
                if($scope.editForm.$valid){
                    $scope.loading = true;

                    if($scope.fileName){
                    // check unique email
                     $scope.uploadImage($scope.files,$scope.user);
                    }

                    else{
                        $scope.edit($scope.user,'no');
                    }

                }
                // form invalid
                else{
                    $scope.loading = true;
                    $scope.formerror = "Het formulier bevat fouten."; }
            };

            $scope.edit = function(user,image){

                if(image != 'no')
                {
                    user.picture = image;
                }else{
                    user.picture == $rootScope.loggedUser.picture;
                }

                var userUrl =  $rootScope.linkAPI + "edit/user";
                user = JSON.stringify(user);

                // sent post with registration
                $http.post(userUrl, user).success(function(result){
                    if(result != '"niet gelukt!"' )
                    {
                        localStorageService.set('user', result);
                        $rootScope.loggedUser = result;
                        $scope.loading = false;
                        $location.path('/profile');
                    }else{
                        // registration failed
                        $scope.loading = false;
                        $scope.formerror = "Er is een fout opgetreden. Probeer later nog eens.";
                    }
                });
            };

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
                        $scope.edit(user,image);
                    });

                }
            };


        }])
})()