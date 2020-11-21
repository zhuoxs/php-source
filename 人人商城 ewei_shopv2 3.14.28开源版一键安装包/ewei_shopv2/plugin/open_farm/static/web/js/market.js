/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 仓库集市页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-11 10:27:02
 * @endtime 2019-4-11 10:27:02
 */
var base_module = angular.module("market_app", []);
base_module.controller(
    "market_controller",
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
                'search': '',
                'market_info': {
                    'title': '',
                    'type': '',
                    'value': '',
                    'egg': '',
                    'logo': '',
                    'number': '',
                },
                'market_list': [],
                'type':[]
            };

            $scope.function = {
                'get_type': function () {
                    $http.get(
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.market.getType"
                    ).then(
                        function (result) {
                            $scope.data.type = result.data.data;
                        },
                        function () {
                        }
                    );
                },
                // 获取集市列表
                'get_list': function (url, page) {
                    if (!url) {
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.market.getList&page=1"
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
                                $scope.data.market_list = result.data;
                                console.log($scope.data);
                                $('div.list_pages div.ng-scope').remove();
                                $compile($scope.data.market_list.pages)($scope).appendTo('div.list_pages');
                            }else{
                                $scope.data.table_show = false;
                                $scope.data.empty_show = true;
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                'add_market_show': function ()   {
                    $scope.data.market_info ={
                        'title': '',
                        'type': '',
                        'value': '',
                        'egg': '',
                        'logo': '',
                        'show_logo': '',
                        'number': '',
                    };
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                },
                'edit_market_show': function (data)   {
                    $scope.data.market_info =data.v;
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                },
                'list_market_show': function () {
                    $scope.data.add_show = false;
                    $scope.data.list_show = true;
                },
                //新增广告，编辑广告
                'add_market': function () {
                    $scope.data.market_info.logo = $('input[name="logo"].form-control').val();
                    var message = {
                        'title' : '请填写标题',
                        'type' : '请选择种类',
                        'value' : '请填写积分数值',
                        'egg' : '请填写兑换所需鸡蛋数量',
                        'logo' : '请上传logo',
                        'number' : '请填写可兑换次数',
                    };
                    var is_success = checkInfo($scope.data.market_info, message);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.market.addInfo',
                        $scope.data.market_info
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
                'delete_market': function (id) {
                    if (confirm('确定要删除该兑换商品吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.market.deleteInfo',
                            {
                                'id':id
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
                    } else {}
                }
            };
            $scope.function.get_type();
            $scope.function.get_list("/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.market.getList&page=1");

        }
    ]
);