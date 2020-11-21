/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 任务页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-9 10:27:02
 * @endtime 2019-4-9 10:27:02
 */
var base_module = angular.module("task_app", []);
base_module.controller(
    "task_controller",
    [
        "$scope",
        "$http",
        "$compile",
        "$controller",
        "$sce",
        "$interval",
        function ($scope, $http, $compile, $controller, $sce, $interval) {

            /**
             * 初始化数据
             */
            $scope.data = {
                'add_show': false,
                'table_show': false,
                'empty_show': true,
                'tool_show': true,
                'task_list': [],
                'where': {
                    'search': '',
                    'page': 1,
                },
                'task_info': {
                    'id': '',
                    'uniacid': '',
                    'title': '',
                    'feed': '',
                    'logo': '',
                    'get_max': '',
                    'frequency': '',
                    'start_time': '',
                    'end_time': '',
                    'category': '',
                    'value': '',
                    'order_feed': '',
                    'money_feed': '',
                    'goods_id': '',
                    'member_level': '',
                    'member_level_feed': '',
                },
                'category_list': [],
                'core_list': [],
                'goods_list': [],
            };

            /**
             * 初始化方法
             */
            $scope.function = {
                'add_show': function () {
                    $scope.data.add_show = true;
                    $scope.data.table_show = false;
                    $scope.data.empty_show = false;
                    $scope.data.tool_show = false;
                    $('em.close').click();
                    $scope.data.task_info = {
                        'id': '',
                        'uniacid': '',
                        'title': '',
                        'feed': '',
                        'logo': '',
                        'show_logo': './resource/images/nopic.jpg',
                        'get_max': '',
                        'frequency': '',
                        'start_time': '',
                        'end_time': '',
                        'category': '',
                        'value': '',
                        'order_feed': '',
                        'money_feed': '',
                        'goods_id': '',
                        'member_level': '',
                        'member_level_feed': '',
                    };
                },
                'edit_show': function (data) {
                    $scope.data.task_info = {
                        'id': '',
                        'uniacid': '',
                        'title': '',
                        'feed': '',
                        'logo': '',
                        'show_logo': '',
                        'get_max': '',
                        'frequency': '',
                        'start_time': '',
                        'end_time': '',
                        'category': '',
                        'value': '',
                        'order_feed': '',
                        'money_feed': '',
                        'goods_id': '',
                        'member_level': '',
                        'member_level_feed': '',
                    };
                    $scope.data.add_show = true;
                    $scope.data.table_show = false;
                    $scope.data.empty_show = false;
                    $scope.data.tool_show = false;
                    $scope.data.task_info = data;
                },
                'table_show': function () {
                    $scope.data.add_show = false;
                    $scope.data.tool_show = true;
                    $scope.data.table_show = true;
                    $scope.data.empty_show = false;
                },
                'empty_show': function () {
                    $scope.data.add_show = false;
                    $scope.data.tool_show = true;
                    $scope.data.table_show = false;
                    $scope.data.empty_show = true;
                },
                'list_show': function () {
                    // 初始化获取数据
                    $scope.function.get_list(
                        "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getList"
                    );
                },
                'get_list': function (url, page) {
                    $scope.data.where.page = page ? page : $scope.data.where.page;
                    $http.post(
                        url,
                        $scope.data.where
                    ).then(
                        function (result) {
                            if (result.data.data && result.data.data.length > 0) {
                                $scope.function.table_show();
                                $scope.data.task_list = result.data;
                                $('div.list_pages div.ng-scope').remove();
                                $compile($scope.data.task_list.pages)($scope).appendTo('div.list_pages');
                            } else {
                                $scope.function.empty_show();
                            }
                        },
                        function () {
                            alert('网络错误,请稍后重试!');
                        }
                    );
                },
                'get_category': function () {
                    $http.get(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getCategory'
                    ).then(
                        function (result) {
                            $scope.data.category_list = result.data;
                        },
                        function () {
                        }
                    );
                },
                'get_core': function () {
                    $http.get(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getTaskCore'
                    ).then(
                        function (result) {
                            $scope.data.core_list = result.data;
                        },
                        function () {
                        }
                    );
                },
                'get_member_level': function () {
                    $http.get(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getMemberLevel'
                    ).then(
                        function (result) {
                            $scope.data.member_level_list = result.data;
                        },
                        function () {
                        }
                    );
                },
                'get_goods': function () {
                    $http.get(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getGoods'
                    ).then(
                        function (result) {
                            $scope.data.goods_list = result.data;
                        },
                        function () {
                        }
                    );
                },
                'add_info': function () {
                    $scope.data.task_info.logo = $('input[name="logo"].form-control').val();
                    var message = {
                        'title': '请输入任务标题',
                        'logo': '请选择任务logo',
                        'category': '请选择任务种类',
                        'get_max': '请选择当前任务每天能够最多获取多少饲料',
                        'start_time': '请选择开始时间',
                        'end_time': '请选择结束时间',
                    };
                    var is_success = checkInfo($scope.data.task_info, message);
                    console.log($scope.data.task_info);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.addInfo',
                        $scope.data.task_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.function.get_list(
                                    "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getList",
                                    1
                                );
                            }
                        },
                        function () {

                        }
                    );
                },
                'delete_info': function (id) {
                    if (confirm('真的要删除该数据吗?')) {
                        $http.post(
                            '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.deleteInfo',
                            {
                                id: id,
                            }
                        ).then(
                            function (result) {
                                alert(result.data.message);
                                if (result.data.code) {
                                    $scope.function.get_list(
                                        "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getList",
                                        1
                                    );
                                }
                            },
                            function () {
                                alert('网络异常,请稍后重试!');
                            }
                        );
                    }
                }
            };
            // 初始化获取数据
            $scope.function.get_list(
                "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getList"
            );
            $scope.function.get_category();
            $scope.function.get_core();
            $scope.function.get_goods();
            $scope.function.get_member_level();
            /**
             * 监听search
             */
            $scope.$watch(
                'data.where.search',
                function (newValue, oldValue) {
                    $scope.function.get_list(
                        "/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.task.getList",
                        1
                    );
                }
            );
            /**
             * 监听任务种类,展示任务中心
             */
            $scope.$watch(
                'data.task_info.category',
                function (newValue, oldValue) {
                    var input_arr = [
                        'core_list',
                        'feed_input',
                        'goods_list',
                        'core_feed_input',
                        'goods_feed_input',
                        'order_feed_input',
                        'money_feed_input',
                        'member_level_feed_input',
                        'member_level_list',
                    ];
                    for (var key in input_arr) {
                        var input = $('div#' + input_arr[key]);
                        if (input) {
                            input.remove();
                        }
                    }
                    var htmlStr = '';
                    switch (newValue) {
                        case '签到':
                            htmlStr =
                                '<div class="form-group" id="feed_input">\n' +
                                '    <label class="col-sm-2 control-label" for="feed">获取饲料数量 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <div class="col-sm-12 input-group">\n' +
                                '            <input type="text" ng-model="data.task_info.feed" class="form-control" id="feed" placeholder=""/>\n' +
                                '            <span class="input-group-addon">克</span>\n' +
                                '        </div>\n' +
                                '        <span class="help-block">填写获取饲料的数量</span>\n' +
                                '    </div>\n' +
                                '</div>';
                            break;
                        case '会员领取':
                            htmlStr =
                                '<div class="form-group" id="member_level_feed_input">\n' +
                                '    <label class="col-sm-2 control-label" for="member_level_feed">可领取多少饲料 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <div class="col-sm-12 input-group">\n' +
                                '            <input type="text" ng-model="data.task_info.member_level_feed" class="form-control" id="member_level_feed" placeholder=""/>\n' +
                                '            <span class="input-group-addon">克</span>\n' +
                                '        </div>\n' +
                                '        <span class="help-block">填写可领取多少饲料</span>\n' +
                                '    </div>\n' +
                                '</div>' +
                                '<div class="form-group" id="member_level_list">\n' +
                                '    <label class="col-sm-2 control-label" for="member_level">会员等级 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <select class="form-control" id="member_level" ng-model="data.task_info.member_level" ng-init="data.task_info.member_level">\n' +
                                '           <option ng-repeat="(key, value) in data.member_level_list.data" value="{{value.id}}">{{value.levelname}}</option>' +
                                '        </select>\n' +
                                '        <span class="help-block">请选择会员等级</span>\n' +
                                '    </div>\n' +
                                '</div>';
                            break;
                        case '任务中心':
                            htmlStr =
                                '<div class="form-group" id="core_feed_input">\n' +
                                '    <label class="col-sm-2 control-label" for="core_feed">每个任务可获取多少饲料 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <div class="col-sm-12 input-group">\n' +
                                '            <input type="text" ng-model="data.task_info.core_feed" class="form-control" id="core_feed" placeholder=""/>\n' +
                                '            <span class="input-group-addon">克</span>\n' +
                                '        </div>\n' +
                                '        <span class="help-block">填写每个任务可获取多少饲料</span>\n' +
                                '    </div>\n' +
                                '</div>' +
                                '<div class="form-group" id="core_list">\n' +
                                '    <label class="col-sm-2 control-label" for="core">任务中心 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <select class="form-control" id="core" ng-model="data.task_info.core" ng-init="data.task_info.core">\n' +
                                '           <option ng-repeat="(key, value) in data.core_list.data" value="{{value.id}}">{{value.title}}</option>' +
                                '        </select>\n' +
                                '        <span class="help-block">请选择任务中心的任务</span>\n' +
                                '    </div>\n' +
                                '</div>';
                            break;
                        case '购买商品':
                            htmlStr =
                                '<div class="form-group" id="goods_feed_input">\n' +
                                '    <label class="col-sm-2 control-label" for="goods_feed">每个商品可获取多少饲料 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <div class="col-sm-12 input-group">\n' +
                                '            <input type="text" ng-model="data.task_info.goods_feed" class="form-control" id="goods_feed" placeholder=""/>\n' +
                                '            <span class="input-group-addon">克</span>\n' +
                                '        </div>\n' +
                                '        <span class="help-block">填写每个商品可获取多少饲料</span>\n' +
                                '    </div>\n' +
                                '</div>' +
                                '<div class="form-group" id="goods_list">\n' +
                                '    <label class="col-sm-2 control-label" for="goods_id">任务商品 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <select class="form-control" id="goods_id" ng-model="data.task_info.goods_id" ng-init="data.task_info.goods_id">\n' +
                                '           <option ng-repeat="(key, value) in data.goods_list.data" value="{{value.id}}" ng-selected="value.id===data.task_info.goods_id">{{value.title}}</option>' +
                                '        </select>\n' +
                                '        <span class="help-block">请选择商品名称</span>\n' +
                                '    </div>\n' +
                                '</div>';
                            break;
                        case '商城下单':
                            htmlStr =
                                '<div class="form-group" id="order_feed_input">\n' +
                                '    <label class="col-sm-2 control-label" for="order_feed">每单可获取多少饲料 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <div class="col-sm-12 input-group">\n' +
                                '            <input type="text" ng-model="data.task_info.order_feed" class="form-control" id="order_feed" placeholder=""/>\n' +
                                '            <span class="input-group-addon">克</span>\n' +
                                '        </div>\n' +
                                '        <span class="help-block">填写每单可获取多少饲料</span>\n' +
                                '    </div>\n' +
                                '</div>' +
                                '<div class="form-group" id="money_feed_input">\n' +
                                '    <label class="col-sm-2 control-label" for="money_feed">多少元获取一克饲料 :</label>\n' +
                                '    <div class="col-sm-9 col-xs-12">\n' +
                                '        <div class="col-sm-12 input-group">\n' +
                                '            <input type="text" ng-model="data.task_info.money_feed" class="form-control" id="money_feed" placeholder=""/>\n' +
                                '            <span class="input-group-addon">元</span>\n' +
                                '        </div>\n' +
                                '        <span class="help-block">填写多少元获取一克饲料</span>\n' +
                                '    </div>\n' +
                                '</div>';
                            break;
                    }
                    $compile(htmlStr)($scope).appendTo('form.form-horizontal div.box-body');

                }
            );
        }
    ]
);