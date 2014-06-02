'use strict';

angular.module('LocalStorageModule').value('prefix', 'GjLeftovers');
angular.module('Gj.Leftovers.Controllers', []);
angular.module('Gj.Leftovers.Directives', []);
angular.module('Gj.Leftovers.Services', []);

var app = angular
/*************************************************************************
    SET UP MODULES & CONFIGURE THEM
**************************************************************************/
.module(
    'Gj.Leftovers',
    [
    'ngRoute',
    'ngAnimate',
    'ui.directives',
    'Gj.Leftovers.Controllers',
    'Gj.Leftovers.Directives',
    'Gj.Leftovers.Services',
    'LocalStorageModule'
    ]
    )
    //
    // Configure the modules in question
    //
    .config(
        ['$routeProvider','$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider){
            // CROSS DOMAIN CALLS OK
            $httpProvider.defaults.useXDomain = true;
            // DELETE REQUESTED WITH
            delete $httpProvider.defaults.headers.common['X-Requested-With'];
            /**************
             ROUTES SETUP
             **************/
            $routeProvider.when(
                '/', {
                    templateUrl:'views/Home.html',
                    controller:'Gj.Leftovers.Controllers.CtrlHome'
                });

            $routeProvider.when(
                '/recipes', {
                    templateUrl:'views/Recipes.html',
                    controller:'Gj.Leftovers.Controllers.CtrlRecipes'
                });
            $routeProvider.when(
                '/recipe', {
                    templateUrl:'views/Recipe.html',
                    controller:'Gj.Leftovers.Controllers.CtrlRecipe'
                });

            $routeProvider.when(
                '/recipe/create', {
                    templateUrl:'views/RecipeCreate.html',
                    controller:'Gj.Leftovers.Controllers.CtrlRecipeCreate'
                });

            $routeProvider.when(
                '/profile', {
                    templateUrl:'views/Profile.html',
                    controller:'Gj.Leftovers.Controllers.CtrlProfile'
                });

            $routeProvider.when(
                '/quick-search', {
                    templateUrl:'views/QuickSearch.html',
                    controller:'Gj.Leftovers.Controllers.CtrlQuickSearch'
                });
        }]
    )
/*************************************************************************
    RUN THE APPLICATION
 **************************************************************************/
.run(['$rootScope', '$timeout', '$location', 'localStorageService', '$route',
    function($rootScope, $timeout, $location, localStorageService, $route){

        /** App post-initialization routine */

        // Set header title (in fixed menu bar) to 'MediatheekApp'.
        $rootScope.Title = "Leftovers";
        $rootScope.GlobalSearchTerm = null;
        $rootScope.returnToSearch = false;

        // Link to API
        $rootScope.linkAPI = "http://localhost/leftovers/backoffice/public/api/";

        // Set rootScope 'Page Initialized' property to true after page has loaded
        $rootScope.pageInitialized = true;

        /** Hammertime JS gestures */
        // Gesture for tab-bar (fixed bar at the top)
        var fixedTabBar = Hammer(document.getElementById("tab-bar"), {prevent_default:true});

        // When fixed tab bar is swiped right, toggle menu
        fixedTabBar.on("swiperight", function(ev) {
            ev.stopPropagation();
            $("#tab-bar").closest('.off-canvas-wrap').toggleClass('move-right');
        });

    }
]);

