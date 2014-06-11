(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipe',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location','$routeParams',
        function($scope, $rootScope, $http, localStorageService, $location,$routeParams)
        {

            $rootScope.Title = "Gerechten";
            $scope.liked = false;
            var id = $routeParams.recipeId;

            var apiUrl = $rootScope.linkAPI + "recipe/"+ id +"?jsonp=JSON_CALLBACK";

            $http.jsonp(apiUrl).
                success(function(data, status, headers, config){
                    $scope.recipe = data;
                    $scope.recipeInitialized = true;
                })
                .error(function(data, status, headers, config){
                    alert('Recept kon niet gevonden worden.');
                })
                .then(function() {
                    $scope.checkLike();
                });

            // Lay-out fixes
            $scope.init = function () {
                var cw = $('.rec-info div').width();
                var ch = $(document).height();
                var rh = $('.rec-nav').height();


                $('.rec-info div').css({'height':cw+'px'});
                $('.rec-info div img').css({'width':cw+'px'});

                var dh =  $('.rec-info div').height();
                $('.big-pic').css({'height':ch-dh-17-rh+'px'});
            };

            window.onresize = function(event) {
                $scope.init();
            };



            // Likes
            var userLikes = $rootScope.loggedUser.likes;

            $scope.checkLike = function (){
                jQuery.each( userLikes, function( index, userlike ) {
                    if(userlike.recipe_id == $scope.recipe.id )
                    {
                        $scope.liked = true;
                    }
                });
            };

            $scope.addLocalstorage = function (like){
                $rootScope.loggedUser.likes.push(like);
                var updatedUser = JSON.stringify($rootScope.loggedUser);
                localStorageService.set('user', updatedUser);
            };

            $scope.removeLocalstorage = function (like){

                var newLikes = userLikes;

                jQuery.each( userLikes, function( index, userlike ) {
                    if(userlike.recipe_id == like.recipe_id )
                    {
                        newLikes.splice(index, 1);
                    }
                });

                $rootScope.loggedUser.likes = newLikes;
                var updatedUser = JSON.stringify($rootScope.loggedUser);
                localStorageService.set('user', updatedUser);
            };

            $scope.likePost = function(recipeID,action) {
                var like = {};
                like.user_id = $rootScope.loggedUser.id;
                like.recipe_id = recipeID;
                like.action = action;

                var likeObj = like;

                like = JSON.stringify(like);
                var apiUrl = $rootScope.linkAPI +"like";

                $http.post(apiUrl, like).success(function(result){
                    if(result == '"Liked"')
                    {
                        $scope.liked = true;
                        $scope.addLocalstorage(likeObj);

                    }else if(result == '"Unliked"'){
                        $scope.liked = false;
                        $scope.removeLocalstorage(likeObj);
                    }
                    else{
                        alert('Er is een fout opgetreden');
                    }
                });
            };
        }])
})()