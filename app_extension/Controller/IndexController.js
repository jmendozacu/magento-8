app.controller('indexController', function($scope, restService, $modal, $window, Utils) {

    $scope.getQueryParam = function(param) {
        var found;
        $window.location.search.substr(1).split("&").forEach(function(item) {
            if (param ==  item.split("=")[0]) {
                found = item.split("=")[1];
            }
        });
        return found;
    };

    $scope.initValue = function () {

        /*page setup*/
        $scope.bigCurrentPage = 1;
        $scope.rowsPerPage = 100;

        $scope.setPage = function (pageNo) {
            $scope.bigCurrentPage = pageNo;
        };

        $scope.pageChanged = function() {
            $scope.listAllAssets();
        };
        /*page setup*/

        $scope.authenticated = false;
        var host = $window.location.hostname;
        var magentoDirectory = '/magento1911';
        var magentoHost = host + magentoDirectory;
        var callbackUrl = $window.location.origin + $window.location.pathname;
        $scope.authObject = {
            callbackUrl: callbackUrl,
            apiUrl: 'http://' + magentoHost + '/api/rest',
            temporaryCredentialsRequestUrl: 'http://' + magentoHost + '/oauth/initiate?oauth_callback=' + encodeURIComponent(callbackUrl),
            adminAuthorizationUrl: 'http://' + magentoHost + '/admin/oauth_authorize',
            accessTokenRequestUrl: 'http://' + magentoHost + '/oauth/token',
            consumerKey: '789e039853dab9b8be2285253ea39e88',
            consumerSecret: 'e60d275a6fc4033cf72918992acb100c'
        };
        var oauth_token = $scope.getQueryParam('oauth_token');
        var oauth_verifier = $scope.getQueryParam('oauth_verifier');
        if (oauth_token) {
            $scope.authObject.oauth_token = oauth_token;
        }
        if (oauth_verifier) {
            $scope.authObject.oauth_verifier = oauth_verifier;
        }
        $scope.pageSetup = {
            debug: false
        };
    };
    $scope.initValue();

    $scope.destroySession = function () {
        restService.destroySession().success(function (data) {
            $window.alert(data.message);
        });
    };

    $scope.checkSessionState = function () {
        restService.checkSessionState($scope.authObject).success(function (data) {
            if (data.status == 'success') {
                switch (data.state) {
                    case 1:
                        $window.location.assign(data.location);
                        break;
                    case 2:
                        $window.location.assign(data.location);
                        break;
                    case 'verified':
                        $scope.authenticated = true;
                        $scope.alert = {
                            type: 'success',
                            msg: 'AUTHENTICATION SUCCESS'
                        };
                        break;
                }
            }
        });
    };
    $scope.checkSessionState();

    $scope.backHome = function () {
        $window.location.assign($scope.authObject.callbackUrl);
    };

    $scope.getProductList = function () {
        $scope.authObject.action = 'getProductList';
        $scope.authObject.method = 'GET';
        $scope.authObject.restPostfix = '/custom_product';
        restService.proceedRestData($scope.authObject, $scope.bigCurrentPage, $scope.rowsPerPage).success(function (response) {
            $scope.count = {
                update: 0,
                getInfo: 0
            };
            $scope.productList = response.DataCollection;
        });
    };

    $scope.createNewProduct = function () {
        $scope.authObject.action = 'createNewProduct';
    };

    $scope.closeAlert = function () {
        delete $scope.alert;
    };

    $scope.isNotEmpty = function (value) {
        return Utils.isDefinedAndNotNull(value);
    };

    $scope.getInformationFromIntelligence = function () {
        angular.forEach($scope.productList, function (obj, key) {
            restService.getInformationFromIntelligence(obj.sku).success(function (response) {
                $scope.productList[key].intelligenceInfo = $scope.productList[key].intelligenceInfo || {};
                $scope.productList[key].intelligenceInfo = response.DataCollection;
                $scope.count.getInfo++;
                $scope.alert = {
                    type: 'success',
                    msg: $scope.count.getInfo
                };
                if ($scope.count.getInfo == $scope.rowsPerPage) {
                    $scope.alert.msg = 'GET INFO DONE';
                }
            });
        });
    };

    $scope.updateInfo = function (updateId, productInfo) {
        var UpdateObj = {
            action: 'updateProductList',
            method: 'PUT',
            restPostfix: '/products/' + updateId,
            requestBody: {
                description: productInfo.intelligenceInfo.Introduction ? productInfo.intelligenceInfo.Introduction : ' ',
                ne_description: productInfo.intelligenceInfo.Introduction ? productInfo.intelligenceInfo.Introduction : ' ',
                ne_highlight: productInfo.intelligenceInfo.Intelligence ? productInfo.intelligenceInfo.Intelligence : ' '
            },
            apiUrl: $scope.authObject.apiUrl,
            consumerKey: $scope.authObject.consumerKey,
            consumerSecret: $scope.authObject.consumerSecret
        };
        restService.proceedRestData(UpdateObj).success(function (response) {
            $scope.count.update++;
            $scope.alert = {
                type: 'success',
                msg: response.restPostfix + ' ' + response.http_code + ' ' + $scope.count.update
            };
        });
    };

    $scope.updateAllInfo = function () {
        angular.forEach($scope.productList, function (obj) {
            if (Utils.isUndefinedOrNull(obj.intelligenceInfo)) {
                $window.alert('NO INFO TO UPDATE');
                return;
            }
            $scope.updateInfo(obj.entity_id, obj);
        });
    };

    $scope.chooseTargetProductToUploadImage = function (entity) {
        var uploadObj = {
            apiUrl: $scope.authObject.apiUrl,
            consumerKey: $scope.authObject.consumerKey,
            consumerSecret: $scope.authObject.consumerSecret,
            itemObj: entity
        };
        $scope.openModal(uploadObj);
    };

    $scope.openModal = function (uploadObj) {
        var modalInstance = $modal.open({
            animation: true,
            templateUrl: 'template/uploadProductImage.html',
            controller: 'ModalInstanceCtrl',
            resolve: {
                uploadObj: function () {
                    return uploadObj;
                }
            }
        });
    };

    $scope.toggleDebugMode = function () {
        $scope.pageSetup.debug = !$scope.pageSetup.debug;
    };

});


