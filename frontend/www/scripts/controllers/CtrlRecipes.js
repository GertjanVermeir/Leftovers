(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipes',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location',
        function($scope, $rootScope, $http, localStorageService, $location)
        {

            $rootScope.Title = "Recepten";

            $rootScope.favorites = [];

            if($rootScope.watchLikes ){
                $scope.recipes = $rootScope.favorites;
            }
            else{
                $scope.recipes = $rootScope.loggedUser.recipes;
            }


            $.each( $rootScope.loggedUser.likes, function( key, value ) {
                $scope.favorites.push(value.recipe);
            });

             $scope.recipeCount = function(course) {
                var result = 0;

                 var type = $scope.recipes;

                 if($rootScope.watchLikes){
                    type = $rootScope.favorites;
                 }
                 else{
                    type = $scope.recipes;
                 }

                 $.each(type, function(index, value){
                     var recipeCourse = value.course;
                     if(recipeCourse == course){
                        result++;
                     }
                 });
                return result;
             };

            $scope.clearInput = function(){
                    $('#quickSearchRecipes').val("");
                    $scope.searchRecipe.name = '';
            };

            $scope.selectedCourse = "";

            $scope.showRecipes = function(course){
                if($scope.selectedCourse == course)
                {
                    $scope.selectedCourse = "";
                }
                else{
                    $scope.selectedCourse = course;
                }

            };

            $scope.switchFav = function(){
                $rootScope.watchLikes = !$rootScope.watchLikes;

                if($rootScope.watchLikes ){
                    $scope.recipes = $rootScope.favorites;
                }
                else{
                    $scope.recipes = $rootScope.loggedUser.recipes;
                }
            };

        }])
})()