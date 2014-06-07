/*
 AppCtrl
 =======
 Controller for the App
 ----------------------
 * Load Data Via the services
 * Return the promises
 * Resolve for each route
 */
var appCtrl = app.controller('AppCtrl', ['$scope', '$location', 'appInitialized', function($scope, $location, appInitialized){
    if(appInitialized){
        $location.path('/');
    }
}]);

// Load all data
// ------------------
appCtrl.loadData = ['$rootScope', '$q', '$timeout', 'Gj.Leftovers.Services.LeftoversSrvc', function($rootScope, $q, $timeout, LeftoversSrvc){


    var deferred = $q.defer();

    LeftoversSrvc.loadData().then(
        function(data){
            $timeout(function(){
                $rootScope.appInitialized = true;
                deferred.resolve(data);
            },100);
        },
        function(error){
            deferred.reject(error);
        }
    );

    return deferred.promise;
}];

// Load all ingredients
// ------------------
appCtrl.getDataIngredients = ['$q', 'Gj.Leftovers.Services.LeftoversSrvc', function($q, LeftoversSrvc){
    var deferred = $q.defer();

    LeftoversSrvc.getDataIngredients().then(
        function(data){
            deferred.resolve(data);
        },
        function(error){
            deferred.reject(error);
        }
    );

    return deferred.promise;
}];



