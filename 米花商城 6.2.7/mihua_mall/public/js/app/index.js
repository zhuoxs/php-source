
	var indexapp = angular.module('indexappaa',[]);
	indexapp.controller('indexapp',['$scope',function($scope){

		$scope.pageinfo = pageparams.basicparams[0];
		$scope.Items = pageparams.params;
		$scope.uniacid = window.sysinfo.uniacid;
        $scope.$on('ngRepeatFinished',function(){
		
			$(".swiper-container").swiper({ //幻灯片
				autoplay : 3000,
				speed : 300,
				autoplayDisableOnInteraction : false,
				onInit : function(){ //设置原点颜色
					$('.swiper-pagination').each(function(){
						var color = $(this).attr('data-color');
						$(this).find('span').css({'background-color':color});
					});
				}
			});
			
			common.indexInit();
        });		

	}]);
	//转html
    indexapp.directive('stringHtml' , function(){
        return function(scope , el , attr){
            if(attr.stringHtml){
                scope.$watch(attr.stringHtml , function(html){
                    el.html(html || '');
                });
            }
        };
    });  	
	
	//初始化图片等
    indexapp.directive("finishRenderFilters",function($timeout){
        return{
            restrict: 'A',
            link: function(scope,element,attr){
                if(scope.$last === true){
                    $timeout(function(){
                        scope.$emit('ngRepeatFinished');
                    });
                }
            }
        };
    });	
	//返回顶部
    indexapp.directive("goToTop", function() {
      return {
        link: function(scope, elem, attrs) {
			var wheight = $(window).height();
			$('.content').scroll(function() {
				var s = $('.content').scrollTop();	
				// if( s > wheight*1.5) {
				// 	$("#gotoTop").show();
				// } else {
				// 	$("#gotoTop").hide();
				// };
			});
	
			$('body').on('click','#gotoTop',function(){
				$('.content').scrollTop(0);	
			});
        }
      };
    });
