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
            var conf = confirm("Are you sure you want to upload this image?");
            if(conf === true){
                $scope.uploadStatus = true;
                $scope.uploadDeclined = false;
                $scope.uploadFailed = false;
                $(".progress").addClass("active");
                $("#progress").removeClass("progress-bar-danger");
                //$files: an array of files selected, each file has name, size, and type.
                for (var i = 0; i < $files.length; i++) {
                    var file = $files[i];
                    $scope.upload = $upload.upload({
                        url: $rootScope.apipath + 'upload/image', //upload.php script, node.js route, or servlet url
                        // method: POST or PUT,
                        // headers: {'headerKey': 'headerValue'}, withCredential: true,
                        data: {},
                        file: file
                        // file: $files, //upload multiple files, this feature only works in HTML5 FromData browsers
                        /* set file formData name for 'Content-Desposition' header. Default: 'file' */
                        //fileFormDataName: myFile,
                        /* customize how data is added to formData. See #40#issuecomment-28612000 for example */
                        //formDataAppender: function(formData, key, val){}
                    }).progress(function(evt) {
                        $("#progress").attr("aria-valuenow", (parseInt(100.0 * evt.loaded / evt.total)));
                        $("#progress").css("width", parseInt(100.0 * evt.loaded / evt.total) + "%");
                    }).success(function(data, status, headers, config) {
                        $scope.uploadStatus = false; // Bool to check if uploading right now
                        $scope.uploadDeclined = false;
                        $scope.uploadFailed = false;
                        $scope.uploadSuccess = true;
                        var id = data.photo_id;
                        $location.path("photo");
                    })
                        .error(function(object, code){
                            $scope.uploadFailed = true;
                            $("#progress").addClass("progress-bar-danger");
                            $(".progress").removeClass("active");
                            $("#progress").css("width", "100%");
                            switch(code){
                                case 500:
                                    $scope.message = "Upload failed. Internal server error.";
                                    break;
                                // TODO: optional extra error messages
                                default:
                                    console.log(code);
                                    $scope.message = "Upload failed. Error code " + code + ".";
                                    break;
                            }
                        });
                    //.then(success, error, progress);
                }
            }else{
                $scope.uploadDeclined = true;
            }
        }

    }]);
})();