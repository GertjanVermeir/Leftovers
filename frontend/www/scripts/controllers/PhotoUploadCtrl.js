(function(){

    'use strict';

    // Add to global controllers
    var controllers = angular.module('Gj.Leftovers.Controllers');

    controllers.controller('Gj.Leftovers.Controllers.PhotoUploadCtrl',['$scope', '$rootScope', '$routeParams', '$upload', '$location', function($scope, $rootScope, $routeParams, $upload, $location){

        $scope.uploadStatus = false; // Bool to check if uploading right now
        $scope.uploadDeclined = false;
        $scope.uploadFailed = false;
        $scope.uploadSuccess = false;
        $scope.message = "";

        $scope.onFileSelect = function($files) {

                $scope.uploadStatus = true;
                $scope.uploadDeclined = false;
                $scope.uploadFailed = false;

                for (var i = 0; i < $files.length; i++) {
                    var file = $files[i];
                    $scope.upload = $upload.upload({
                        url: $rootScope.apipath + 'upload/image', //upload.php script, node.js route, or servlet url
                        data: {},
                        file: file
                    }).success(function(data, status, headers, config) {
                        $scope.uploadStatus = false; // Bool to check if uploading right now
                        $scope.uploadDeclined = false;
                        $scope.uploadFailed = false;
                        $scope.uploadSuccess = true;
                        var id = data.photo_id;
                        $location.path("photo");
                    })
                    //.then(success, error, progress);
                }
        }

    }]);
})();