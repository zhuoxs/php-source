/**
 * jquery yhhDataTable - Public Plugin
 * 数据表格插件
 * 
 * Dependencies:
 * 1、jQuery
 * 2、矢量样式font-awesome-4.7.0
 * 3、jquery.paginate分页插件
 * 
 * author:Hawk 郁欢欢
 * craate time:2017.7.3
 * 
 * Use:插件初始化
 * $(dom).yhhDataTable(JSONObject); 
 * JSONObject为参数，可不传
 **/
(function ($) {
	var Method = {
		/*插件默认入口*/
		'default':function($container,pluginName,methodName){
			var opts = optHandle.get($container,pluginName);
			if (methodName == 'default'){
				return yhhDataTable.init($container,pluginName,opts);
			} else {
				if (this[methodName]){
					return this[methodName]($container,pluginName,opts);
				}
			}
		},
		/*更新绑定数据*/
		'update':function($container,pluginName,opts){
		},
		/*获取绑定数据*/
		'getData':function($container,pluginName,opts){
			return opts;
		},
		/*根据绑定数据的变动，更新表格数据（不更新表格显示形式）*/
		'refresh':function($container,pluginName,opts){
			yhhDataTable.refresh($container,pluginName);
		}
	};
	
	var yhhDataTable = {
		'init':function($table,pluginName,opts){
			$table.addClass('yhh-data-table').wrap('<div class="yhh-data-table-frame"></div>');
			var $frame = $table.parent('.yhh-data-table-frame');
    		var $tbody = $table.children('tbody');
    		
    		/*如果用户可变更每页显示条数*/
    		if (opts.paginate.enabled && opts.paginate.changeDisplayLen){
    			/*构造表格上部位置栏*/
    			this.topBox.draw($frame);
    			/*取得表格上部位置栏*/
    			var $topBox = $frame.children('.data-table-top-box');
    			/*改变每页显示数目区域创建*/  				
				this.changeDisplayLen.draw($topBox,opts.paginate.displayLen,opts.paginate.displayLenMenu);
    			var $change = $topBox.children('.per-length-box');
    			$change.find('.sel-list').hide();
    			/*改变每页显示数目功能事件绑定*/
    			this.changeDisplayLen.action($frame,$change,$table,$tbody,pluginName,this);
    		}
    		
    		/*如果显示表格信息 或 开启分页功能*/
    		if (opts.showInfo || opts.paginate.enabled) {
    			/*构造表格下部位置栏*/
    			this.bottomBox.draw($frame);
    			/*取得表格下部位置栏*/
    			var $bottomBox = $frame.find('.tfoot-control').children('.data-table-bottom-box');
    			/*如果显示表格数据信息*/
    			if (opts.showInfo) {
    				this.info.draw($bottomBox);
    			}
    			
    			/*如果开启分页功能*/
    			if (opts.paginate.enabled) {
    				/*调用分页插件，分页插件初始化*/
    				this.paginate.init($frame,$table,$tbody,$bottomBox,pluginName,opts,this);
    			}
    			
    		}
    		
    		/*数据表格hover效果*/
    		if (opts.tbodyRow.hover){
    			this.tbody.row.hover($tbody);
    		}
    		/*数据表选中高亮行*/
    		if (opts.tbodyRow.selected){
    			this.tbody.row.selected($tbody);
    		}
    		
    		this.view($frame,$table,$tbody,pluginName,true);
		},
		'calculate':{
    		/*根据数据长度，每页显示数目，计算总共分成多少页*/
    		'pageLen':function(dataLen,displayDataLen){
    			if (displayDataLen <= 0){
					return 0;
				} else {
					var pageLen = parseInt(dataLen/displayDataLen);
		        	if (dataLen%displayDataLen!=0){pageLen++};
		        	if (pageLen <0) pageLen = 0;
		        	return pageLen;
	        	}
    		},
    		/*计算每页显示数据的开始条数序号*/
    		'displayDataStart':function(displayDataLen,currentPage,dataLen){
    			var r = ((currentPage - 1) * displayDataLen) + 1;
    			if (dataLen <= 0 || r < 0) r = 0;
    			return r;
    		},
    		/*计算每页显示数据的结束条数序号*/
    		'displayDataEnd':function(displayDataLen,currentPage,dataLen){
    			var r = currentPage * displayDataLen;
    			if (dataLen <= 0 || r < 0) r = 0;
    			if (r > dataLen) r = dataLen;
    			return r;
    		}
    	},
		/*表格上部位置栏*/
		'topBox':{
			/*构造表格上部位置栏*/
    		'draw':function($frame){
    			$frame.append('<div class="data-table-top-box"></div>');
    		}
    	},
    	/*表格下部位置栏*/
    	'bottomBox':{
    		/*构造表格下部位置栏*/
    		'draw':function($frame){
					// $frame.append('<div class="data-table-bottom-box"></div>');
					$frame.find('.tfoot-control').append('<div class="pull-right data-table-bottom-box page-box"></div>')
    		}
    	},
    	/*表格tbody模块*/
    	'tbody':{
    		/*表格数据直接在html的时候，开启分页功能，表格的显示*/
    		'show':function($tbody,startLen,endLen){
    			$tbody.children('tr').show();
	    		$tbody.children('tr:lt('+(startLen-1)+')').hide();
	    		$tbody.children('tr:gt('+(endLen-1)+')').hide();
    		},
    		/*构造表格tbody*/
    		'draw':function($tbody,d,startNo,endNo,writeRow){
    			var newhtml = '';
    			for (var i=startNo-1;i<endNo;i++){
	        		newhtml += writeRow(d[i]);
	        	}
				$tbody.html(newhtml);
    		},
    		/*表格tbody中的行*/
    		 'row':{
    		 	/*表格斑马行功能*/
    		 	'zebra':function($tbody){
    		 		$tbody.children('tr:odd').addClass('even');
        			$tbody.children('tr:even').addClass('odd');
    		 	},
    		 	/*表格每行的hover效果*/
    		 	'hover':function($tbody){
    		 		$tbody.on('mouseenter','td',function(){
						$(this).parent().addClass('hover-row');
					});
					$tbody.on('mouseleave','td',function(){
						$(this).parent().removeClass('hover-row');
					});
    		 	},
    		 	'selected':function($tbody){
    		 		$tbody.on('click','td',function(){
						$tbody.children('tr').removeClass('selected-row');
						$(this).parent().addClass('selected-row');
					});
    		 	}
    		 }
    	},
    	/*改变每页显示功能模块*/
    	'changeDisplayLen':{
    		/*构造每页显示功能组件*/
    		'draw':function($topBox,displayLen,displayLenMenu){
    			var newhtml = '<div class="per-length-box"><label>每页显示：</label>'
    				+ '<dl class="per-length-select"><dt class="sel-choosen-box">'
    				+ '<span class="val">' + displayLen + '</span>'
    				+ '<i class="sel-icon fa fa-caret-down"></i></dt>'
    				+ '<dd class="sel-list">';
    			$.each(displayLenMenu, function(i,val) {
    				newhtml += '<a class="sel-option">' + val + '</a>';
    			});
    			newhtml += '</dd></dl></div>';
    			$topBox.append(newhtml);
    			$topBox.children('.per-length-box').find('.sel-option:last').addClass('last-option');
    		},
    		'action':function($frame,$change,$table,$tbody,pluginName,top){
    			var $choosen = $change.find('dt.sel-choosen-box');
    			var $list = $change.find('dd.sel-list');
    			var that = this;
    			$choosen.click(function(e){
    				if ($(this).hasClass('expand')){
    					that.contract($choosen,$list);
    				} else {
    					that.expand($choosen,$list);
    				}
    				e.stopPropagation();
    			});
    			$frame.click(function(){
    				if ($choosen.hasClass('expand')){
    					that.contract($choosen,$list);
    				}
    			});
    			$list.on('click','a.sel-option',function(e){
    				that.select($frame,$(this),$choosen,$table,$tbody,pluginName,top);
    				that.contract($choosen,$list);
    				e.stopPropagation();
    			});
    		},
    		'expand':function($choosen,$list){
    			$list.addClass('expand').slideDown(200);
    			$choosen.addClass('expand')
    				.children('i.sel-icon')
    				.removeClass('fa-caret-down')
    				.addClass('fa-caret-up');
    		},
    		'contract':function($choosen,$list){
    			$list.removeClass('expand').slideUp(200);
    			$choosen.removeClass('expand')
    				.children('i.sel-icon')
    				.removeClass('fa-caret-up')
    				.addClass('fa-caret-down');
    		},
    		'select':function($frame,$selected,$choosen,$table,$tbody,pluginName,top){
    			var selected = parseInt($selected.text());
    			$choosen.children('.val').text(selected);
    			var opt = optHandle.get($table,pluginName);
				opt.paginate.displayLen = selected;
				opt.paginate.currentPage = 1;
				optHandle.set($table,pluginName,opt);
				top.view($frame,$table,$tbody,pluginName,false);
    		}
    	},
    	/*显示数据信息模块*/
    	'info':{
    		/*构造显示数据信息栏*/
    		'draw':function($bottomBox){
    			var newhtml = '<div class="info-box">显示'
	        		+ '<span class="start-show-num info-num"></span>到'
	        		+ '<span class="end-show-num info-num"></span>项，共'
	        		+ '<span class="total-num info-num"></span>项</div>';
	        	$bottomBox.prepend(newhtml);
    		},
    		/*设置信息栏的数字*/
    		'set':function($info,startLen,endLen,totalLen){
    			$info.children('.start-show-num').text(startLen);
	        	$info.children('.end-show-num').text(endLen);
	        	$info.children('.total-num').text(totalLen);
    		}
    	},
    	/*分页功能模块*/
    	'paginate':{
    		'init':function($frame,$table,$tbody,$paginateFrame,pluginName,opts,top){
    			$paginateFrame.paginate({
					'visibleGo':opts.paginate.visibleGo,
					'type':opts.paginate.type,
					'pageBtnFun':function(page){
						var cOpts = optHandle.get($table,pluginName);
						cOpts.paginate.currentPage = page;
						optHandle.set($table,pluginName,cOpts);
						top.view($frame,$table,$tbody,pluginName,false);
					}
				});
    		},
    		'refresh':function($paginateFrame,opts,dataLen){
    			$paginateFrame.paginate('refreshPageBtn',{
					'pageData':{
						'currentPage': opts.paginate.currentPage,
						'dataLen': dataLen,
						'displayDataLen':opts.paginate.displayLen
					}
				});
    		}
    	},
    	/*显示渲染*/
    	'view':function($frame,$table,$tbody,pluginName,isStart){
    		var opts = optHandle.get($table,pluginName);
    		console.log('yhhDataTable param:'+JSON.stringify(opts));
    		opts.beforeShow();
    		
    		var that = this;
    		if (opts.tbodyData.enabled){
    			that.change($frame,$table,$tbody,'1',opts,pluginName,isStart);
    		} else if (opts.serverSide) {
    			that.ajax(opts,function(d){
    				that.change($frame,$table,$tbody,'2',opts,pluginName,isStart,d);
    			});
    		} else{
    			that.change($frame,$table,$tbody,'0',opts,pluginName,isStart);
    		}

    	},
    	'change':function($frame,$table,$tbody,dataSourceType,opts,pluginName,isStart,ajaxBack){
    		var data = [], dataLen = 0, ajaxBackData = null, ajaxListData = [];
    		if (dataSourceType == '1') {
    			/*前端json数据源*/
    			data = opts.backDataHandle(opts.tbodyData.source);
    			dataLen = data.length;
    		} else if (dataSourceType == '2') {
    			/*后端serverSide数据源*/
    			ajaxBack = opts.backDataHandle(ajaxBack);
    			ajaxBack = $.extend({},$.fn[pluginName].defaults.ajaxBack.defaults, ajaxBack);
    			if ($.isEmptyObject(ajaxBack)){
    				opts.errFlag = true;
    			} else {
    				opts.errFlag = ajaxBack.errFlag;
    				opts.errMsg = ajaxBack.errMsg;
    				dataLen = ajaxBack.dataLen;
    				ajaxListData = ajaxBack.data;
    				ajaxBackData = ajaxBack.origData;
    			}
    		} else {
    			/*html数据源*/
    			dataLen = $tbody.children('tr').length;
    		}
    		
    		var currentPage = opts.paginate.currentPage;
    		var displayDataLen = opts.paginate.displayLen;
    		var startNo,endNo,pageLen;
    		if (opts.paginate.enabled){
				startNo = this.calculate.displayDataStart(displayDataLen,currentPage,dataLen);
				endNo = this.calculate.displayDataEnd(displayDataLen,currentPage,dataLen);
			} else {
				startNo = 1; endNo = dataLen;
			}
			if (dataLen <= 0){
				startNo = 0; endNo = 0;
			}
			
			if (dataSourceType == '1') {
    			/*前端json数据源*/
    			/*构造tbody*/
    			this.tbody.draw($tbody,data,startNo,endNo,opts.tbodyRow.write);
    			/*数据表格奇偶行*/
				if (opts.tbodyRow.zebra){
					this.tbody.row.zebra($tbody);
				}
    		} else if (dataSourceType == '2') {
    			/*后端serverSide数据源*/
    			/*构造tbody*/
				this.tbody.draw($tbody,ajaxListData,1,ajaxListData.length,opts.tbodyRow.write);
				/*数据表格奇偶行*/
				if (opts.tbodyRow.zebra){
					this.tbody.row.zebra($tbody);
				}
    		} else {
    			/*html数据源*/
    			this.tbody.show($tbody,startNo,endNo);
    			/*数据表格奇偶行*/
    			if (isStart && opts.tbodyRow.zebra){
    				this.tbody.row.zebra($tbody);
    			}
    		}
    		
    		/*数据信息显示内容*/
			if (opts.showInfo){
    			var $info = $frame.find('.tfoot-control').children('.data-table-bottom-box').children('.info-box');
    			this.info.set($info,startNo,endNo,dataLen);
    		}
			/*分页按钮*/
			if (opts.paginate.enabled){
				this.paginate.refresh($frame.find('.tfoot-control').children('.data-table-bottom-box'),opts,dataLen);
			}
			
			opts.afterShow(opts.errFlag,opts.errMsg,dataLen,ajaxBackData);
    	},
    	'ajax':function(opts,callback){    		
    		var toData = {};
			if (opts.paginate.enabled){
				toData.paginate = true;
				toData.currentPage = opts.paginate.currentPage;
				toData.displayDataLen = opts.paginate.displayLen;
			} else {
				toData.paginate = false;
			}
			toData = $.extend({},toData,opts.ajaxParam.data);
			toData = opts.sendDataHandle(toData);
    		
			var ajaxParam = {
				'url':opts.ajaxParam.url,
				'type':opts.ajaxParam.type,
				'dataType':opts.ajaxParam.dataType,
				'data':toData,
				'success':function(d){
					callback(d);
				},
				'error':function(d){
					callback(null);
				},
				'timeout':opts.ajaxParam.timeout
			};
			
			if (opts.ajaxParam.jsonp != null) {
				ajaxParam.jsonp = opts.ajaxParam.jsonp;
			}
			if (opts.ajaxParam.jsonpCallback != null){
				ajaxParam.jsonpCallback = opts.ajaxParam.jsonpCallback;
			}
			$.ajax(ajaxParam);
		},
		'refresh':function($table,pluginName){
			var $frame = $table.parent('.yhh-data-table-frame');
			var $tbody = $table.children('tbody');
			
			this.view($frame,$table,$tbody,pluginName,false);
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
    $.fn.yhhDataTable = function(options, param) {
        var pluginName = 'yhhDataTable';
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
    $.fn.yhhDataTable.defaults = {
    	'showInfo':false, /*是否显示每页信息*/
		'tbodyRow':{
			'zebra':true, /*斑马行*/
			'selected':false,  /*选中行*/
			'hover':false,  /*行hover效果*/
			'write':function(d){ /*表格生成每行数据的方法*/
				var r = '<tr>'
				$.each(d,function(i,val){
					r+='<td>'+val+'</td>';
				});
				r+='</tr>';
				return r;
			}
		},
    	'paginate':{
    		'enabled':true, /*是否分页*/
    		'visibleGo': false, /*是否开启直接翻至某页功能*/
    		'type':'numbers', /*默认按钮样式递增（numbers只有数字按钮，updown增加上下页按钮，full增加首尾页按钮）*/
    		'displayLen':10,  /*每页显示条数*/
    		'currentPage':1, /*当前页码（初始页码）*/ 
    		'changeDisplayLen': false,  /*改变每页显示数目*/
    		'displayLenMenu':[10,20,30,50] /*改变每页显示数目时的可选值*/
    	},
    	'tbodyData':{
			'enabled':false,  /*是否传入表格数据*/
			'source':[] /*传入的表格数据*/
		},
    	'serverSide': false, /*是否从服务器获取数据*/  
    	/*ajax参数*/ 
    	'ajaxParam': {
			'url':'', /*url地址*/
			'type':'GET', /*ajax传输方式*/
			'dataType':'json', /*ajax传送数据格式*/
			'jsonp':null, /*dataType是jsonp的时候，传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名*/
			'jsonpCallback':null, /*dataType是jsonp的时候，自定义的jsonp回调函数名称*/
			'data':{}, /*传到服务器的数据*/
			'timeout':10*1000  /*响应最久时间限制，毫秒*/
		},
		'errFlag':false,   /*出错标记，false无错误，true出错*/ 
		'errMsg':'',   /*出错信息*/
		'sendDataHandle':function(d){return d;},  /*传递到服务器的数据预处理方法*/
		'backDataHandle':function(d){return d;},  /*预处理从服务器的接收数据或者js传入的数据*/
    	'beforeShow':function(){},  /*显示之前的额外处理事件*/
    	'afterShow':function(){}  /*显示之后的额外处理事件*/
    };
    $.fn.yhhDataTable.defaults.ajaxBack = {};
    $.fn.yhhDataTable.defaults.ajaxBack.defaults = {'errFlag':false,'errMsg':'','dataLen':0,'data':[],'origData':null};
})(jQuery);