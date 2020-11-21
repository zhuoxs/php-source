/**
 * jquery paginate - Public Plugin
 * 分页插件
 * 
 * Dependencies:
 * 1、jQuery
 * 2、矢量样式font-awesome-4.7.0
 * 
 * author:Hawk 郁欢欢
 * craate time:2017.5.16
 * change time:2017.6.29
 * 
 * Use:插件初始化
 * $(dom).paginate(JSONObject); 
 * JSONObject为参数，可不传
 * 
 * getData:获取插件绑定数据
 * $(dom).paginate('getData'); 
 * 
 * refresh:更新分页按钮显示
 * $(dom).paginate('refresh',JSONObject); 
 * JSONObject为参数，可不传
 * 
 * refreshPageBtn:更新数字按钮显示
 * $(dom).paginate('refreshPageBtn',JSONObject); 
 * JSONObject为参数，可不传
 **/
(function ($) {	
	var Method = {
		/*插件默认入口*/
		'default':function($container,pluginName,methodName){
			var opts = optHandle.get($container,pluginName);
			if (methodName == 'default'){
				return pagingButton.init($container,pluginName,opts);
			} else {
				if (this[methodName]){
					return this[methodName]($container,pluginName,opts);
				}
			}
		},
		/*获取绑定数据*/
		'getData':function($container,pluginName,opts){
			return opts;
		},
		/*根据绑定数据的变动，改变分页按钮显示*/
		'refresh':function($container,pluginName,opts){
			pagingButton.load($container,opts);
		},
		/*根据绑定数据的变动，改变数字按钮显示*/
		'refreshPageBtn':function($container,pluginName,opts){
			pagingButton.refreshPageBtn($container,opts);
		}
	};
	/*翻页组件*/
	var pagingButton = {
		/*初始化*/
		'init':function($container,pluginName,opts){
			$container.addClass('paginate-containter');
			$container.append('<div class="paginate-box"></div>');
			
			this.action($container,pluginName);
			this.draw($container,opts);
		},
		/*计算页数*/
		'calculatePageLen':function(dataLen,displayDataLen){
			if (displayDataLen <= 0 || dataLen <= 0){
				return 0;
			} else {
				var pageLen = parseInt(dataLen/displayDataLen);
	        	if (dataLen%displayDataLen!=0){pageLen++};
	        	return pageLen;
        	}
    	},
    	/*分页按钮加载*/
    	'load':function($container,opts){
    		this.draw($container,opts);
			/*数字按钮加载*/
			this.numberButtons.change($paginate,opts,this);
    	},
    	/*构造翻页html*/
		'draw':function($container,opts){
			var $paginate = $container.children('.paginate-box');
			var newhtml = '<span class="pagination paginate-num-btn-group"></span>';
			if (opts.type == 'full' || opts.type == 'updown'){
				newhtml = '<a class="paginate-btn prev-btn fa fa-caret-left" title="上一页"></a>' + newhtml
					+ '<a class="paginate-btn next-btn fa fa-caret-right" title="下一页"></a>';
				if (opts.type == 'full'){
					newhtml = '<a class="paginate-btn first-btn fa fa-step-backward" title="首页"></a>'
    					+ newhtml + '<a class="paginate-btn last-btn fa fa-step-forward" title="尾页"></a>';
				}
			}
			if (opts.visibleGo){
				newhtml += '<span class="go-page-box">跳转到：<input type="text" class="go-page-input" /><a class="paginate-btn go-btn end-view-btn">GO</a></span>';
			}
			$paginate.html(newhtml);
		},
		/*数字按钮*/
		'numberButtons':{
			/*数字按钮变动*/
			'change':function($paginate,opts,top){
				var pageData = opts.pageData;
				var currentPage = pageData.currentPage;
				var displayDataLen = pageData.displayDataLen;
				var dataLen = pageData.dataLen;
				var pageLen = top.calculatePageLen(dataLen,displayDataLen);
				var $numBtnsGroup = $paginate.find('.paginate-num-btn-group');
				this.draw($numBtnsGroup,currentPage,pageLen);
				try{
					$paginate.find('input[type="text"].go-page-input').val(currentPage);
				}catch(e){
					//TODO handle the exception
				}
				top.endViewBtn($paginate);
				top.disableButtons($paginate,pageLen,currentPage);
				top.isShow($paginate,pageLen);
				
			},
			/*构造数字按钮*/
			'draw':function($numBtnsGroup,currentPage,pageLen){
				var newhtml = '';
				if (currentPage <= 0){
					/*currentPage小于等于0，不显示当前页按钮，数字按钮从第一页开始，最多显示5页*/
					var btnCount = 1;
					for(var i=1;i<=pageLen;i++) {
						if (btnCount > 5) break;
						newhtml += '<a class="paginate-btn num-btn">' + i + '</a>';
						btnCount ++;
					}
				} else if (currentPage > pageLen) {
					/*currentPage大于pageLen，不显示当前页按钮，数字按钮从最后一页开始倒数，最多显示5页*/
					var btnCount = 1;
					for(var i=pageLen;i>0;i--) {
						if (btnCount > 5) break;
						newhtml += '<a class="paginate-btn num-btn">' + i + '</a>';
						btnCount ++;
					}
				} else {
					newhtml = '<a class="paginate-btn num-btn current-btn">'+currentPage+'</a>';
					var btnCount = 1, startPage = currentPage - 2, bigPage = currentPage, smallPage = currentPage;
					if (startPage < 1) startPage = 1;
					for (var i=currentPage-1;i>=startPage;i--){
						newhtml = '<a class="paginate-btn num-btn">' + i + '</a>' + newhtml;
						smallPage--;
						btnCount++;
					}
					while(btnCount<5){
						bigPage++;
						if (bigPage > pageLen) break;
						newhtml += '<a class="paginate-btn num-btn">' + bigPage + '</a>';
						btnCount++;
					}
					while(btnCount<5){
						smallPage--;
						if (smallPage < 1) break;
						newhtml = '<a class="paginate-btn num-btn">' + smallPage + '</a>' + newhtml;
						btnCount++;
					}
					if (bigPage < pageLen){
						if ((bigPage+1) < pageLen){
							newhtml += '<span class="ellipsis">...</span>';
						} 
						newhtml += '<a class="paginate-btn num-btn">' + pageLen + '</a>';
					}
				}
				$numBtnsGroup.html(newhtml);
			}
		},
		/*翻页按钮样式微调*/
		'endViewBtn':function($paginate){
			$paginate.find('.paginate-btn:not(.go-btn):last').addClass('end-view-btn');
			var $ellipsis = $paginate.find('.ellipsis');
			if ($ellipsis.length = 1){
				$ellipsis.prev().addClass('end-view-btn');
			}
		},
		/*翻页按钮失效*/
		'disableButtons':function($paginate,pageLen,currentPage){
			$paginate.find('.paginate-btn').removeClass('disabled-btn');
			if (currentPage <= 1){
        		$paginate.find('.first-btn,.prev-btn').addClass('disabled-btn');
        	}
			if (currentPage >= pageLen || pageLen <= 0){
        		$paginate.find('.last-btn,.next-btn').addClass('disabled-btn');
        	}
		},
		/*翻页按钮显示*/
		'isShow':function($paginate,pageLen){
			if (pageLen <= 1){
				$paginate.hide();
			} else {
				$paginate.show();
			}
		},
		/*翻页按钮执行事件*/
		'action':function($container,pluginName){
			var that = this;
			var $paginate = $container.children('.paginate-box');
			$paginate.on('click','.paginate-btn',function(){
				if ($(this).hasClass('disabled-btn')) return false;
				var opt = optHandle.get($container,pluginName);
				var pageData = opt.pageData;
				var currentPage = pageData.currentPage;
				var pageLen = that.calculatePageLen(pageData.dataLen,pageData.displayDataLen);
				var goPage;
				if ($(this).hasClass('last-btn')){
					goPage = pageLen;
				} else if ($(this).hasClass('prev-btn')){
					goPage = currentPage - 1;
				} else if ($(this).hasClass('next-btn')){
					goPage = currentPage + 1;
				} else if ($(this).hasClass('num-btn')){
					goPage = parseInt($(this).text());
				} else if ($(this).hasClass('go-btn')){
					goPage = parseInt($(this).prev('input[type=text].go-page-input').val());
				} else {
					goPage = 1;
				}
				if (goPage > 0 && goPage <= pageLen){
					opt.pageBtnFun(goPage);
				}
			});
		},
		'refreshPageBtn':function($container,opts){
			var $paginate = $container.children('.paginate-box');
			this.numberButtons.change($paginate,opts,this);
		}
	};

    /*
	 * 数据处理
	 * $obj：数据绑定的dom元素
	 * pluginName: 插件名称
	 * opt：传入的数据
	 */
   	var optHandle = {
   		'get':function($obj,pluginName){
   			return $obj.data(pluginName);
   		},
   		'set':function($obj,pluginName,opt){
   			var nowOpt = $obj.data(pluginName);
   			var newOpt;
   			if (nowOpt){
   				newOpt = $.extend(true,{},nowOpt, opt);
   			} else {
   				var defaultOpt = $.fn[pluginName].defaults;
   				newOpt = $.extend(true,{},defaultOpt,opt);
   			}
   			$obj.data(pluginName, newOpt);
   		}
   	}
   	/*插件入口*/
    $.fn.paginate = function(options, param) {
    	var pluginName = 'paginate';
		options = options || {};
		var r = [];
		this.each(function(){
			if (typeof options == 'string') {
				if (Method[options]){
					if ((typeof(param) == "object" && Object.prototype.toString.call(param).toLowerCase() == "[object object]" && !param.length) || param == undefined){
						optHandle.set($(this),pluginName,param);
	    				r.push(Method.default($(this),pluginName,options));
					} else {
						r.push(Method[options]($(this),pluginName,param));
					}
				} 
			} else {
				optHandle.set($(this),pluginName,options);
				r.push(Method.default($(this),pluginName,'default'));
			}
		});
		if (r.length == 1) r = r[0];
		return r;
   	};
    /*插件参数*/
    $.fn.paginate.defaults = {
    	'visibleGo': false, /*是否开启直接翻至某页功能*/
    	'type':'numbers', /*默认按钮样式递增（numbers只有数字按钮，updown增加上下页按钮，full增加首尾页按钮）*/
    	/*分页数据信息*/
    	'pageData':{
    		'currentPage': 1, /*当前页码*/ 
    		'dataLen': 10 ,/*数据总条数*/ 
    		'displayDataLen': 10  /*每页显示条数*/
    	},
    	'pageBtnFun':function(){}
    };
})(jQuery);