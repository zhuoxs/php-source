require.config({
	urlArgs: "v=" +  (new Date()).getTime(), //getHours 
    baseUrl: '/addons/mihua_mall/public/js/',
    paths: {
		'zepto' : '//g.alicdn.com/sj/lib/zepto/zepto.min',
		'weixinJs':  '/addons/mihua_mall/public/js/app/weixinJs',
		'common':  '/addons/mihua_mall/public/js/app/common',
		'lazyLoad':  '/addons/mihua_mall/public/js/lib/jquery.lazyload',		
		'familyshop':  '/addons/mihua_mall/public/js/app/familyshop',
		'good':  '/addons/mihua_mall/public/js/app/good',
		'sm' : '//g.alicdn.com/msui/sm/0.6.2/js/sm.min',
		'smex' : '//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min'		
		
    },
	shim:{
        'sm':{
            deps:['zepto']
        },	
        'smex':{
            deps:['zepto']
        }
		
	}
});
