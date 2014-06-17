(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlHome',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$timeout', '$location','ingredients',
        function($scope, $rootScope, $http, localStorageService, $timeout, $location,ingredients)
        {
            $rootScope.Title = "Leftovers";

            $scope.ingredients = [];
            $scope.leftovers = [];
            $scope.recipes = [];
            $scope.foundRecipes = false;
            $scope.loading = false;

            ingredients.forEach(function(ingredient) {
                $scope.ingredients.push(ingredient.name);
            });

            $scope.autoComplete = function(){
                $( ".leftovers" ).autocomplete({
                    select: function(event, ui) {
                        var selectedObj = ui.item;
                        $scope.leftovers.push(selectedObj.value);

                        $scope.ingredients = jQuery.grep($scope.ingredients, function(value) {
                            return value != selectedObj.value;
                        });

                        $(this).prop('disabled', true);

                        if($('input.leftovers').last().val().length > 0){
                            $scope.addInput();
                        }

                        $scope.getLeftovers();
                    },
                    source: $scope.ingredients
                });
            };

            $scope.addInput = function(){
                $('input.leftovers').last().before('<p></p>');
                $('input.leftovers').last().after( '<p class="delete"><i class="fa fa-trash-o"></i></p><input type="text" class="leftovers" placeholder="Gebruik je overschotten">' );

                $scope.autoComplete();

                $( ".delete" ).click(function() {
                    var val = $(this).prev().val();

                    $scope.leftovers = jQuery.grep($scope.leftovers, function(value) {
                        return value != val;
                    });

                    if(val)
                    {
                        $scope.ingredients.push(val);
                    }

                    $(this).prev().remove();
                    $(this).prev().remove();
                    $(this).remove();

                    $scope.getLeftovers();
                });
            };

            $scope.getLeftovers = function()
            {
                $scope.loading = true;
                var leftoversUrl =  $rootScope.linkAPI + "leftovers";
                var leftovers;
                $scope.foundRecipes = false;

                leftovers = JSON.stringify($scope.leftovers);

                $http.post(leftoversUrl, leftovers).success(function(result){
                    if(result)
                    {
                        $scope.founds = result;
                    }
                    else{
                        $scope.formerror = "Er is een fout opgetreden. Probeer later nog eens.";
                        $scope.foundRecipes = false;
                        $scope.loading = false;
                        $scope.formerror = false;
                    }
                }).then(function() {
                    if($scope.leftovers.length == 0)
                    {
                        $scope.foundRecipes = false;
                        $scope.loading = false;
                        $scope.founds = false;
                        $scope.formerror = false;
                    }else if($scope.founds.length > 0){
                        $scope.foundRecipes = true;
                        $scope.loading = false;
                        $scope.formerror = false;
                    }

                    else{
                        $scope.loading = false;
                        $scope.founds = false;
                        $scope.formerror = "Geen recepten voor je overschotten gevonden."
                    }
                });
            };

        }])
})()