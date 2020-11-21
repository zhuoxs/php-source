/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 农场设置文件
 * @author 葛兴枫
 * @datetime 2019-4-2 09:27:02
 */
var base_module = angular.module("seting_app", []);
base_module.controller(
    "seting_controller",
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
             * @type {{seting_info: object}}
             */
            $scope.data = {
                'seting_info': {
                    'eat_time': '',
                    'time_steal': '',
                    'steal_eat_time': '',
                    'eat_tips': '',
                    'warehouse': '',
                    'bowl': '',
                    'lay_eggs_eat': '',
                    'lay_eggs_tips': '',
                    'lay_eggs_number_min': '',
                    'lay_eggs_number_max': '',
                    'obtain_feed_max': '',
                    'exchange_integral_max': '',
                    'feed_invalid_time': '',
                    'egg_invalid_time': '',
                    'eat_experience': '',
                    'rate': '',
                    'advertisement_max': '',
                    'shop': '',
                },
                'origin_seting_info': {
                    'eat_time': '',
                    'time_steal': '',
                    'steal_eat_time': '',
                    'eat_tips': '',
                    'warehouse': '',
                    'bowl': '',
                    'lay_eggs_eat': '',
                    'lay_eggs_tips': '',
                    'lay_eggs_number_min': '',
                    'lay_eggs_number_max': '',
                    'obtain_feed_max': '',
                    'exchange_integral_max': '',
                    'feed_invalid_time': '',
                    'egg_invalid_time': '',
                    'eat_experience': '',
                    'rate': '',
                    'advertisement_max': '',
                    'shop': '',
                },
            };
            $scope.function = {
                // 获取所有配置信息
                'get_info': function () {
                    $http.get(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.seting.getInfo'
                    ).then(
                        function (result) {
                            $scope.data.seting_info = result.data.data;
                            window.localStorage.setItem('bowl', result.data.data.bowl);
                            window.localStorage.setItem('lay_eggs_eat', result.data.data.lay_eggs_eat);
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                // 编辑配置
                'edit_info': function () {
                    var message = {
                        'eat_time': '请填写吃一克饲料所需的时间',
                        // 'time_steal' : '请填写食盆中无饲料多少秒后开始偷',
                        // 'steal_eat_time' : '请填写偷吃一克的时间',
                        'eat_tips': '请填写吃完放置饲料之后的提示',
                        // 'warehouse' : '请填写仓库储存的饲料总数限制',
                        'bowl': '请填写食盆里面的数量限制',
                        'lay_eggs_eat': '请填写下蛋需要吃的饲料克数',
                        'lay_eggs_tips': '请填写下蛋之后的提示消息',
                        'lay_eggs_number_min': '请填写下蛋最少个数',
                        'lay_eggs_number_max': '请填写下蛋最大个数',
                        // 'obtain_feed_max' : '请填写获取饲料最多克数',
                        'exchange_integral_max': '请填写一天内最多兑换积分',
                        // 'feed_invalid_time' : '请填写饲料失效时间',
                        'egg_invalid_time': '请填写鸡蛋失效时间',
                        'eat_experience': '请填写吃一克的经验',
                        'rate': '请填写鸡蛋与积分的汇率',
                        // 'advertisement_max' : '请填写广告个数',
                        'surprised_probability': '请填写生出彩蛋概率',
                        'shop': '请填写首页商城链接',
                    };
                    var is_success = checkInfo($scope.data.seting_info, message);
                    if (!is_success) {
                        return false;
                    }
                    // 判断食盆中的饲料量与下蛋所需饲料量
                    if (parseInt($scope.data.seting_info.lay_eggs_eat) < parseInt($scope.data.seting_info.bowl)) {
                        alert('下蛋所需饲料数请尽量大于食盆内数量');
                        return false;
                    }
                    // 判断最少下蛋数和最多下蛋数
                    if (parseInt($scope.data.seting_info.lay_eggs_number_min) > parseInt($scope.data.seting_info.lay_eggs_number_max)) {
                        alert('下蛋最少数应小于下蛋最多数！');
                        return false;
                    }
                    //不能为0的参数
                    if(parseInt($scope.data.seting_info.eat_time)<=0){
                        alert('吃一克的时间需大于0');
                        return false;
                    }
                    if(parseInt($scope.data.seting_info.bowl)<=0){
                        alert('食盆里面的数量限制需大于0');
                        return false;
                    }

                    // 判断下蛋所需饲料数是否变化
                    if (
                        $scope.data.seting_info.lay_eggs_eat !== window.localStorage.getItem('lay_eggs_eat')
                        ||
                        $scope.data.seting_info.bowl !== window.localStorage.getItem('bowl')
                    ) {
                        if (!confirm('修改下蛋所需饲料或食盆数量时,小鸡下蛋的数量会有所变化,确定修改吗?')) {
                            return false;
                        }
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.seting.editInfo',
                        $scope.data.seting_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            if (result.data.code) {
                                $scope.function.get_info();
                            }
                        },
                        function () {
                            alert('操作失败，请稍候再试');
                        }
                    );
                },
            };

            $scope.function.get_info();

        }
    ]
);