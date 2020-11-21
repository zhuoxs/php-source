/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 彩蛋页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-10 10:00:02
 * @endtime 2019-4-10 10:00:02
 */
var base_module = angular.module("surprised_app", []);
base_module.controller(
    "surprised_controller",
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
                'integral_show': false,
                'coupon_show': false,
                'coupon_image_show': false,
                'surprised_info': {
                    'category': '',
                    'value': '',
                    'couponname': '',
                    'probability': '',
                },
                'surprised_list': [],
                'category': [],
                'where': {
                    'search': '',
                    'page': '',
                },
            };

            $scope.function = {
                'get_category': function () {
                    $http.get(
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.surprised.getCategory"
                    ).then(
                        function (result) {
                            $scope.data.category = result.data.data;
                        },
                        function () {
                        }
                    );
                },
                // 获取彩蛋列表
                'get_list': function (url, page) {
                    if (!url) {
                        url = "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.surprised.getList&page=1"
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
                                $scope.data.surprised_list = result.data;
                                $('div.list_pages div.ng-scope').remove();
                                $compile($scope.data.surprised_list.pages)($scope).appendTo('div.list_pages');
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
                'add_surprised_show': function () {
                    $scope.data.surprised_info = {
                        'id': '',
                        'category': '',
                        'value': '',
                        'couponname': '',
                        'probability': '',
                        'coupon_value_text': '',
                        'coupon_value_total': '',
                        'coupon_uselimit': '',
                    };
                    $scope.data.integral_show = false;
                    $scope.data.coupon_show = false;
                    $scope.data.coupon_image_show = false;
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                    if ($scope.data.surprised_info.category === '优惠券') {
                        $('div.img-nickname').text('');
                        $('input[name="couponid"]').val('');
                    }
                },
                'edit_surprised_show': function (data) {
                    console.log(data);
                    console.log($scope.data.surprised_info.couponname);
                    $scope.data.add_show = true;
                    $scope.data.list_show = false;
                    $scope.data.surprised_info = data;
                    if ($scope.data.surprised_info.category === '优惠券') {
                        $('div.img-nickname').text(data.couponname);
                        $('input[name="couponid"]').val(data.value);
                        $scope.data.coupon_image_show = true;
                    }
                },
                'list_surprised_show': function () {
                    $scope.data.add_show = false;
                    $scope.data.list_show = true;
                },
                //新增彩蛋，编辑彩蛋
                'add_surprised': function () {
                    if ($scope.data.surprised_info.category === '优惠券') {
                        $scope.data.surprised_info.value = $('input[name="couponid"]').val();
                    }
                    var message = {
                        'value': '请设置彩蛋内容',
                        'category': '请选择彩蛋种类',
                        'probability': '请输入彩蛋概率',
                    };
                    var is_success = checkInfo($scope.data.surprised_info, message);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.surprised.addInfo',
                        $scope.data.surprised_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.data.add_show = false;
                                $scope.data.list_show = true;
                                $scope.function.get_list();
                                $scope.data.surprised_info = {
                                    'id': '',
                                    'category': '',
                                    'value': '',
                                    'couponname': '',
                                    'probability': '',
                                    'coupon_value_text': '',
                                    'coupon_value_total': '',
                                    'coupon_uselimit': '',
                                };
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                //刪除一条数据
                'delete_surprised': function (id) {
                    if (confirm('确定要删除该彩蛋吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.surprised.deleteInfo',
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
                        );
                    }
                },
                //刪除多条数据
                'delete_all_surprised': function (id) {
                    if (confirm('确定要删除该彩蛋吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.surprised.deleteAll',
                            {
                                'ids': id
                            }
                        ).then(
                            function (result) {
                                alert(result.data.message);
                                if (result.data.code) {
                                    $scope.function.get_list();
                                }
                            },
                        );
                    }
                }
            };
            $scope.$watch('data.surprised_info.category', function (newValue, oldValue) {
                if (newValue === '积分') {
                    $scope.data.integral_show = true;
                    $scope.data.coupon_show = false;
                } else if (newValue === '优惠券') {
                    $scope.data.coupon_show = true;
                    $scope.data.integral_show = false;
                    $scope.data.coupon_image_show = true;
                }
            });
            $scope.function.get_category();
            $scope.function.get_list("/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.surprised.getList&page=1");

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