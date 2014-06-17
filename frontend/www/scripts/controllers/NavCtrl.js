(function(){
    'use strict';
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.NavCtrl',['$scope', '$location', '$rootScope', '$route', '$http',
        function($scope, $location, $rootScope, $route, $http){

            $rootScope.searchrecipes = function(searchTerm,close){

                $scope.loaderNav = true;

                var apiUrl =  $rootScope.linkAPI + "recipesbyname/" + searchTerm + "?jsonp=JSON_CALLBACK";

                $http.jsonp(apiUrl).
                    success(function(data, status, headers, config){
                        if(data.length >= 1)
                        {
                            $rootScope.navSearches = data;
                            if(close == true)
                            {
                                $('#quickSearch').val("");
                                $("#tab-bar").closest('.off-canvas-wrap').toggleClass('move-right');
                            }
                            $rootScope.latestSearch = searchTerm;
                            $scope.loaderNav = false;
                            $location.path('/searches');
                        }
                        else{
                            $scope.loaderNav = false;
                            alert('Geen recepten gevonden');
                        }

                    })
                    .error(function(data, status, headers, config){
                        $scope.loaderNav = false;
                        alert('Geen recepten gevonden');
                    });
            };

            // active route things
            $rootScope.isRouteActive = function(route) {
                if(route === '/')
                    return route === $location.path();
                else
                    return $location.path().indexOf(route) !== -1;
            };

            $( ".main-nav li" ).click(function() {
                $('#quickSearch').val("");
            });
        }
    ]);
})();