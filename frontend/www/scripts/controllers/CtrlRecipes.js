(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipes',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location',
        function($scope, $rootScope, $http, localStorageService, $location)
        {

            $rootScope.Title = "Recepten";

            $scope.recipes = $rootScope.loggedUser.recipes;


             $scope.recipeCount = function(course) {
                var result = 0;
                 $.each($scope.recipes, function(index, value){
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

            }
        }])
})()