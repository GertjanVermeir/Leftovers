(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    // Set up as CtrlCampusPicker
    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipeCreate',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location',
        function($scope, $rootScope, $http, localStorageService, $location)
        {

            $rootScope.Title = "Nieuw Recept";


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
                var cw = $('.rec-info div').width();
                var ch = $(document).height();
                var rh = $('.rec-nav').height();

                $('.rec-info div').css({'height':cw+'px'});
                $('.rec-info div img').css({'width':cw+'px'});


                var dh =  $('.rec-info div').height();
                $('.big-pic').css({'height':ch-dh-17-rh+'px'});
            };

            $scope.init();

        }])
})()