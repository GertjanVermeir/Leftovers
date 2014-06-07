(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    // Set up as CtrlCampusPicker
    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipeCreate',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location', 'Gj.Leftovers.Services.LeftoversSrvc', 'ingredients', '$anchorScroll',
        function($scope, $rootScope, $http, localStorageService, $location, LeftoversSrvc , ingredients, $anchorScroll)
        {
            $scope.ingredients = [];

                ingredients.forEach(function(ingredient) {
                    $scope.ingredients.push(ingredient.name);
            });

            $rootScope.Title = "Nieuw Recept";
            $scope.step = "1";

            var amount = 4;

            // Recipe Create
            // ------------------
            $scope.create = function(recipe){

                recipe.ingredient = [1];
                recipe.amount = [5];
                recipe.description = 'Jajaja';
                $scope.recipe = {};

                    $scope.formerror = "";

                    // check form validation
                    if($scope.createForm.$valid){

                        var recipeURL = $rootScope.linkAPI + "recipe?jsonp=JSON_CALLBACK";
                        recipe = JSON.stringify(recipe);

                        $http.post(recipeURL, recipe).success(function(result){
                            if(result === '"Je recept werd toegevoegd."' )
                            {
                                alert('yes');
                            }else{
                                $scope.formerror = "Oeps. Je recept kon niet toegevoegd worde.";
                            }
                        });
                    }
                    // form invalid
                    else{ $scope.formerror = "Foutieve ingave. Controleer alle velden."; }
            };

            function capitaliseFirstLetter(string)
            {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            var dropdown;

            $scope.next = function()
            {
                if(($scope.step == 1 && $scope.step1form.$valid) || ($scope.step == 2 && $scope.step2form.$valid))
                {
                    $scope.step++;
                    $scope.error ="";
                }
                else if($scope.step == 4){
                    $scope.error ="";
                    var checkSteps = true;
                    $('textarea').each(function(){
                        if(!$(this).val())
                        {
                            checkSteps = false;
                        }
                    });
                    if(checkSteps == false){
                        $scope.error = "Vul alle stappen in.";
                    }
                    else{
                        //FINAL FORM
                    }
                }
                else if($scope.step == 3){

                    $( ".delete" ).click(function() {
                        $(this).parent().remove();
                    });

                    $scope.error ="";
                    var checkAmounts = true;
                    var checkIngs = true;
                    var checkDB = true;

                    $('.allIng').each(function(){

                        if($(this).children('.amount').val() <= 0 || !$(this).children('.amount').val())
                        {
                            checkAmounts = false;
                        }
                        if(!$(this).children('.ings').val())
                        {
                            checkIngs = false;
                        }
                        else if($.inArray(capitaliseFirstLetter($(this).children('.ings').val()), $scope.ingredients) > -1){

                        }
                        else{
                            $scope.error = "'" + capitaliseFirstLetter($(this).children('.ings').val()) + "' zit nog niet in onze database.";
                            checkDB = false;
                            checkIngs = false;
                        }

                    });

                    if(checkAmounts == false && checkIngs == false){
                        $scope.error = "De hoeveelheden en ingrediënten zijn niet correct ingevuld.";
                    }
                    else if(checkIngs == false){
                        if(checkDB == false){
                            //error
                        }
                        else{
                            $scope.error = "Vul alle ingrediënten in.";
                        }
                    }
                    else if(checkAmounts == false){
                        $scope.error = "De hoeveelheden zijn niet correct.";
                    }
                    else{
                        $scope.step++;
                    }
                }
                else{
                    $scope.error = "Vul alle velden in."
                }

                $( ".ings" ).autocomplete({
                    select: function(event, ui) {
                        var unit =  _.find(ingredients, {"name":ui.item.value});
                        $(this).next().next().empty();
                        $(this).next().next().append(unit.unit);
                    },
                    source: $scope.ingredients
                });
            };

            $scope.back = function()
            {
                $scope.step--;
                $scope.error ="";
            };

            $scope.addIngredient = function()
            {
               amount++;

               var template = "<div class='allIng' ><input required placeholder='Ingrediënt' class='ings' ng-model='recipe.ingredients" + amount + "'>" +
                "<input required type='number' placeholder='0' ng-model='recipe.amounts"+ amount +"' class='amount'><p class='grey'></p><p class='delete' ng-click='deleteIng("+ amount +")'><i class='fa fa-trash-o'></i></p></div>";

                $('#ingredient-holder').append(template);

                $( ".ings" ).autocomplete({
                    select: function(event, ui) {
                        var unit =  _.find(ingredients, {"name":ui.item.value});
                        $(this).next().next().empty();
                        $(this).next().next().append(unit.unit);
                    },
                    source: $scope.ingredients
                });

                $( ".delete" ).click(function() {
                    $(this).parent().remove();
                });
            };

            $( ".delete" ).click(function() {
                $(this).parent().remove();
            });

            var stepAmount = "4";
            $scope.addStep = function()
            {
                stepAmount++;
                var template = '<textarea placeholder="Volgende stap" required ng-model="recipe.step'+stepAmount+'"> </textarea><p class="deleteStep"><i class="fa fa-trash-o"></i></p>';

                $('#form-steps').append(template);


                $( ".deleteStep" ).click(function() {
                    $(this).prev().remove();
                    $(this).remove();
                });
            };

            $( ".deleteStep" ).click(function() {
                $(this).prev().remove();
                $(this).remove();
            });

            $scope.onFileSelect = function($files) {
                //$files: an array of files selected, each file has name, size, and type.
                for (var i = 0; i < $files.length; i++) {
                    var file = $files[i];
                    $scope.upload = $upload.upload({
                        url: '../', //upload.php script, node.js route, or servlet url
                        // method: 'POST' or 'PUT',
                        // headers: {'header-key': 'header-value'},
                        // withCredentials: true,
                        data: {myObj: $scope.myModelObj},
                        file: file, // or list of files: $files for html5 only
                        /* set the file formData name ('Content-Desposition'). Default is 'file' */
                        //fileFormDataName: myFile, //or a list of names for multiple files (html5).
                        /* customize how data is added to formData. See #40#issuecomment-28612000 for sample code */
                        //formDataAppender: function(formData, key, val){}
                    }).progress(function(evt) {
                        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                    }).success(function(data, status, headers, config) {
                        // file is uploaded successfully
                        console.log(data);
                    });
                    //.error(...)
                    //.then(success, error, progress);
                    //.xhr(function(xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
                }
            };
        }])
})()