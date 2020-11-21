(function($) {
	$.freeScroll = function(element, options) {
		var DATA_ITEM_INDEX = "index";
		var DATA_ITEM_TARGET_LEFT = "target_left";
		var DATA_ITEM_DELETE_LOCK = "delete_lock";
		var DATA_ITEM_FIRST_SHOW = "first_show";
		var DATA_ITEM_LAST_SHOW = "last_show";
		
		// plugin's default options
		// this is private property and is  accessible only from inside the plugin
		var defaults = {
			// 插件配置属性
			scrollItemNodeSelector: "",
			scrollItemWidth: 0,
			scrollItemCount: 1,
			showItemCount: 1,
			// scrollGroupWidth: 0, // scrollItemWidth * scrollItemCount
			scrollAnimationDuration: 800,
			scrollEasing: "swing",
			isAllowRepeatAnimate: false,
			isAutoScroll: true,
			autoScrollTimeout: 3000,
			isHoverStopScroll: true,
			isHoverControlElementStopScroll: true,
			isHoverStopScrollingAnimate: false,
			scrollItemFaultTolerantBoundaryPercent: 0.2,
			isScrollWholeEnd: true, // TODO: 完整支持此功能
			// TODO: support config
			// isLoopScroll: true,
			
			// 快捷绑定事件：若提供 控制按钮，则插件将自动绑定 向左、向右按钮的点击事件 并触发滚动效果
			scrollToLeftElement: null,
			scrollToRightElement: null,
			
			// 插件提供的事件
			onBeforeScrollToRight: function(scrollPageIndex, firstShowItemIndex, lastShowItemIndex) {},
			onBeforeScrollToLeft: function(scrollPageIndex, firstShowItemIndex, lastShowItemIndex) {},
			onAfterScrollToRight: function(scrollPageIndex, firstShowItemIndex, lastShowItemIndex) {},
			onAfterScrollToLeft: function(scrollPageIndex, firstShowItemIndex, lastShowItemIndex) {},
			onBeforeStopScrolling: function() {},
			onBeforeStartScrolling: function() {}
			
			// TODO: createSymbolElement?
		};
		
		// 为了避免this在不同function中的指向，这里缓存this引用
		var plugin = this;
		
		// this will hold the merged default, and user-provided options
		// plugin's properties will be available through this object like:
		// plugin.settings.propertyName from inside the plugin or
		// element.data('pluginName').settings.propertyName from outside the plugin, 
		// where "element" is the element the plugin is attached to;
		// 插件使用者自定义的配置 与 默认配置合并后，放在 settings 里
		plugin.settings = {};
		
		// 缓存变量（插件内全局可用）
		var $_scrollContainer = $(element);
		var scrollItemNodeSelector = plugin.settings.scrollItemNodeSelector;
		var $_scrollItems = $_scrollContainer.children(scrollItemNodeSelector); // 只在初始化和验证配置时使用
		var elementArray = [];  // 原始的item数组（用于克隆）
		var animateIntervalId = null;
		
		// 初始化插件时会调用的“构造器”方法
		plugin.init = function() {
			// 合并配置
			plugin.settings = $.extend({}, defaults, options);
			// validate setting
			validateSetting(plugin.settings);
			// init plugin private data
			$_scrollItems.each(function (i) {
				elementArray.push($(this).show().attr("data-" + DATA_ITEM_INDEX, i));
			});
			
			var settings = plugin.settings;
			// init view
			$_scrollContainer.empty();
			// 初始化时，根据配置 将需要显示的元素 放入父元素中
			for (var i = 0; i < settings.showItemCount; i++) {
				elementArray[i].appendTo($_scrollContainer).css({
					left: settings.scrollItemWidth * i
				});
			}
			// init data(show index)
			var $_items = getCurrentScrollItems();
			$_items.first().data(DATA_ITEM_FIRST_SHOW, true);
			$_items.last().data(DATA_ITEM_LAST_SHOW, true);
			// bind event
			var scrollToLeftElement = settings.scrollToLeftElement;
			var scrollToRightElement = settings.scrollToRightElement;
			if (scrollToLeftElement) {
				$(scrollToLeftElement).click(function () {
					plugin.scrollToLeft();
				});
			}
			if (scrollToRightElement) {
				$(scrollToRightElement).click(function () {
					plugin.scrollToRight();
				});
			}
			// auto animate
			if (settings.isAutoScroll) {
				plugin.enableAutoScroll();
				
				if (settings.isHoverStopScroll !== false) {
					// 鼠标悬浮时不滚动，鼠标离开时自动滚动
					$_scrollContainer.hover(function () {
						plugin.disableAutoScroll();
					}, function () {
						plugin.enableAutoScroll();
					});
				}
				if (settings.isHoverControlElementStopScroll !== false) {
					// 针对 滚动控制按钮：鼠标悬浮时不滚动，鼠标离开时自动滚动
					$(scrollToLeftElement).add(scrollToRightElement).hover(function () {
						plugin.disableAutoScroll();
					}, function () {
						plugin.enableAutoScroll();
					});
				}
			}
			
			if (settings.isHoverStopScrollingAnimate) {
				// 鼠标悬浮时，停止正在滚动的元素。并且在鼠标离开时继续滚动元素
				$_scrollContainer.hover(function () {
					if (settings.onBeforeStopScrolling() === false) {
						return;
					}
					
					getCurrentScrollItems().stop().data(DATA_ITEM_DELETE_LOCK, true);
				}, function () {
					if (settings.onBeforeStartScrolling() === false) {
						return;
					}
					
					getCurrentScrollItems().each(function () {
						var $_self = $(this);
						
						if ($_self.queue().length > 0) {
							return;
						}
						
						$_self.animate({
							left: $_self.data(DATA_ITEM_TARGET_LEFT)
						}, settings.scrollAnimationDuration, function () {
							$_self.removeData(DATA_ITEM_DELETE_LOCK);
							// TODO: trigger event
							// onBefore[After]ScrollToRight[Left]
						});
					});
				});
			}
		};
		
		// public methods
		// these methods can be called like:
		// plugin.methodName(arg1, arg2, ... argn) from inside the plugin or
		// element.data('pluginName').publicMethod(arg1, arg2, ... argn) from outside 
		// the plugin, where "element" is the element the plugin is attached to;
		
		// plugin上的方法是插件的API
		
		// TODO: support scrollPage
		/**
		 * 控制元素向右滚动
		 * @param {number=1} scrollPage 滚动到指定的页（默认滚动一页，当存在多页滚动且需要跨页滚动时 需指定此参数）
		 */
		plugin.scrollToRight = function(scrollPage) {
			doScroll({
				direction: "right",
				appendScrollElement: function (settings) {
					var isScrollWholeEnd = settings.isScrollWholeEnd;
					var scrollItemCount = settings.scrollItemCount;
					var showItemCount = settings.showItemCount;
					var scrollItemWidth = settings.scrollItemWidth;
					
					// prepare dom element
					var beginAppendIndex = plugin.getLastShowItemIndex() + 1;
					if (beginAppendIndex >= elementArray.length) {
						beginAppendIndex = 0;
						
						if (isScrollWholeEnd) {
							// 滚动到达最后一个之后，要从头开始滚动，且不能首尾相连
							scrollItemCount = showItemCount;
						}
						// TODO: else
					}
					// console.log("beginAppendIndex: " + beginAppendIndex);
					var appendItemArray = elementArray.slice(beginAppendIndex, beginAppendIndex + scrollItemCount);
					var appendItemCount = 0;
					for (var i = 0, len = appendItemArray.length; i < len; i++) {
						appendItemArray[i].clone()
							.appendTo($_scrollContainer)
							.css({
								left: scrollItemWidth * i + (scrollItemWidth * showItemCount)
							});
						
						appendItemCount++;
					}
					
					// reset `first show index` and `last show index`
					var $_items = getCurrentScrollItems();
					$_items.removeData(DATA_ITEM_FIRST_SHOW).removeData(DATA_ITEM_LAST_SHOW);
					$_items.eq(appendItemCount).data(DATA_ITEM_FIRST_SHOW, true);
					$_items.last().data(DATA_ITEM_LAST_SHOW, true);
					
					return appendItemCount;
				}
			});
		};
		// TODO: support scrollPage
		plugin.scrollToLeft = function(scrollPage) {
			doScroll({
				direction: "left",
				appendScrollElement: function (settings) {
					var isScrollWholeEnd = settings.isScrollWholeEnd;
					var scrollItemCount = settings.scrollItemCount;
					var showItemCount = settings.showItemCount;
					var scrollItemWidth = settings.scrollItemWidth;
					
					// prepare dom element
					var endAppendIndex = plugin.getFirstShowItemIndex();
					if (endAppendIndex <= 0) {
						endAppendIndex = elementArray.length;
						
						if (isScrollWholeEnd) {
							// 滚动到达第一个之后，要从尾部开始滚动，且不能首尾相连
							scrollItemCount = showItemCount;
						}
						// TODO: else
					}
					// console.log("endAppendIndex: " + endAppendIndex);
					var appendItemArray = elementArray.slice(Math.max(endAppendIndex - scrollItemCount, 0), endAppendIndex);
					var appendItemCount = 0;
					for (var appendLength = appendItemArray.length, i = appendLength - 1; i >= 0; i--) {
						appendItemArray[i].clone()
							.prependTo($_scrollContainer)
							.css({
								left: scrollItemWidth * i - scrollItemWidth * appendLength
							});
						
						appendItemCount++;
					}
					
					// reset `first show index` and `last show index`
					var $_items = getCurrentScrollItems();
					$_items.removeData(DATA_ITEM_FIRST_SHOW).removeData(DATA_ITEM_LAST_SHOW);
					$_items.first().data(DATA_ITEM_FIRST_SHOW, true);
					$_items.eq(showItemCount - 1).data(DATA_ITEM_LAST_SHOW, true);
					
					return appendItemCount;
				}
			});
		};
		plugin.getFirstShowItemIndex = function() {
			var $_item = getCurrentScrollItems().filter(function () {
				return $(this).data(DATA_ITEM_FIRST_SHOW);
			});
			
			return $_item.data(DATA_ITEM_INDEX);
		};
		plugin.getLastShowItemIndex = function() {
			var $_item = getCurrentScrollItems().filter(function () {
				return $(this).data(DATA_ITEM_LAST_SHOW);
			});
			
			return $_item.data(DATA_ITEM_INDEX);
		};
		plugin.enableAutoScroll = function() {
			clearInterval(animateIntervalId);
			
			animateIntervalId = createAnimateInterval();
		};
		plugin.disableAutoScroll = function() {
			clearInterval(animateIntervalId);
		};
		plugin.setScrollItemDeleteLock = function(isLock) {
			var $_scrollItem = getCurrentScrollItems();
			
			if (isLock === true) {
				$_scrollItem.data(DATA_ITEM_DELETE_LOCK, true);
			}
			else {
				$_scrollItem.removeData(DATA_ITEM_DELETE_LOCK);
			}
		};
		
		// 插件私有方法，在插件内部可直接调用，对外部则不可见
		var validateSetting = function(settings) {
			if (!settings.scrollItemWidth) {
				settings.scrollItemWidth = $_scrollItems.first().outerWidth();
			}
			if (settings.showItemCount < settings.scrollItemCount) {
				settings.showItemCount = settings.scrollItemCount;
			}
			// if (!settings.scrollGroupWidth) {
				// settings.scrollGroupWidth = settings.scrollItemWidth * settings.showItemCount;
			// }
		};
		var doScroll = function (scrollParam) {
			var settings = plugin.settings;
			var scrollItemCount = settings.scrollItemCount;
			var showItemCount = settings.showItemCount;
			var scrollItemWidth = settings.scrollItemWidth;
			var direction = scrollParam.direction;
			var directionEventName = direction.charAt(0).toUpperCase() + direction.slice(1);
			
			// tigger befor scroll item event
			var beforeScrollFirstShowItemIndex = plugin.getFirstShowItemIndex();
			var beforeScrollLastShowItemIndex = plugin.getLastShowItemIndex();
			var beforeScrollPageIndex = Math.floor(beforeScrollLastShowItemIndex / scrollItemCount);
			if (settings["onBeforeScrollTo" + directionEventName](beforeScrollPageIndex, beforeScrollFirstShowItemIndex, beforeScrollLastShowItemIndex) === false) {
				return;
			}
			
			// prevent repeat animate
			if (settings.isAllowRepeatAnimate !== true) {
				var hasAnimateQueue = false;
				getCurrentScrollItems().each(function () {
					if ($(this).queue().length > 0) {
						hasAnimateQueue = true;
						
						return false;
					}
				});
				// console.log("hasAnimateQueue: ", hasAnimateQueue);
				
				if (hasAnimateQueue) {
					// console.log("动画队列中有未完成的动画，故不响应新动画效果");
					return;
				}
			}
			else {
				// 直接完成剩余动画
				getCurrentScrollItems().stop(false, true);
			}
			
			// 添加要滚动的新元素
			var appendItemCount = scrollParam.appendScrollElement(settings);
			
			var changeValue = scrollItemWidth * appendItemCount;
			var changeLeftValue = 0;
			if (direction == "right") {
				changeLeftValue = -changeValue;
			}
			else if (direction == "left") {
				changeLeftValue = changeValue;
			}
			
			// animate dom element
			getCurrentScrollItems().each(function () {
				var $_self = $(this);
				var targetLeftValue = parseInt($_self.css("left")) + changeLeftValue;
				
				$_self.data(DATA_ITEM_TARGET_LEFT, targetLeftValue);
				
				$_self.animate({
					left: targetLeftValue
				}, settings.scrollAnimationDuration, settings.scrollEasing, function () {
					deleteItem.call($_self, scrollItemWidth, showItemCount);
					
					setTimeout(function () {
						var firstShowItemIndex = plugin.getFirstShowItemIndex();
						var lastShowItemIndex = plugin.getLastShowItemIndex();
						var scrollPageIndex = Math.floor(lastShowItemIndex / scrollItemCount);
						
						// tigger after scroll item event
						settings["onAfterScrollTo" + directionEventName](scrollPageIndex, firstShowItemIndex, lastShowItemIndex);
					}, 0);
				});
			});
		};
		var deleteItem = function (scrollItemWidth, showItemCount) {
			var $_self = $(this);
			
			// 程序控制逻辑中的特殊锁定（如果值为true则不能删除）
			if ($_self.data(DATA_ITEM_DELETE_LOCK) == true) {
				return;
			}
			
			var leftValue = parseInt($_self.css("left"));
			var faultTolerantBoundary = scrollItemWidth * plugin.settings.scrollItemFaultTolerantBoundaryPercent;
			var minLeftValue = 0 - faultTolerantBoundary;
			var maxLeftValue = scrollItemWidth * (showItemCount - 1) + faultTolerantBoundary;
			
			if ((leftValue < minLeftValue) || (leftValue > maxLeftValue)) {
				// console.log("remove item, left: " + leftValue + "(" + $_self.css("left") + ")");
				
				// 展示的第一个和最后一个不能删除（即使因为调整窗口大小的原因 而超出可视范围）
				if ($_self.data(DATA_ITEM_FIRST_SHOW) || $_self.data(DATA_ITEM_LAST_SHOW)) {
					// console.warn("展示的第一个和最后一个不能删除（即使因为调整窗口大小的原因 而超出可视范围）");
					return;
				}
				
				$_self.remove();
			}
		};
		var deleteExtraItems = function (scrollItemWidth, showItemCount) {
			getCurrentScrollItems().each(function () {
				deleteItem.apply(this, [scrollItemWidth, showItemCount]);
			});
		};
		var createAnimateInterval = function () {
			return setInterval(function () {
				plugin.scrollToRight();
			}, plugin.settings.autoScrollTimeout);
		};
		var getCurrentScrollItems = function () {
			return $_scrollContainer.children(scrollItemNodeSelector);
		};
		
		// 初始化插件
		plugin.init();
	};
	
	// add the plugin to the jQuery.fn object
	$.fn.freeScroll = function(options) {
		var myPluginName = "freeScroll";
		
		// 使用return以支持链式调用；使用each则支持隐式迭代jQuery集合
		// iterate through the DOM elements we are attaching the plugin to
		return this.each(function() {
			// 使用单例模式
			// if plugin has not already been attached to the element
			if (undefined == $(this).data(myPluginName)) {
				
				// create a new instance of the plugin
				// pass the DOM element and the user-provided options as arguments
				var plugin = new $.freeScroll(this, options);
				
				// in the jQuery version of the element
				// store a reference to the plugin object
				// you can later access the plugin and its methods and properties like
				// element.data('pluginName').publicMethod(arg1, arg2, ... argn) or
				// element.data('pluginName').settings.propertyName
				$(this).data(myPluginName, plugin);
				
			}
		});
		
	};
	
})(jQuery);
