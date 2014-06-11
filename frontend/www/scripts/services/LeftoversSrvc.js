(function(){
    'use strict';

    var services = angular.module('Gj.Leftovers.Services');

    services.factory('Gj.Leftovers.Services.LeftoversSrvc',
    ['$rootScope', '$http', '$q', 'localStorageService', function($rootScope, $http, $q, localStorageService){

        var URLINGREDIENT = $rootScope.linkAPI + "ingredient?jsonp=JSON_CALLBACK";
        var MSGINGREDIENTERROR = "Could not load the ingredient data from the requested URI.";
        var MSGRESOURCESERROR = "Could not load the ingredient data from the local storage.";


        var _ingredients = null,
            _numberOfResourcesToLoadViaAJAX = 1,
            _numberOfResourcesLoadedViaAJAX = 0;

        var that = this;//Hack for calling private functions and variables in the return statement

        // INGREDIENTS
        this.loadIngredients = function(){
            var deferred = $q.defer();

            if(_ingredients === null){
                if(localStorageService.get('ingredients') === null){
                    $http.jsonp(URLINGREDIENT).
                        success(function(data, status, headers, config){
                            _ingredients = data;
                            localStorageService.set('ingredients', _ingredients);
                            deferred.resolve(_ingredients);
                        }).
                        error(function(data, status, headers, config){
                            deferred.reject(MSGINGREDIENTERROR);
                        });
                }else{
                    _ingredients = localStorageService.get('ingredients');
                    deferred.resolve(_ingredients);
                }
            }else{
                deferred.resolve(_ingredients);
            }

            return deferred.promise;//Always return a promise
        };

        return{
            loadData:function(){
                var deferred = $q.defer();

                that.loadIngredients().then(
                    function(data){
                        _numberOfResourcesLoadedViaAJAX++;
                        if(_numberOfResourcesLoadedViaAJAX === _numberOfResourcesToLoadViaAJAX){
                            deferred.resolve(true);
                        }
                    },
                    function(error){
                        deferred.reject(MSGRESOURCESERROR);
                    }
                );

                return deferred.promise;
            },

            getDataIngredients:function(){
                var deferred = $q.defer();

                if(_ingredients === null){
                    deferred.reject(MSGINGREDIENTERROR);
                }else{
                    deferred.resolve(_ingredients);
                }

                return deferred.promise;
            }
        }
    }]);
})();
