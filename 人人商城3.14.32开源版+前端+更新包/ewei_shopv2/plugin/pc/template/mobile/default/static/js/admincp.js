// JavaScript Document  v3-b12


//自定义radio样式
$(document).ready( function(){ 
	$(".cb-enable").click(function(){
		var parent = $(this).parents('.onoff');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents('.onoff');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});
		//操作提示缩放动画 
    $("#checkZoom").toggle(
        function() {
            $("#explanation").animate({
                color: "#FFF",
                backgroundColor: "#4FD6BE",             
                width: "80",
                height: "20",				              
            },300);
            $("#explanationZoom").hide();
        },
        function() {
            $("#explanation").animate({
                color: "#2CBCA3",
                backgroundColor: "#EDFBF8",
                width: "99%",
                height: "20",
            },300,function() {
                $(this).css('height', '100%');
            });
            $("#explanationZoom").show();
        }
    );
});


//图片比例缩放控制
function DrawImage(ImgD, FitWidth, FitHeight) {
	var image = new Image();
	image.src = ImgD.src;
	if (image.width > 0 && image.height > 0) {
		if (image.width / image.height >= FitWidth / FitHeight) {
			if (image.width > FitWidth) {
				ImgD.width = FitWidth;
				ImgD.height = (image.height * FitWidth) / image.width;
			} else {
				ImgD.width = image.width;
				ImgD.height = image.height;
			}
		} else {
			if (image.height > FitHeight) {
				ImgD.height = FitHeight;
				ImgD.width = (image.width * FitHeight) / image.height;
			} else {
				ImgD.width = image.width;
				ImgD.height = image.height;
			}
		}
	}
} 
	

$(function(){
	// 显示隐藏预览图 start
	$('.show_image').hover(
		function(){
			$(this).next().css('display','block');
		},
		function(){
			$(this).next().css('display','none');
		}
	);
	
	// 全选 start
	$('.checkall').click(function(){
		$('.checkall').attr('checked',$(this).attr('checked') == 'checked');
		$('.checkitem').each(function(){
			$(this).attr('checked',$('.checkall').attr('checked') == 'checked');
		});
	});

	// 表格鼠标悬停变色 start
	$("tbody tr").hover(
    function(){
        $(this).css({background:"#FBFBFB"} );
    },
    function(){
        $(this).css({background:"#FFF"} );
    });

	// 可编辑列（input）变色
	$('.editable').hover(
		function(){
			$(this).removeClass('editable').addClass('editable2');
		},
		function(){
			$(this).removeClass('editable2').addClass('editable');
		}
	);
	
	// 提示操作 展开与隐藏
	$("#prompt tr:odd").addClass("odd");
	$("#prompt tr:not(.odd)").hide();
	$("#prompt tr:first-child").show();
		
	$("#prompt tr.odd").click(function(){
		$(this).next("tr").toggle();
		$(this).find(".title").toggleClass("ac");
		$(this).find(".arrow").toggleClass("up");
		
	});

	// 可编辑列（area）变色
	$('.editable-tarea').hover(
		function(){
			$(this).removeClass('editable-tarea').addClass('editable-tarea2');
		},
		function(){
			$(this).removeClass('editable-tarea2').addClass('editable-tarea');
		}
	);

});

/* 火狐下取本地全路径 */
function getFullPath(obj)
{
    if(obj)
    {
        // ie
        if (window.navigator.userAgent.indexOf("MSIE")>=1)
        {
            obj.select();
            if(window.navigator.userAgent.indexOf("MSIE") == 25){
            	obj.blur();
            }
            return document.selection.createRange().text;
        }
        // firefox
        else if(window.navigator.userAgent.indexOf("Firefox")>=1)
        {
            if(obj.files)
            {
                //return obj.files.item(0).getAsDataURL();
            	return window.URL.createObjectURL(obj.files.item(0)); 
            }
            return obj.value;
        }
        return obj.value;
    }
}

/* AJAX选择品牌 */
(function($) {
	$.fn.brandinit = function(options){
		var brand_container = $(this);
		//根据首字母查询
		$(this).find('.letter[nctype="letter"]').find('a[data-letter]').click(function(){
			var _url = $(this).parents('.brand-index:first').attr('data-url');
			var _letter = $(this).attr('data-letter');
			var _search = $(this).html();
			$.getJSON(_url, {type : 'letter', letter : _letter}, function(data){
				$(brand_container).insertBrand({param:data,search:_search});
			});
		});
		// 根据关键字查询
		$(this).find('.search[nctype="search"]').find('a').click(function(){
			var _url = $(this).parents('.brand-index:first').attr('data-url');
			var _keyword = $('#search_brand_keyword').val();
			$.getJSON(_url, {type : 'keyword', keyword : _keyword}, function(data){
				$(brand_container).insertBrand({param:data,search:_keyword});
			});
		});
		// 选择品牌
		$(this).find('ul[nctype="brand_list"]').on('click', 'li', function(){
			$('#b_id').val($(this).attr('data-id'));
			$('#b_name').val($(this).attr('data-name'));
		});
		//搜索品牌列表滚条绑定
		$(this).find('div[nctype="brandList"]').perfectScrollbar();
	}
	$.fn.insertBrand = function(options) {
		//品牌搜索容器
		var dataContainer = $(this);
		$(dataContainer).find('div[nctype="brandList"]').show();
		$(dataContainer).find('div[nctype="noBrandList"]').hide();
		var _ul = $(dataContainer).find('ul[nctype="brand_list"]');
		_ul.html('');
		if ($.isEmptyObject(options.param)) {
			$(dataContainer).find('div[nctype="brandList"]').hide();
			$(dataContainer).find('div[nctype="noBrandList"]').show().find('strong').html(options.search);
			return false;
		}
		$.each(options.param, function(i, n){
			$('<li data-id="' + n.brand_id + '" data-name="' + n.brand_name + '"><em>' + n.brand_initial + '</em>' + n.brand_name + '</li>').appendTo(_ul);
		});

		//搜索品牌列表滚条绑定
		$(dataContainer).find('div[nctype="brandList"]').perfectScrollbar('update');
    };
})(jQuery);