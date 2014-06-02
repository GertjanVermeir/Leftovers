(function(){
    'use strict';
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.NavCtrl',['$scope', '$location', '$rootScope', '$route',
        function($scope, $location, $rootScope, $route){

            $rootScope.confirmSearchRequest = function(ev){
                $rootScope.returnToSearch = false;
                $rootScope.previousSearch = $rootScope.GlobalSearchTerm;
                $rootScope.GlobalSearchTerm = $scope.searchTerm;
                if ($route.current.originalPath == "/quick-search" && $rootScope.previousSearch != $rootScope.GlobalSearchTerm){
                    $route.reload();
                }
            }

            $scope.enterAndSearch = function(){
                $rootScope.returnToSearch = false;
                if ($("#quickSearch").val().length >= 3){
                    // Unfocus input field
                    $("#quickSearch").blur();
                    // Update global search term
                    // Previous search
                    $rootScope.previousSearch = $rootScope.GlobalSearchTerm;
                    $rootScope.GlobalSearchTerm = $scope.searchTerm;
                    // Update path
                    $location.path("/quick-search");
                    // Toggle class
                    $("#tab-bar").closest('.off-canvas-wrap').toggleClass('move-right');
                    // If current route is the same as the last, reload the route
                    console.log($route.current.originalPath);
                    if ($route.current.originalPath == "/quick-search" && $rootScope.previousSearch != $rootScope.GlobalSearchTerm){
                        $route.reload();
                    }
                }
            }

            // active route things
            $rootScope.isRouteActive = function(route) {
                if(route === '/')
                    return route === $location.path();
                else
                    return $location.path().indexOf(route) !== -1;
            };
        }
    ]);
})();