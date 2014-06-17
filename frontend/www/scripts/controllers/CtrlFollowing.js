(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlFollowing',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$timeout', '$location',
        function($scope, $rootScope, $http, localStorageService, $timeout, $location)
        {

            $rootScope.Title = "Volgend";

            $scope.following = $rootScope.loggedUser.following;
            $scope.emailerror = false;
            $scope.loading = false;

            $scope.clearInput = function(){
                $('#quickSearchProfiles').val("");
                $scope.searchProfile.name = '';
            };

            $scope.searchUser = function(email){
                if($scope.searchForm.$valid){
                    $scope.emailerror = false;
                    $scope.loading = true;

                    var mail = {};
                    mail.email = email;

                    var apiUrl = $rootScope.linkAPI + "user/email" +"?jsonp=JSON_CALLBACK";

                    mail = JSON.stringify(mail);

                    $http.post(apiUrl, mail).success(function(result){
                        if(result != '"Not Found"' )
                        {
                            $location.path('/profile/' + result.id);
                        }else{
                            $scope.checkerror = "Oeps. Geen gebruiker met dit e-mailadres gevonden.";
                        }
                        $scope.loading = false;

                    });
                }else{
                    $scope.emailerror = true;
                }
            };
        }])
})()