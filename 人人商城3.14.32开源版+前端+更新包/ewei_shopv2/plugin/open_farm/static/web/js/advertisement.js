/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 广告页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-9 14:27:02
 * @endtime 2019-4-11 11:11:02
 */
var base_module = angular.module("advertisement_app", []);
base_module.controller(
    "advertisement_controller",
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
                'advertisement_max': 0,
                'list_show': true,
                'add_show': false,
                'table_show': false,
                'empty_show': true,
                'search': '',
                'advertisement_info': {
                    'name': '',
                    'logo': '',
                    'url': '',
                },
                'advertisement_list': [],

            };

            $scope.function = {
                'get_advertisement_max': function () {
                    $http.get(
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.seting.getAdvertisementMax"
                    ).then(
                        function (result) {
                            $scope.data.advertisement_max = result.data.data;
                        },
                        function () {
                        }
                    );
                },
                // 获取广告列表
                'get_list': function (url, page) {
                    if (!url) {
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.advertisement.getList&page=1"
                    }
                    if (page) {
                        url = url.substr(0, url.lastIndexOf('=') + 1) + page;
                    }
                    $http.post(
                        url,
                        {
                            'search': $scope.data.search
                        }
                    ).then(
                        function (result) {
                            if (result.data.data.length > 0) {
                                $scope.data.table_show = true;
                                $scope.data.empty_show = false;
                                $scope.data.advertisement_list = result.data;
                                $('div.list_pages div.ng-scope').remove();
                                $compile(result.data.pages)($scope).appendTo('div.list_pages');
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
                'edit_advertisement_show': function (data) {
                        $scope.data.add_show = true;
                        $scope.data.list_show = false;
                        $scope.data.advertisement_info = data.v;
                },
                'add_advertisement_show': function () {
                    if ($scope.data.advertisement_list.data && $scope.data.advertisement_list.data.length >= $scope.data.advertisement_max) {
                        alert('最多添加 ' + $scope.data.advertisement_max + ' 个按钮');
                        return false;
                    }
                    $scope.data.advertisement_info = {
                        'name': '',
                        'logo': '',
                        'show_logo': '',
                        'url': '',
                    };
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;

                },
                'list_advertisement_show': function () {
                    $scope.data.add_show = false;
                    $scope.data.list_show = true;
                },
                //新增广告，编辑广告
                'add_advertisement': function () {
                    $scope.data.advertisement_info.logo = $('input[name="logo"].form-control').val();
                    var message = {
                        'name': '请输入公告标题',
                        'logo': '请上传按钮图标',
                        'url': '请输入跳转链接',
                    };
                    var is_success = checkInfo($scope.data.advertisement_info, message);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.advertisement.addInfo',
                        $scope.data.advertisement_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.data.add_show = false;
                                $scope.data.list_show = true;
                                $scope.function.get_list();
                                $scope.data.advertisement_info = {};
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                //刪除一条数据
                'delete_advertisement': function (id) {
                    if (confirm('确定要删除该广告吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.advertisement.deleteInfo',
                            {
                                'id': id
                            }
                        ).then(
                            function (result) {
                                alert(result.data.message);
                                if (result.data.code) {
                                    $scope.function.get_list();
                                }
                            },
                            function () {}
                        );
                    }

                }
            };
            $scope.function.get_advertisement_max();
            $scope.function.get_list("/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.advertisement.getList");

        }
    ]
);