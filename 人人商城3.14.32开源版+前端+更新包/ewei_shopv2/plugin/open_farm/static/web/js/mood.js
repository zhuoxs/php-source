/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 心情页面数据js
 * @author 葛兴枫
 * @datetime 2019-4-9 10:27:02
 * @endtime 2019-4-9 10:27:02
 */
var base_module = angular.module("mood_app", []);
base_module.controller(
    "mood_controller",
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
                'mood_info': {
                    'id': '',
                    'uniacid': '',
                    'background': '',
                    'logo': '',
                    'show_background': '',
                    'picture_list': [],
                },
            };

            /**
             * 初始化方法
             */
            $scope.function = {
                'get_info': function () {
                    $http.get(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.mood.getInfo',
                    ).then(
                        function (result) {
                            $scope.data.mood_info = result.data.data;
                            $scope.data.mood_info.show_background = result.data.data.show_background + "?a=" + Math.random();
                        },
                        function () {

                        }
                    );
                },
                'add_info': function () {
                    $scope.data.mood_info.logo = $('input[name="logo"].form-control').val();
                    $scope.data.mood_info.background = $('input[name="background"].form-control').val();
                    $scope.data.mood_info.picture_list = [];
                    document.getElementsByName('picture[]').forEach(function (data) {
                        $scope.data.mood_info.picture_list.push(data.value);
                    });
                    var message = {
                        'logo': '请选择心情logo',
                        'picture_list': '请选择心情图片',
                    };
                    var is_success = checkInfo($scope.data.mood_info, message);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.mood.addInfo',
                        $scope.data.mood_info
                    ).then(
                        function (result) {
                            alert(result.data.message);
                            $scope.data.mood_info.picture_list = [];
                            $('div.input-group.multi-img-details#picture_list div').remove();
                            $scope.function.get_info();
                        },
                        function () {

                        }
                    );
                },
            };
            $scope.function.get_info();

        }
    ]
);