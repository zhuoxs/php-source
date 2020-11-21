/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 公告页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-8 14:27:02
 * @endtime 2019-4-8 14:27:02
 */
var base_module = angular.module("notice_app", []);
base_module.controller(
    "notice_controller",
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
                'add_show': false,
                'table_show': false,
                'empty_show': true,
                'notice_info': {
                    'id': '',
                    'title': '',
                    'content': '',
                },
                'notice_list': [],
                'where': {
                    'search': '',
                    'page': '',
                },
            };

            $scope.function = {
                // 获取公告列表
                'get_list': function (url, page) {
                    if (!url) {
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.notice.getList&page=1"
                    }
                    if (page) {
                        url = url.substr(0, url.lastIndexOf('=') + 1) + page;
                    }
                    $http.post(
                        url,
                        $scope.data.where
                    ).then(
                        function (result) {
                            if (result.data.data.length > 0) {
                                $scope.data.table_show = true;
                                $scope.data.empty_show = false;
                                $scope.data.notice_list = result.data;
                                $('div.we_app_pages div.ng-scope').remove();
                                $compile($scope.data.notice_list.pages)($scope).appendTo('div.we_app_pages');
                            } else {
                                $scope.data.table_show = false;
                                $scope.data.empty_show = true;
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                'edit_notice_show': function (data) {
                    $scope.data.notice_info = data.v;
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                },
                'add_notice_show': function () {
                    $scope.data.notice_info = {
                        'title': '',
                        'content': '',
                    };
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                },
                'list_notice_show': function () {
                    $scope.data.add_show = false;
                    $scope.data.list_show = true;
                },
                //新增公告，编辑公告
                'add_notice': function () {
                    var message = {
                        'title': '请输入公告标题',
                        'content': '请输入公告内容',
                    };
                    var is_success = checkInfo($scope.data.notice_info, message);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.notice.addInfo',
                        $scope.data.notice_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.data.add_show = false;
                                $scope.data.list_show = true;
                                $scope.function.get_list();
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                //刪除一条数据
                'delete_notice': function (id) {
                    if (confirm('确定要删除该公告吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.notice.deleteInfo',
                            {
                                'id': id
                            }
                        ).then(
                            function (result) {
                                if (confirm(result.data.message)) {
                                    $scope.function.get_list();
                                }
                            },
                            function () {
                            }
                        );
                    } else {
                    }

                }
            };
            $scope.function.get_list("/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.notice.getList&page=1");

            /**
             * 监听搜索
             */
            $scope.$watch(
                'data.where.search',
                function () {
                    $scope.data.where.page = 1;
                    $scope.function.get_list();
                }
            );

        }
    ]
);