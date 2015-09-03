app.controller('ModalInstanceCtrl', function ($scope, uploadObj, restService) {

    $scope.uploadObj = uploadObj;

    $scope.uploadProductImage = function () {
        restService.uploadProductImage($scope.uploadObj).success(function (response) {
            console.log(response);
        });
    };

});