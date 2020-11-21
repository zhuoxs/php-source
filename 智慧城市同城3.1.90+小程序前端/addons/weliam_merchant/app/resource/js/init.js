define(function() {
	if ($('.rollGallerylist').length > 0) {
		require(['rollGallery'], function() {
			$(".rollGallerylist").rollGallery({
				direction: "top",
				speed: 2000,
				showNum: 1,
				speedPx:20
			});
		})
	}
    var imgswiper =null, lgtbox = $('#globalLightbox');
	$(document).on('click', '.imgloading', function () {
	    var that = $(this), imgh = '';
	    if(that.hasClass('view_jump')){
	        return false;
	    }
	    that.parent().find('img').each(function () {
	        imgh += "<div class=\"swiper-slide\"><img src=\""+$(this).attr('src')+"\"></div>";
	    });
	    if(!imgh){
	    	that.parent().find('.imgloading').each(function () {
		        imgh += "<div class=\"swiper-slide\"><img src=\""+$(this).data('bgurl')+"\"></div>";
		    });
	    }
	    $('#globalWrapper').html(imgh);
	    lgtbox.show().removeClass('zoomOut').addClass('zoomIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
	        lgtbox.show();
	    });
	    imgswiper = new Swiper('#globalLightbox', {
	        pagination: '.lightbox-pagination',
	        paginationType: 'fraction',
	        loop: true
	    });
	    imgswiper.slideTo(that.parent().find('.imgloading').index(that)+1,0);
	    return false;
	}), $(document).on('click', '#globalLightbox', function () {
	    lgtbox.removeClass('zoomIn').addClass('zoomOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
	        lgtbox.hide();
	        imgswiper.destroy();
	    });
	    return false;
	}), $(document).on('click', '.locationurl', function () {
	    var jurl = $(this).data('url');
	    if(!jurl){
	    	return false;
	    }
	    if (window.__wxjs_environment === 'miniprogram') {
        	if (jurl.substring(0, 5) == 'http:') {
        		jurl = jurl.replace(/http:/, "https:");
        	}
//      	wx.miniProgram.navigateTo({
//				url: '/wxapp_web/pages/view/index?url=' + encodeURIComponent(jurl)
//			})
//      	return false;
        }
	    location.href = jurl;
	}), $(document).on('click', '.navigation', function () {
	    var lat = $(this).data('lat'), lng = $(this).data('lng'), name = $(this).data('name'), addr = $(this).data('addr'), tel = $(this).data('tel');
	    lat = parseFloat(lat);
	    lng = parseFloat(lng);
	    if(window.sysinfo.inwechat == 'yes'){
			wx.openLocation({
			    latitude: lat, // 纬度，浮点数，范围为90 ~ -90
			    longitude: lng, // 经度，浮点数，范围为180 ~ -180。
			    name: name, // 位置名
			    address: addr, // 地址详情说明
			    scale: 20, // 地图缩放级别,整形值,范围从1~28。默认为最大
			    infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
			});
		} else {
			location.href = "https://apis.map.qq.com/uri/v1/marker?marker=coord:"+ lat +","+ lng +";title:"+ name +";addr:"+ addr +";tel:"+ tel +"&referer=myapp";
		}
	}), $(document).on("click", '[data-toggle="createPopup"]', function(e) {
        e.preventDefault();
        var obj = $(this), confirm = obj.data("confirm");
        var handler = function() {
            $("#ajaxModal").remove(), e.preventDefault();
            var url = obj.data("href") || obj.attr("href"),
                data = obj.data("set"),
                modal;
            $.ajax(url, {
                type: "get",
                dataType: "html",
                cache: false,
                data: data
            }).done(function(html) {
                if (html.substr(0, 8) == '{"status') {
                    json = eval("(" + html + ')');
                    if (json.status == 0) {
                        msg = typeof(json.result) == 'object' ? json.result.message : json.result;
                        tip.msgbox.err(msg || tip.lang.err);
                        return
                    }
                }
                modal = $('<div class="modal fade" id="ajaxModal"><div class="modal-body "></div></div>');
                $(document.body).append(modal), modal.modal('show');
            })
        };
        if (confirm) {
            $.confirm(confirm, handler)
        } else {
            handler()
        }
    });
//	$(document).on('click', 'a', function (e) {
//	    var jurl = $(this).attr("href");
//	    if(!jurl){
//	    	return false;
//	    }
//	    if (window.__wxjs_environment === 'miniprogram') {
//	    	e.preventDefault();
//      	if (jurl.substring(0, 5) == 'http:') {
//      		jurl = jurl.replace(/http:/, "https:");
//      	}
//      	wx.miniProgram.navigateTo({
//				url: '/wxapp_web/pages/view/index?url=' + encodeURIComponent(jurl)
//			})
//      }
//	    return true;
//	});
});
