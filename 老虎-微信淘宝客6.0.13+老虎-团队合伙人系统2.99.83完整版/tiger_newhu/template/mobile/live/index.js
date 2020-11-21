var myScroll;

function pullDownAction() {
	
    var from_id = parseInt($(".goods-box:last").find(".num").children("span").html());
   
    //alert(hcid);
    

    $.ajax({
        type: 'GET',
        url: "../app/index.php?i="+weid+"&c=entry&do=livegoodslist&m=tiger_newhu"+turl+"&from_id=" + from_id,
        dataType: 'json',
        success: function (json) {
        	
        	//alert(json);
            for (i = 0; i < json.length; i++) {
                $('#content .goods-box:last').after(json[i]);
            }

            height = $('#scroller').height();
            trans = $('#scroller').css('transform');
            try {
                var scrollTop = Math.abs(trans.match(/-[0-9]+/)[0]);
            } catch (err) {
                var scrollTop = 0;
            }
            myScroll.refresh();
            if (height - scrollTop > 1500) {
                msg_num = parseInt($("#newgoods_notice span").html()) + 1;
                $("#newgoods_notice span").html(msg_num);
                $("#newgoods_notice").fadeIn();
            } else {
                myScroll.scrollToElement(document.querySelector('#content .goods-box:last-child'), 1000);
            }
        },
        error: function (xhr, type) {
            $('.pullDownLabel').html("");
        }
    });
}
function loaded() {
	pullDownEl = document.getElementById('content');
    pullDownOffset = pullDownEl.offsetHeight;//表示获取元素自身的高度
	myScroll = new iScroll('wrapper',{
		vScrollbar:false,
		onScrollMove:function(){
			if (this.y > 5 && !pullDownEl.className.match('flip')) {
                pullDownEl.className = 'flip';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手查看更多';
                this.minScrollY = 0;
                //alert(2);
            }
		},
		onScrollEnd:function(){
			if (pullDownEl.className.match('flip')) {
                pullDownEl.className = 'loading';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';                
                pullDownAction();
                //alert(1);
            }
	
		}
	});
	myScroll.scrollToElement(document.querySelector('#content .goods-box:last-child'),1000);
}

document.addEventListener('touchmove', function (e) {
    e.preventDefault();
}, false);

/* * * * * * * *
 *
 * Use this for high compatibility (iDevice + Android)
 *
 */
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(loaded, 200);
}, false);
/*
 * * * * * * * */


/* * * * * * * *
 *
 * Use this for iDevice only
 *
 */
//document.addEventListener('DOMContentLoaded', loaded, false);
/*
 * * * * * * * */


/* * * * * * * *
 *
 * Use this if nothing else works
 *
 */
//window.addEventListener('load', setTimeout(function () { loaded(); }, 200), false);
/*
 * * * * * * * */

$(document).ready(function () {
    /*设置红包栏出现的时间*/



    /*点击弹幕barrage触发聊天信息栏侧边显示*/
    $(".barrage").click(function () {
        if (!$(".barrage").hasClass('tan-bg')) {
            $(".barrage").removeClass("no-bg").addClass('tan-bg');
        } else {
            $(".barrage").addClass('no-bg').removeClass('tan-bg');
        }
        if (!$('.dLeft').hasClass('mobile-menu-left')) {
            $('.dLeft').addClass('mobile-menu-left');
        } else {
            $('.dLeft').removeClass('mobile-menu-left');
        }
        /*设置再打开弹幕的N秒后进行聊天动画显示*/
        setTimeout(scrollNews, 2000);
    });
    /*
     $('#searchKeywords').focus(function () {
     $('.gift,.share').fadeOut(300);
     setTimeout(function () {
     $('.sendmsg').fadeIn("fast")
     }, 400);
     });
     $('#searchKeywords').focusout(function () {
     $('.sendmsg').fadeOut(300);
     setTimeout(function () {
     $('.gift,.share').fadeIn("fast")
     }, 400);
     });*/

});

/*关于评论显示的函数*/
function scrollNews() {
    /*获得当前评论个数*/
    var lenLI = $(".dLeft").find("li").length;
    /*获得评论ul下的第一个li*/
    var $firstLi = $(".discuss li:first");
    /*获得评论ul下的第一个li的height --30px*/
    var lineHeightLi = $(".discuss").find("li:first").height();
    /*alert(lineHeightLi);*/
} 