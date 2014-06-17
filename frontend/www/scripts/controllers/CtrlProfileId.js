(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlProfileId',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location','$routeParams',
            function($scope, $rootScope, $http, localStorageService, $location, $routeParams)
            {

                $rootScope.Title = "Profiel";
                $scope.number = 3;

                var id = $routeParams.userId;

                if($rootScope.loggedUser == id)
                {
                    $location.path('/profile');
                }

                var apiUrl = $rootScope.linkAPI + "user/"+ id +"?jsonp=JSON_CALLBACK";

                $http.jsonp(apiUrl).
                    success(function(data, status, headers, config){
                        $scope.profile = data;
                        $scope.profileInitialized = true;
                    })
                    .error(function(data, status, headers, config){
                        alert('Gebruiker kon niet gevonden worden.');
                    })
                    .then(function() {
                        $scope.checkFolow();
                    });

//              Likes
                var userFollowing = $rootScope.loggedUser.following;

                $scope.checkFolow = function (){
                    jQuery.each( userFollowing, function( index, userFollow ) {
                        if(userFollow.id == $scope.profile.id || userFollow.follow_id == $scope.profile.id)
                        {
                            $scope.following = true;
                        }
                    });
                };

                $scope.addFollowLocalstorage = function (follow){
                    $rootScope.loggedUser.following.push(follow.user);
                    var updatedUser = JSON.stringify($rootScope.loggedUser);
                    localStorageService.set('user', updatedUser);
                };

                $scope.removeFollowLocalstorage = function (follow){

                    var newFollowing =  $rootScope.loggedUser.following;

                    jQuery.each( userFollowing, function( index, userFollow ) {
                        if(userFollow.user.id == follow.follow_id )
                        {
                            newFollowing.splice(index, 1);
                        }
                    });

                    $rootScope.loggedUser.following = newFollowing;

                    var updatedUser = JSON.stringify($rootScope.loggedUser);
                    localStorageService.set('user', updatedUser);
                };

                $scope.followPost = function(followID,action) {
                    var follow = {};
                    follow.user_id = $rootScope.loggedUser.id;
                    follow.follow_id = followID;
                    follow.action = action;

                    var followObj = follow;

                    follow = JSON.stringify(follow);

                    var apiUrl = $rootScope.linkAPI +"follow";

                    $http.post(apiUrl, follow).success(function(result){
                        if(result != '"Unfollow"')
                        {
                            $scope.following = true;
                            $scope.addFollowLocalstorage(result);

                        }else if(result == '"Unfollow"'){
                            $scope.following = false;
                            $scope.removeFollowLocalstorage(followObj);
                        }
                        else{
                            alert('Er is een fout opgetreden');
                        }
                    });
                };

            }])
})()