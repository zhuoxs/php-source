/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 *等级设置页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-9 14:27:02
 * @endtime 2019-4-9 14:27:02
 */
var base_module = angular.module("grade_app", []);
base_module.controller(
    "grade_controller",
    [
        "$scope",
        "$http",
        "$compile",
        "$controller",
        "$sce",
        "$interval",
        function ($scope, $http, $compile, $controller, $sce, $interval) {

            /**
             * 当前页面初始化数据
             * @type {{add_we_app_show: boolean, we_app_list_show: boolean}}
             */
            $scope.data = {
                'list_show': true,
                'grade_info': {
                    'level': '',
                    'experience': '',
                    'accelerate': '',
                    'surprised_guard': '',
                },
                'grade_list': [],
                'where': {
                    'page': 1,
                }
            };
            $scope.function = {
                'table_show': function () {
                    $scope.data.table_show = true;
                    $scope.data.empty_show = false;
                },
                'empty_show': function () {
                    $scope.data.table_show = false;
                    $scope.data.empty_show = true;
                },
                // 获取所有等级列表
                'get_list': function (url, page) {
                    $scope.data.where.page = page ? page : $scope.data.where.page;
                    if (!url) {
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.grade.getList"
                    }
                    $http.post(
                        url,
                        $scope.data.where
                    ).then(
                        function (result) {
                            if (result.data.data && result.data.data.length > 0) {
                                $scope.function.table_show();
                                $scope.data.grade_list = result.data;
                                $('div.list_pages div.ng-scope').remove();
                                $compile($scope.data.grade_list.pages)($scope).appendTo('div.list_pages');
                            } else {
                                if ($scope.data.where.page > 1) {
                                    $scope.data.where.page -= 1;
                                    $scope.function.get_list();
                                }
                                $scope.function.empty_show();
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                //编辑等级
                'add_grade': function () {
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.grade.addInfo',
                        $scope.data.grade_list.data
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.function.get_list();
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                //添加等级
                'save_info': function () {
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.grade.saveInfo',
                        $scope.data.grade_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.function.get_list();
                                $scope.data.grade_info = {
                                    'level': '',
                                    'experience': '',
                                    'accelerate': '',
                                    'surprised_guard': '',
                                };
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                //删除等级
                'delete_info': function (id) {
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.grade.deleteInfo',
                        {
                            id: id
                        }
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.function.get_list();
                                $scope.data.grade_info = [];
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
            };
            $scope.function.get_list("/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.grade.getList");
        }
    ]
);