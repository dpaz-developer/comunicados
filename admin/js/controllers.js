'use strict'

/* Controllers */

function ComunicadosAdminController ($scope,$http, $q, $upload,$timeout,$filter,Broadcast){
    
    $scope.urlPic = [];
    $scope.urlPic[0] = "";
    $scope.urlPic[1] = "";
    $scope.urlPic[2] = "";
    $scope.bnnrSection = "laseccion";


    $scope.editNota = function(urlImageMain, urlImageDetails){
        $scope.urlPic[0] = urlImageMain;
        $scope.urlPic[1] = urlImageDetails;
    };


    /* **** Para el tratado de la imagenes *********/


    $scope.onFileSelect = function ($files, indexPicture) {

        console.log("Entramos a la funcion de subida de fotografias");
        $scope.urlImageMain = "Sin procesar..";

        for (var i = 0; i < $files.length; i++) {
            var $file = $files[i];
            console.log("el file es" + $file.name);

            var fd = new FormData();
            fd.append('inputMainImage', $file);
            $http.post('../admin/LoadPicture.php?sectionName=' + $scope.bnnrSection, fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            })
            .success(function (response) {
                console.log("EL valor retornado es" + response);
                $scope.urlImageMain = response;
                $scope.urlPic[indexPicture] = response;
            })
            .error(function () {
            });

        }

    };
    /**********************************/
    
}
