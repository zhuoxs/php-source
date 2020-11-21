// index.js
var app = angular.module("myapp", []);
app.controller('farm',
    [
        '$scope',
        '$http',
        function ($scope, $http) {
            $scope.allocation={};
            $scope.loading=function (title) {
                $('body').loading({
                    loadingWidth:120,
                    title:title,
                    name:'test',
                    discription:'',
                    direction:'column',
                    type:'origin',
                    originDivWidth:40,
                    originDivHeight:40,
                    originWidth:6,
                    originHeight:6,
                    smallLoading:false,
                    loadingMaskBg:'rgba(0,0,0,0.2)'
                });
            };
            // 获取农场配置
            $scope.loading('');
            var url= window.location.href;
            url = url.replace(/^https:\/\/[^/]+/, "");
            url=url.split('&r')[0];
            $scope.allocation={};
            $scope.configure=function(){
                $scope.loading('');
                $http.get(
                    url+'&r=open_farm.configure.getInfo'
                ).then(
                    function (data) {
                        if (data.data.code===1) {
                            if(data.data.data.name&&data.data.data.name!=="null"){
                                document.title=data.data.data.name;
                            }else{
                                document.title="人人农场"
                            }
                            $scope.allocation=data.data.data;
                            localStorage.setItem('config',JSON.stringify(data.data.data));
                        }
                        removeLoading('test');
                    },
                    function () {
                    });
            };
            $scope.configure();

        }
    ]
);
