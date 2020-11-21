$(function($) {
	function openMune() {
		if ($('.ect-nav').is(":visible")) {
			$('.ect-nav').hide();
		} else {
			$('.ect-nav').show();
		}
	}
	var handler = function(e) {
		e.preventDefault();
	};
	if ($(".swiper-scroll").hasClass("swiper-scroll")) {
		var scorll_swiper = new Swiper('.swiper-scroll', {
			scrollbar: '.swiper-scrollbar',
			direction: 'vertical',
			slidesPerView: 'auto',
			mousewheelControl: true,
			freeMode: true
		});
	}

	function d_messages(m_text) {
		//弹出消息
		$(".div-messages").text(m_text);
		m_marginLeft = $(".div-messages").innerWidth() / 2;
		$(".div-messages").css("margin-left", -m_marginLeft);
		if (!$(".div-messages").hasClass()) {
			$(".div-messages").addClass("active");
		}
		setTimeout(function() {
			$(".div-messages").removeClass("active");
		}, 3000);
	}
	/*判断文本框是否有值显示隐藏清空按钮*/
	var input_texts = $(".j-input-text");
	var is_nulls = $(".j-text-all").find(".j-is-null");
	var is_yanjing = $(".j-text-all").find(".j-yanjing");
	input_texts.bind('focus', function() {
		is_nulls.removeClass('active');
		//$(this).parents(".j-text-all").addClass("active").siblings().removeClass("active");//开启后 文本框获得焦点即可改变下边框颜色
		if ($(this).val() != "") {
			$(this).siblings('.j-is-null').addClass('active');
		}
	});
	input_texts.bind('input', function() {
		if ($(this).val() == "") {
			$(this).siblings('.j-is-null').removeClass('active');
		} else {
			$(this).siblings('.j-is-null').addClass('active');
		}
	});

	/*点击清空标签文本框内容删*/
	is_nulls.click(function() {
		$(this).siblings(".j-input-text").val("");
		$(this).siblings(".j-input-text").focus();
	});
	/*密码框点击切换普通文本*/
	is_yanjing.click(function() {
		input_text_atr = $(this).siblings(".input-text").find(".j-input-text");
		if (input_text_atr.attr("type") == "password" && $(this).hasClass("disabled")) {
			input_text_atr.attr("type", "text");
		} else {
			input_text_atr.attr("type", "password");
		}
		input_text_atr.focus();
		$(this).toggleClass("disabled");
	});
	/*三种模式商品列表切换*/
	var sequence = ["icon-icon-square", "icon-pailie", "icon-viewlist"];
	var p_l_product = ["product-list-big", "product-list-medium", "product-list-small"];
	$(".j-a-sequence").click(function() {
		var icon_sequence = $(this).find("i").attr("data");
		var len = sequence.length;
		var key = icon_sequence;
		icon_sequence++;
		if (icon_sequence >= len) {
			icon_sequence = 0;
		}
		/*更换排序列表图标class*/
		$(this).find(".iconfont").removeClass(sequence[key]).addClass(sequence[icon_sequence]);
		$(this).find(".iconfont").attr("data", icon_sequence);
		/*更换商品列表class*/
		$(".j-product-list").removeClass(p_l_product[key]).addClass(p_l_product[icon_sequence]);
		$(".j-product-list").attr("data", icon_sequence);
	});
	/*搜索店铺商品切换*/
	$(".j-search-check").click(function() {
		if ($(this).attr("data") == 1) {
			$(this).attr("data", 2);
			$(this).find("span").html("商品");
		} else {
			$(this).attr("data", 1);
			$(this).find("span").html("店铺");
		}
	});

	/*点击筛选弹出层*/
	$(".j-s-filter").click(function() {
		$("body").addClass("show-filter-div");
	});
	/*点击关闭筛选弹出层*/
	$(".j-close-filter-div").click(function() {
		if ($("body").hasClass("show-city-div")) {
			$("body").removeClass("show-city-div");
			return false;
		}
		$("body").removeClass("show-filter-div");
	});
	/*点击切换*/
	$(".j-radio-switching").click(function() {
		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(this).attr("data", 0);
		} else {
			$(this).addClass("active");
			$(this).attr("data", 1);
		}
	});
	/*手风琴下拉效果*/
	$(".j-sub-menu").hide();
	$(".j-menu-select").click(function() {
		$(this).next(".j-sub-menu").slideToggle().siblings('.j-sub-menu').slideUp();
		$(this).toggleClass("active").siblings().removeClass("active");
	});
	/*多选并限制个数  －  ［商品筛选将值传给em标签］  */
	$(".j-get-limit .ect-select").not(".j-checkbox-all").click(function() {
		get_text = $(this).parents(".j-get-limit");
		s_t_em_value = get_text.prev(".select-title").find(".t-jiantou em"); //获取需要改变值的em标签
		checked = $(this).find("label").hasClass("active");
		ischecked = $(this).parents(".j-get-limit").attr("data-istrue");
		var s_t_em_text = "",
			s_get_label_num = 0;
		var active_jiantou = get_text.prev(".j-menu-select").find(".j-t-jiantou");
		active_jiantou.addClass("active");
		if (get_text.find(".j-checkbox-all label").hasClass("active")) { //当点击非j-checkbox-all的时候删除其选中状态
			get_text.find(".j-checkbox-all label").removeClass("active");
		}
		if (ischecked == "true") {
			$(this).find("label").toggleClass("active");
		}
		if (checked) {
			$(this).find("label").removeClass("active");
			$(this).parents(".j-get-limit").attr("data-istrue", "true")
		}
		if (ischecked == "false") {
			d_messages("筛选最多不能超过5个");
		}
		s_get_label = get_text.find("label.active"); //获取被选中label
		s_get_label_num = s_get_label.length;
		if (s_get_label_num <= 0) {
			active_jiantou.removeClass("active");
			$(".j-checkbox-all label").addClass("active");
			s_t_em_text = $(this).siblings(".j-checkbox-all").find("label").text() + "、";
		}
		if (s_get_label_num >= 5) {
			$(this).parents(".j-get-limit").attr("data-istrue", "false")
		} else {
			$(".div-messages").removeClass("active");
			$(this).parents(".j-get-limit").attr("data-istrue", "true")
		}
		s_get_label.each(function() {
			s_t_em_text += $(this).text() + "、";
		});
		s_t_em_value.text(s_t_em_text.substring(0, s_t_em_text.length - 1));

	});
	$(".j-checkbox-all").click(function() {
		checkbox_all = $(this).find("label"); //获取值为“全部”的label
		s_t_em_value = $(this).parent().prev(".select-title").find(".t-jiantou em"); //获取需要改变值的em标签
		checkbox_all_text = $(this).find("label").text();
		if (!checkbox_all.hasClass("active")) {
			$(this).find("label").addClass("active").parents(".ect-select").siblings().find("label").removeClass("active");
			s_t_em_value.text(checkbox_all_text); //将calss为j-checkbox-all的label的值赋值给需要改变的em标签
			$(this).parent(".j-get-limit").prev(".select-title").find(".t-jiantou").removeClass("active");
			$(this).parents(".j-get-limit").attr("data-istrue", "true")
		}
	});
	/*筛选按钮中清空选项*/
	$(".j-filter-reset").click(function() {
		$(".con-filter-div label").removeClass("active");
		$(".j-checkbox-all label").addClass("active");
		$(".j-radio-switching").removeClass("active");
		$(".j-menu-select .j-t-jiantou").removeClass("active");
		$(".j-menu-select .j-t-jiantou em").text("全部");
		$(".j-filter-city span.text-all-span").css("color", "#555");
		$(".j-filter-city span.text-all-span").text("请选择");
		$(".div-messages").removeClass("active");

		$(this).parents(".j-get-limit").attr("data-istrue", true)
	});
	/*多选*/
	$(".j-get-more .ect-select").click(function() {

		if (!$(this).find("label").hasClass("active")) {
			$(this).find("label").addClass("active");
			if ($(this).find("label").hasClass("label-all")) {
				$(".j-select-all").find(".ect-select label").addClass("active");
			}
		} else {
			$(this).find("label").removeClass("active");
			if ($(this).find("label").hasClass("label-all")) {
				$(".j-select-all").find(".ect-select label").removeClass("active");
			}
		}
	});
	/*多选只点击单选按钮 - 全选，全不选*/
	$(".j-get-i-more .j-select-btn").click(function() {
		if ($(this).parents(".ect-select").hasClass("j-flowcoupon-select-disab")) {
			d_messages("同商家只能选择一个");
		} else {
			is_select_all = true;
			if ($(this).parent("label").hasClass("label-this-all")) {
				if (!$(this).parent("label").hasClass("active")) {
					$(this).parents(".j-get-i-more").find(".ect-select label").addClass("active");
				} else {
					$(this).parents(".j-get-i-more").find(".ect-select label").removeClass("active");
				}
			}

			if (!$(this).parent("label").hasClass("label-this-all") && !$(this).parent("label").hasClass("label-all")) {
				$(this).parent("label").toggleClass("active");
				is_select_this_all = true;
				select_this_all = $(this).parents(".j-get-i-more").find(".ect-select label").not(".label-this-all");

				select_this_all.each(function() {
					if (!$(this).hasClass("active")) {
						is_select_this_all = false;
						return false;
					}
				})
				if (is_select_this_all) {
					$(this).parents(".j-get-i-more").find(".label-this-all").addClass("active");
				} else {
					$(this).parents(".j-get-i-more").find(".label-this-all").removeClass("active");
				}
			}

			var select_all = $(".j-select-all").find(".ect-select label");
			select_all.each(function() {
				if (!$(this).hasClass("active")) {
					is_select_all = false;
					return false;
				}
			});
			if (is_select_all) {
				$(".label-all").addClass("active");
			} else {
				$(".label-all").removeClass("active");
			}
		}
	});


	/*单选*/
	$(".j-get-one .ect-select").click(function() {
		get_tjiantou = $(this).parent(".j-get-one").prev(".select-title").find(".t-jiantou");
		$(this).find("label").addClass("active").parent(".ect-select").siblings().find("label").removeClass("active");
		get_tjiantou.find("em").text($(this).find("label").text());
		if ($(this).hasClass("j-checkbox-all")) {
			get_tjiantou.removeClass("active");
		} else {
			get_tjiantou.addClass("active");
		}
		if ($(this).parents("show-goods-attr")) { //赋值给goods-attr
			s_get_label = $(".show-goods-attr .s-g-attr-con").find("label.active"); //获取被选中label
			var get_text = '';
			s_get_label.each(function() {
				get_text += $(this).text() + "、";
			});
			$(".j-goods-attr").find(".t-goods1").text(get_text.substring(0, get_text.length - 1));
		}
	});
	/*单选consignee*/
	$(".j-get-consignee-one label").click(function() {
		$(this).addClass("active").parents(".flow-checkout-adr").siblings().find("label").removeClass("active");
	});
	/*城市筛选单选city*/
	$(".j-filter-city").click(function() {
		$("body").addClass("show-city-div");
	});

	$(".j-get-city-one .ect-select").click(function() {
		city_span = $(".j-filter-city span.text-all-span");
		city_txt = $(".j-city-left li.active").text() + " " + $(this).parents(".j-sub-menu").prev(".j-menu-select").find("label").text() + " " + $(this).find("label").text();
		$(".j-get-city-one").find(".ect-select label").removeClass("active");
		$(this).find("label").addClass("active");
		city_span.text(city_txt);
		if ($(".j-filter-city span.text-all-span").hasClass("j-city-scolor")) {
			$(".j-filter-city span.text-all-span").css("color", "#1CBB7F");
		}
		$("body").removeClass("show-city-div");
	});

	/*订单提交页面单选赋值*/
	$(".s-g-list-con .j-get-one .ect-select").click(function() {
		dist_span = $(this).find("span").text();
		dist_em = $(this).find("em").text();
		if ($(this).parents(".j-show-goods-text").hasClass("show-time-con")) {
			$(this).parents(".j-show-goods-text").siblings(".distribution-time").find(".d-time-date").text(dist_span);
		} else {
			$(this).parents(".j-show-goods-text").siblings(".j-goods-dist").find(".t-goods1 span").text(dist_span);
			$(this).parents(".j-show-goods-text").siblings(".j-goods-dist").find(".t-goods1 em").text(dist_em);
		}
	});

	/*商品详情 红心*/
	//	$(".j-heart").click(function() {
	//		$(this).toggleClass("active");
	//	});
	/*点击弹出搜索层*/
	$(".j-search-input").click(function() {
		$("body").addClass("show-search-div");
		$(".search-div").css("z-index","999999");
		//$('input[name="keywords"]').focus()
	});
	/*关闭搜索层*/
	$(".j-close-search").click(function() {
		$("body").removeClass("show-search-div");
	});

	/*弹出配送方式*/
	$(".j-goods-dist").click(function() {
		document.addEventListener("touchmove", handler, false);
		$("body").addClass("show-dist-div");
	});

	/*弹出商品属性*/
	$(".j-goods-attr").on("click", function() {
		document.addEventListener("touchmove", handler, false);
		$("body").addClass("show-attr-div");
	});
	//弹出优惠券
	$(".j-goods-coupon").click(function() {
		document.addEventListener("touchmove", handler, false);
		$("body").addClass("show-coupon-div");
	});
	//弹出服务说明
	$(".j-goods-service i.goods-min-icon").click(function() {
		document.addEventListener("touchmove", handler, false);
		$("body").addClass("show-service-div");
	});
	/*时间选择弹出层*/
	$(".j-distribution-time-con").click(function() {
		document.addEventListener("touchmove", handler, false);
		$("body").addClass("show-time-div");
	});
	/*关闭商品详情弹出层*/
	$(".mask-filter-div,.show-div-guanbi").click(function() {
		document.removeEventListener("touchmove", handler, false);
		if ($("body").hasClass("show-attr-div")) {
			$("body").removeClass("show-attr-div");
			return false;
		}
		if ($("body").hasClass("show-coupon-div")) {
			$("body").removeClass("show-coupon-div");
			return false;
		}
		if ($("body").hasClass("show-service-div")) {
			$("body").removeClass("show-service-div");
			return false;
		}
		if ($("body").hasClass("show-dist-div")) {
			$("body").removeClass("show-dist-div");
			return false;
		}
		if ($("body").hasClass("show-time-div")) {
			$("body").removeClass("show-time-div");
			return false;
		}
	});
	/*购物车点击展开优惠说明*/
	$(".flow-have-cart .j-icon-show").click(function() {
			$(this).parents(".g-promotion-con").toggleClass("active");
		})
		/*购物车悬浮按钮编辑状态*/
	$(".f-cart-filter-btn .span-bianji").click(function() {
		$(".f-cart-filter-btn").addClass("active");
	})
	$(".f-cart-filter-btn .j-btn-default").click(function() {
		$(".f-cart-filter-btn").removeClass("active");
	})

	/*数字增减*/
	$(".div-num-disabled").find("input").attr("readonly", true);
	$(".div-num a").click(function() {
		if (!$(this).parent(".div-num").hasClass("div-num-disabled")) {
			if ($(this).hasClass("num-less")) {
				num = parseInt($(this).siblings("input").val());
				min_num = parseInt($(this).attr("data-min-num"));
				if (num > min_num) {
					num -= 1;
					$(this).siblings("input").val(num);
				} else {
					d_messages("不能小于最小数量");
				}
				return false;
			}
			if ($(this).hasClass("num-plus")) {
				num = parseInt($(this).siblings("input").val());
				max_num = parseInt($(this).attr("data-max-num"));
				if (num < max_num) {
					num += 1;
					$(this).siblings("input").val(num);
				} else {
					d_messages("不能大超过最大数量");
				}
				return false;
			}
		} else {
			d_messages("该商品不能增减");
		}
	});
	$(".div-num input").bind("change", function() {
		num = parseInt($(this).val());
		max_num = parseInt($(this).siblings(".num-plus").attr("data-max-num"));
		min_num = parseInt($(this).siblings(".num-less").attr("data-min-num"));
		if (num > max_num) {
			$(this).val(max_num);
			d_messages("不能大超过最大数量");
			return false;
		}
		if (num < min_num) {
			$(this).val(min_num);
			d_messages("不能小于最小数量");
			return false;
		}
	});

	/*订单提交页*/
	$(".flow-checkout-pro span.t-jiantou").click(function() {
			$(this).parents(".flow-checkout-pro").toggleClass("active");
		})
		/*文本框获得焦点下拉*/
	$(".text-all-select .j-input-text").focus(function() {
		$(this).parents(".text-all-select").find(".text-all-select-div").show();
	});
	$(".text-all-select-div li").click(function() {

		text_select = $(this).text();
		$(this).parents(".text-all-select").find(".j-input-text").val(text_select);
		$(this).parents(".text-all-select").find(".text-all-select-div").hide();
		return false;
	});
	/*悬浮菜单点击显示*/
	$(".filter-menu-title").click(function() {
		$(".filter-menu").toggleClass("active");
	});
	/*页面向上滚动js*/
	var prevTop = 0,
		currTop = 0;
	$(window).scroll(function() {
		currTop = $(window).scrollTop();
		if (currTop < prevTop) { //判断小于则为向上滚动
			$(".filter-top,.filter-menu").fadeIn(300);
		} else {
			$(".filter-top,.filter-menu").fadeOut(300);
		}
		//prevTop = currTop; //IE下有BUG，所以用以下方式
		setTimeout(function() {
			prevTop = currTop
		}, 0);
	});

})

$(function() {
	$('#loading').hide();
})

$(function(){
	$(".del").click(function(){
		if(!confirm('您确定要删除吗？')){
			return false;
		}					
		var url = 'index.php?m=default&c=user&a=clear_history';
		$.get(url, '', function(data){
			if(1 == data.status){
				location.reload();
				
			}
			else{
				alert("删除失败");
			}
		}, 'json');
		return false;
	});
})