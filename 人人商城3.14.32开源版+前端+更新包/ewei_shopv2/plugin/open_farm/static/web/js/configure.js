/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 首页数据js
 * @author 葛兴枫
 * @datetime 2019-4-2 09:27:02
 * @endtime 2019-4-2 09:27:02
 */
var base_module = angular.module("configure_app", []);
base_module.controller(
    "configure_controller",
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
                'farm_info': {
                    'name': '',
                    'url': '',
                    'qrcode': '',
                    'keyword': '',
                    'title': '',
                    'logo': '',
                    'describe': '',
                    'public_qrcode': '',
                    'force_follow': '',
                },
            };

            $scope.function = {
                // 获取所有配置信息
                'get_info': function () {
                    $http.get(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.configure.getInfo'
                    ).then(
                        function (result) {
                            if (result.data.data !== false) {
                                $scope.data.farm_info = result.data.data;
                            }
                        },
                        function () {
                            alert('操作失败');
                        }
                    );
                },
                // 编辑配置
                'edit_info': function () {
                    $scope.data.farm_info.public_qrcode = $('input[name="public_qrcode"].form-control').val();
                    $scope.data.farm_info.logo = $('input[name="logo"].form-control').val();
                    var message = {
                        'name': '请输入农场名称',
                        'qrcode': '请上传入口二维码',
                        'keyword': '请输入入口关键字',
                        'title': '请输入分享标题',
                        'logo': '请上传分享图标',
                        'describe': '请输入分享描述',
                        'force_follow': '请选择是否强制关注公众号'
                    };
                    var is_success = checkInfo($scope.data.farm_info, message);
                    if (!is_success) {
                        return false;
                    }
                    $http.post(
                        '/web/index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=open_farm.configure.editInfo',
                        $scope.data.farm_info
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