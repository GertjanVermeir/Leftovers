(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipe',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location','$routeParams',
        function($scope, $rootScope, $http, localStorageService, $location,$routeParams)
        {

            $rootScope.Title = "Recept";
            $scope.liked = false;
            $scope.number = 0;
            $scope.rating = 0;
            $scope.ratingInitialized = false;

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
                    if($scope.recipe.user_id != $rootScope.loggedUser.id)
                    {
                        $scope.getRating();
                    }
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

            // Comments
            $scope.commentsGet = function(){

                $scope.ratingInitialized = false;
                if($scope.commentsInitialized)
                {
                    $scope.commentsInitialized = false;
                }
                else{
                    var apiUrl = $rootScope.linkAPI + "comment/"+ $scope.recipe.id +"?jsonp=JSON_CALLBACK";

                    $http.jsonp(apiUrl).
                        success(function(data, status, headers, config){
                            $scope.comments = data.reverse();
                            $scope.commentsInitialized = true;
                        })
                        .error(function(data, status, headers, config){
                            alert('Commentaren kon niet gevonden worden.');
                        })
                }
            };

            $scope.commentPost = function(description) {
                var comment = {};
                comment.user_id = $rootScope.loggedUser.id;
                comment.recipe_id = $scope.recipe.id;
                comment.description = description.description;
                comment.action = "add";

                comment = JSON.stringify(comment);
                var apiUrl = $rootScope.linkAPI +"comment";

                $http.post(apiUrl, comment).success(function(result){
                    if(result != '"Deleted"')
                    {
                        $scope.comments.unshift(result);
                        $scope.number = 0;

                    }else if(result == '"Deleted"'){
                        alert('Deleted');
                    }
                    else{
                        console.log(result);
                        alert('Er is een fout opgetreden');
                    }
                });
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

            $scope.addLikeLocalstorage = function (like){
                $rootScope.loggedUser.likes.push(like);
                var updatedUser = JSON.stringify($rootScope.loggedUser);
                localStorageService.set('user', updatedUser);
            };

            $scope.removeLikeLocalstorage = function (like){

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
                    if(result == '"Unliked"'){
                        $scope.liked = false;
                        $scope.removeLikeLocalstorage(likeObj);
                    }
                    else if(result)
                    {
                        $scope.liked = true;
                        $scope.addLikeLocalstorage(result);

                    }
                    else{
                        alert('Er is een fout opgetreden');
                    }
                });
            };

            $scope.edit = function(id){
                $rootScope.editRecipe = $scope.recipe;
                $location.path('/recipe/edit');
            };

            $scope.getRating = function(){

                var rating = {};

                rating.user_id = $rootScope.loggedUser.id;
                rating.recipe_id = $scope.recipe.id;
                rating.rating = "get";

                rating = JSON.stringify(rating);
                var apiUrl = $rootScope.linkAPI +"rating";

                $http.post(apiUrl, rating).success(function(result){
                    if(jQuery.isEmptyObject(result)){
                        $scope.rating = 0;
                    }
                    else
                    {
                        $scope.rating = result.rating;
                    }
                });
            };

            $scope.showRating = function(){
                $scope.ratingInitialized = !$scope.ratingInitialized;
                $scope.commentsInitialized = false;
            };

            $scope.setRating = function(int){
                $scope.rating = int;

                var rating = {};

                rating.user_id = $rootScope.loggedUser.id;
                rating.recipe_id = $scope.recipe.id;
                rating.rating = int;

                rating = JSON.stringify(rating);
                var apiUrl = $rootScope.linkAPI +"rating";

                $http.post(apiUrl, rating).success(function(result){
                    if(result == "Deleted"){
                        // do nothing
                    }
                    else if(!result)
                    {
                        alert('Er is een fout opgetreden');
                    }
                });
            };

        }])
})()