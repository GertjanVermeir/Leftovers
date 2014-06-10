(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    // Set up as CtrlCampusPicker
    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipes',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location',
        function($scope, $rootScope, $http, localStorageService, $location)
        {

            $rootScope.Title = "Recepten";

            var apiUrl = $rootScope.linkAPI + "recipe?jsonp=JSON_CALLBACK";

            $http.jsonp(apiUrl).
                success(function(data, status, headers, config){
                    $scope.recipes = data;
                    $scope.recipesInitialized = true;

                }).
                error(function(data, status, headers, config){
                    alert('Recepten kunnen niet gevonden worden.');
                });


             $scope.recipeCount = function(course) {
                var result = 0;
                 $.each($scope.recipes, function(index, value){
                     var recipeCourse = value.course;
                     if(recipeCourse == course){
                        result++;
                     }
                 });
                return result;
            }

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