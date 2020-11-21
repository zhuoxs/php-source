/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 回复页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-10 09:27:02
 * @endtime 2019-4-10 09:27:02
 */
var base_module = angular.module("reply_app", []);
base_module.controller(
    "reply_controller",
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
                'reply_info': {
                    'id': '',
                    'brief_introduce': '',
                },
                'reply_list': [],
                'where': {
                    'search': '',
                    'page': '',
                },
            };

            $scope.function = {
                // 获取回复列表
                'get_list': function (url, page) {
                    if (!url) {
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.reply.getList&page=1"
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
                                $scope.data.reply_list = result.data;
                                $('div.list_pages div.ng-scope').remove();
                                $compile($scope.data.reply_list.pages)($scope).appendTo('div.list_pages');
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
                'add_reply_show': function () {
                    $scope.data.reply_info = {};
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                },
                'edit_reply_show': function (data) {
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                    $scope.data.reply_info = data.v;
                },
                'list_reply_show': function () {
                    $scope.data.add_show = false;
                    $scope.data.list_show = true;
                },
                //新增回复，编辑回复
                'add_reply': function () {
                    if ($scope.data.reply_info.brief_introduce === '') {
                        alert('请输入回复内容');
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.reply.addInfo',
                        $scope.data.reply_info
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
                'delete_reply': function (id) {
                    if (confirm('确定要删除该回复吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.reply.deleteInfo',
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
                    }
                }
            };
            $scope.function.get_list("/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.reply.getList&page=1");

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