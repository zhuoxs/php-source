window.mobileUtil = (function(win, doc) {
	            var UA = navigator.userAgent,
	                isAndroid = /android|adr|linux/gi.test(UA),
	                isIOS = /iphone|ipod|ipad/gi.test(UA) && !isAndroid,
	                isBlackBerry = /BlackBerry/i.test(UA),
	                isWindowPhone = /IEMobile/i.test(UA),
	                isWeiBo = /WeiBo/gi.test(UA);
	                isMobile = isAndroid || isIOS || isBlackBerry || isWindowPhone;
	            return {
	                isAndroid: isAndroid,
	                isIOS: isIOS,
	                isMobile: isMobile,
	                isWeixin: /MicroMessenger/gi.test(UA),
	                isQQ: / QQ/gi.test(UA),
	                isPC: !isMobile,
	                isWeiBo:isWeiBo
	            };
	        })(window, document);