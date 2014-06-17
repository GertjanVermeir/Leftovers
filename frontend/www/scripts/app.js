'use strict';

angular.module('LocalStorageModule').value('prefix', 'leftovers_');
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
    'angularFileUpload',
    'autocomplete',
    'Gj.Leftovers.Controllers',
    'Gj.Leftovers.Directives',
    'Gj.Leftovers.Services',
    'LocalStorageModule',
    'ngResource'
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
                '/home', {
                    templateUrl:'views/Home.html',
                    controller:'Gj.Leftovers.Controllers.CtrlHome',
                    resolve: {
                        ingredients: appCtrl.getDataIngredients
                    }
                });

            $routeProvider.when(
                '/login', {
                    templateUrl:'views/Login.html',
                    controller:'Gj.Leftovers.Controllers.CtrlLogin'

                });

            $routeProvider.when(
                '/logout', {
                    templateUrl:'views/Logout.html',
                    controller:'Gj.Leftovers.Controllers.CtrlLogout',
                });

            $routeProvider.when(
                '/register', {
                    templateUrl:'views/Register.html',
                    controller:'Gj.Leftovers.Controllers.CtrlRegister',
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
                    controller:'Gj.Leftovers.Controllers.CtrlRecipeCreate',
                    resolve: {
                        ingredients: appCtrl.getDataIngredients
                    }
                });

            $routeProvider.when(
                '/recipe/edit', {
                    templateUrl:'views/RecipeEdit.html',
                    controller:'Gj.Leftovers.Controllers.CtrlRecipeEdit',
                    resolve: {
                        ingredients: appCtrl.getDataIngredients
                    }
                });

            $routeProvider.when(
                '/recipe/:recipeId', {
                templateUrl:'views/Recipe.html',
                controller:'Gj.Leftovers.Controllers.CtrlRecipe'
            });

            $routeProvider.when(
                '/profile/:userId', {
                    templateUrl:'views/Profile.html',
                    controller:'Gj.Leftovers.Controllers.CtrlProfileId'
                });


            $routeProvider.when(
                '/profile', {
                    templateUrl:'views/Profile.html',
                    controller:'Gj.Leftovers.Controllers.CtrlProfile'
                });

            $routeProvider.when(
                '/user/edit', {
                    templateUrl:'views/ProfileEdit.html',
                    controller:'Gj.Leftovers.Controllers.CtrlProfileEdit'
                });

            $routeProvider.when(
                '/books', {
                    templateUrl:'views/Books.html',
                    controller:'Gj.Leftovers.Controllers.CtrlBooks'
                });

            $routeProvider.when(
                '/following', {
                    templateUrl:'views/Following.html',
                    controller:'Gj.Leftovers.Controllers.CtrlFollowing'
                });


            $routeProvider.when(
                '/searches', {
                    templateUrl:'views/Searches.html',
                    controller:'Gj.Leftovers.Controllers.CtrlSearches'
                });
            $routeProvider.when('/app', {
                templateUrl:'views/home.html',
                controller:'AppCtrl',
                resolve: {
                    appInitialized: appCtrl.loadData
                }
            });
            $routeProvider.otherwise({redirectTo: '/home'});
        }]
    )
/*************************************************************************
    RUN THE APPLICATION
 **************************************************************************/
.run(['$rootScope', '$timeout', '$location', 'localStorageService', '$route', '$anchorScroll',
    function($rootScope, $timeout, $location, localStorageService, $route){

        $rootScope.Title = "Leftovers";
        $rootScope.GlobalSearchTerm = null;
        $rootScope.returnToSearch = false;

//        $rootScope.IP = "http://80.240.133.26/gertjanvermeir/backoffice/";

//        $rootScope.IP = "http://127.0.0.1/leftovers/backoffice/";
//        $rootScope.IP = "http://78.22.162.6/leftovers/backoffice/";


//        $rootScope.IP = "http://leftovers.gertjanvermeir.be/";
        $rootScope.IP = "http://localhost/leftovers/backoffice/public/";
        $rootScope.linkIMAGE = $rootScope.IP + "images/";

        // Link to API
//        $rootScope.linkAPI = $rootScope.IP + "public/api/";
        $rootScope.linkAPI = $rootScope.IP + "api/";
        $rootScope.backoffice = $rootScope.IP;
//


        // Set rootScope 'Page Initialized' property to true after page has loaded
        $rootScope.pageInitialized = true;

        $rootScope.$on('$routeChangeStart', function(event, next, current){
            if(!$rootScope.appInitialized){
                $location.path('/app');
            }else if($rootScope.appInitialized && $location.path() === '/app'){
                $location.path('/login');
            }
        });

        $("#tab-bar").swipe( {
            //Generic swipe handler for all directions
            swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
                if(direction == 'right')
                {
                    $("#tab-bar").closest('.off-canvas-wrap').toggleClass('move-right');
                }
                //$(this).text("You swiped " + direction );
            },
            //Default is 75px, set to 0 for demo so any distance triggers swipe
            threshold:0
        });

        // Recipes variables
        $rootScope.watchLikes = false;


        // Global arrays
        $rootScope.levels= [
            'Beginner',
            'Student',
            'Gevorderde',
            'Chefkok'
        ];

        $rootScope.courses= [
            'Koud voorgerecht',
            'Warm voorgerecht',
            'Hoofdschotel',
            'Tussenschotel',
            'Ijsdrank',
            'Nagerecht',
            'Gebak',
            'Dessert',
            'Soepen',
            'Salades'
        ];

        $rootScope.types= [
            'Chinees',
            'Grieks',
            'Afrikaans',
            'Fast-Food',
            'Vegetarisch',
            'Stoofpot'
        ];

        $rootScope.times= [
            '5',
            '15',
            '30',
            '60',
            '60+'
        ];

    }
]);


