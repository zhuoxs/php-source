/**
 * 用户统计页面
 */
var module = angular.module('index_module', []);
module.controller(
    'index_controller',
    [
        "$scope",
        "$http",
        "$compile",
        "$controller",
        "$sce",
        "$interval",
        function ($scope, $http, $compile, $controller, $sce, $interval) {

            /**
             * 初始化页面数据
             */
            $scope.data = {
                'table_show': false,
                'empty_show': true,
                'chicken_list': [],
                'where': {
                    'page': 1,
                    'search': ''
                },
            };

            /**
             * 初始化方法
             */
            $scope.function = {
                'table_show': function () {
                    $scope.data.table_show = true;
                    $scope.data.empty_show = false;
                },
                'empty_show': function () {
                    $scope.data.table_show = false;
                    $scope.data.empty_show = true;
                },
                'get_list': function (url, page) {
                    $scope.data.where.page = page ? page : $scope.data.where.page;
                    $http.post(
                        url,
                        $scope.data.where
                    ).then(
                        function (result) {
                            if (result.data.code && result.data.data.length > 0) {
                                $scope.data.chicken_list = result.data;
                                $('div.list_pages div.ng-scope').remove();
                                $compile($scope.data.chicken_list.pages)($scope).appendTo('div.list_pages');
                                $scope.function.table_show();
                            } else {
                                $scope.function.empty_show();
                            }
                        },
                        function () {

                        }
                    );
                }
            };

            /**
             * 监听搜索
             */
            $scope.$watch(
                'data.where.search',
                function () {
                    $scope.data.where.page = 1;
                    $scope.function.get_list(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.index.getList'
                    );
                }
            );

        }
    ]
);