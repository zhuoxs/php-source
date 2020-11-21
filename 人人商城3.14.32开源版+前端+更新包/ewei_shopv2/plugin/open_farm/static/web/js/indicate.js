/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 新手指引页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-10 14:27:02
 * @endtime 2019-4-10 14:27:02
 */
var base_module = angular.module("indicate_app", []);
base_module.controller(
    "indicate_controller",
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
                'table_show': false,
                'empty_show': true,
                'search': '',
                'indicate_info': {
                    'image': '',
                    'describe': '',
                },
                'indicate_list': [],
                'list_count': '',
            };

            $scope.function = {
                // 获取新手指引列表
                'get_list': function (url, page) {
                    if (!url) {
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.indicate.getList&page=1"
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
                                $scope.data.indicate_list = result.data;
                                $('div.list_pages div.ng-scope').remove();
                                $compile($scope.data.indicate_list.pages)($scope).appendTo('div.list_pages');
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
                'add_indicate_show': function (data) {
                    $scope.data.indicate_info = data.v;
                },
                'empty_indicate': function () {
                    $scope.data.indicate_info = {
                        'image': '',
                        'describe': '',
                        'show_image': '',
                    };
                },
                //新增新手指引，编辑新手指引
                'add_indicate': function () {
                    $scope.data.indicate_info.image = $('input[name="image"].form-control').val();
                    var message = {
                        'image': '请上传指导图片',
                        'describe': '请输入描述',
                    };
                    var is_success = checkInfo($scope.data.indicate_info, message);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.indicate.addInfo',
                        $scope.data.indicate_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.function.get_list();
                                $scope.data.indicate_info = {
                                    'image': '',
                                    'describe': '',
                                    'show_image': '',
                                };
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },

                //刪除一条数据
                'delete_indicate': function (id) {
                    if (confirm('确定要删除该新手指引吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.indicate.deleteInfo',
                            {
                                'id': id,
                            }
                        ).then(
                            function (result) {
                                alert(result.data.message);
                                if (result.data.code) {
                                    $scope.function.get_list();
                                }
                            },
                            function () {
                            }
                        );
                    }
                }
            };
            $scope.function.get_list("/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.indicate.getList&page=1");

        }
    ]
);