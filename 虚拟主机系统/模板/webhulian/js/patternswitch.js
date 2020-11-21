var patternSwitch = function(container, options){
	//默认配置
	var defaultOptions = {
		switchItemCurrentClass: "switch--current",
		indexContainer: container,
		indexUlClass: "patternSwitch-index",
		indexPointClass: "patternSwitch-index-point",
		indexPointerCurrentClass:"index-current",
		switchInterval: 1000,
		fadeInDuration: 500,
		beforeSwitchHandle: function(index){},
		afterSwitchHandle: function(index){},
		initSwitchHandle: function(index){},
		startIndex: 0
	};
	var switchOptions = $.extend({},defaultOptions,options);
	var index = switchOptions.startIndex;
	var $container = $(container);
	var $switchItems = $container.children();

	//创建指示器
	var indexUl = $("<ul>");
	indexUl.addClass(switchOptions.indexUlClass);
	for(var i=0;i<=$switchItems.length-1;i++){
		$("<li>").addClass(switchOptions.indexPointClass).appendTo(indexUl);
	}
	$(switchOptions.indexContainer).append(indexUl);
	var $indexPointer = indexUl.children();

	//初始化
	$switchItems.hide();
	$switchItems.eq(index).show().addClass(switchOptions.switchItemCurrentClass);
	$indexPointer.eq(index).addClass(switchOptions.indexPointerCurrentClass);
	switchOptions.initSwitchHandle(index);
	index++;

	var timer = setInterval(function(){

		if(index > $switchItems.length-1){
			index = 0;
		}

		$switchItems.removeClass(switchOptions.switchItemCurrentClass).hide();
		switchOptions.beforeSwitchHandle(index);
		//pattern淡入
		$switchItems.eq(index).addClass(switchOptions.switchItemCurrentClass).fadeIn(switchOptions.fadeInDuration, function(){
			switchOptions.afterSwitchHandle(index);

		});

		//指示器切换
		$indexPointer.removeClass(switchOptions.indexPointerCurrentClass);
		$indexPointer.eq(index).addClass(switchOptions.indexPointerCurrentClass);

		index++;
	}, switchOptions.switchInterval);
};
