(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipe',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location','$routeParams',
        function($scope, $rootScope, $http, localStorageService, $location,$routeParams)
        {

            $rootScope.Title = "Gerechten";
            var id = $routeParams.recipeId;

            var apiUrl = $rootScope.linkAPI + "recipe/"+ id +"?jsonp=JSON_CALLBACK";

            $http.jsonp(apiUrl).
                success(function(data, status, headers, config){
                    $scope.recipe = data;
                    $scope.recipeInitialized = true;
                })
                .error(function(data, status, headers, config){
                    alert('Recept kon niet gevonden worden.');
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


        }])
})()