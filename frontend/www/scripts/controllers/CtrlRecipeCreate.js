(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.CtrlRecipeCreate',
        ['$scope', '$rootScope', '$http', 'localStorageService', '$location', 'Gj.Leftovers.Services.LeftoversSrvc', 'ingredients','$upload','$q',
        function($scope, $rootScope, $http, localStorageService, $location, LeftoversSrvc , ingredients, $upload,$q)
        {
            $scope.ingredients = [];

                ingredients.forEach(function(ingredient) {
                    $scope.ingredients.push(ingredient.name);
            });

            $rootScope.Title = "Nieuw Recept";
            $scope.step = "1";

            // File Upload
            // ------------------
            $scope.onFileSelect = function($files,recipe) {
                $scope.fileName = $files[0].name;
                $scope.files = $files;
            };

            $scope.uploadImage = function($files,recipe){

                for (var i = 0; i < $files.length; i++) {
                    var file = $files[i];
                    var image = '';
                    $scope.upload = $upload.upload({
                        url: $rootScope.linkAPI + 'image', //upload.php script, node.js route, or servlet url
                        data: {},
                        file: file
                    }).progress(function(evt) {
                        //console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                    }).success(function(data, status, headers, config) {
                        // file is uploaded successfully
                        image = data.substring(1, data.length-1);
                    }).then(function() {
                        $scope.create(recipe,image);
                    });
                    //.error(...)
                    //.then(success, error, progress);
                    //.xhr(function(xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
                }
            };

            // Create Recipe
            $scope.create = function(recipe,image){
                $scope.error ="";

                recipe.mainimage = image;
                recipe.amount = [];
                recipe.description = "";
                recipe.ingredient = [];
                recipe.user_id = $rootScope.loggedUser.id;

                $('.amount').each(function(){
                    recipe.amount.push($(this).val());
                });

                $('textarea').each(function(){
                    recipe.description += '<p>'+ $(this).val() +'</p>';
                });

                $('.ings').each(function(){
                    recipe.ingredient.push($(this).val());
                });

                var recipeURL = $rootScope.linkAPI + "recipe";
                recipe = JSON.stringify(recipe);

                $http.post(recipeURL, recipe).success(function(result){
                    if(result != '"Foutieve ingave."' )
                    {
                        $location.path('/recipe/' + result.id);
                    }else{
                        $scope.error = "Oeps. Je recept kon niet toegevoegd worde.";
                    }

                });
            };

            // Last validation
            // ------------------
            $scope.validate = function(recipe){
                $scope.error ="";
                var count = 0;
                var checkSteps = true;
                $('textarea').each(function(){
                    count++;
                    if(!$(this).val())
                    {
                        checkSteps = false;
                    }
                });
                if(count < 3){
                    $scope.error = "Vul minstens 3 stappen in.";
                    return;
                }
                else if(checkSteps == false){
                    $scope.error = "Vul alle stappen in.";
                    return;
                }

                $scope.uploadImage($scope.files,recipe);


            };

            function capitaliseFirstLetter(string)
            {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            $scope.fileSelected = false;

            $scope.next = function()
            {
                if(($scope.step == 1 && $scope.step1form.$valid) || ($scope.step == 2 && $scope.step2form.$valid))
                {
                    if($scope.fileName)
                    {
                        $scope.step++;
                        $scope.error ="";
                    }
                    else{
                        $scope.error = "Gelieve een afbeelding te kiezen";
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
                    var count = 0;

                    $('.allIng').each(function(){
                        count++;

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
                    if(count < 3){
                        $scope.error = "Vul minstens 3 ingrediënten in.";
                    }
                    else if(checkAmounts == false && checkIngs == false){
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
               var template = "<div class='allIng' ><input required placeholder='Ingrediënt' class='ings' >" +
                "<input required type='number' placeholder='0' class='amount'><p class='grey'></p><p class='delete'><i class='fa fa-trash-o'></i></p></div>";

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

            $scope.addStep = function()
            {
                var template = '<textarea placeholder="Volgende stap" required> </textarea><p class="deleteStep"><i class="fa fa-trash-o"></i></p>';

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
        }])
})()