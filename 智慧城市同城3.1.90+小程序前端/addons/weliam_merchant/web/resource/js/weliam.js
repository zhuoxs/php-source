var version = new Date().getTime();
var myconfig =  {
	path: '../addons/weliam_merchant/web/resource/',
    alias:{ 
		'jquery': 'js/jquery-1.11.1.min',
		'jquery.ui': 'components/jquery/jquery-ui-1.10.3.min',
		'jquery.form': 'components/jquery/jquery.form',
		'jquery.validate': 'components/jquery/jquery.validate.min',
		'jquery.confirm': 'components/confirm/jquery-confirm',
        'jquery.contextMenu' : 'js/contextMenu/jquery.contextMenu',
        'select2' : 'js/select2.min',
        'switchery' : 'components/switchery/switchery',
        'layui' : 'components/layui/layui',
        'layer' : 'components/layer/layer',
        'scrollLoading' : 'components/scrollLoading/jquery.scrollLoading.min',
        'g2' : 'components/g2/g2.min',
        'data-set' : 'components/g2/data-set.min',
        'goods_selector': 'js/goods_selector',
	}, 
	map:{
		'js':'.js?v='+version,
		'css':'.css?v='+version
	},
    css: {
    	'jquery.confirm': 'components/confirm/jquery-confirm',
        'jquery.contextMenu' : 'js/contextMenu/jquery.contextMenu',
        'select2' : 'css/select2.min',
        'switchery' : 'components/switchery/switchery',
        'layui' : 'components/layui/css/layui',
        'layer' : 'components/layer/skin/layer',
	},preload:['jquery']
}

var myrequire = function(arr, callback) {
	var newarr = [ ];
	$.each(arr, function(){
		var js = this;
		if( myconfig.css[js]){
			var css = myconfig.css[js].split(',');
			$.each(css,function(){
				newarr.push( "css!" +  myconfig.path + this + myconfig.map['css']);
			});
		}
		var jsitem = this; 
		if( myconfig.alias[js]){
		    jsitem = myconfig.alias[js];
		}
		newarr.push(  myconfig.path + jsitem + myconfig.map['js']);
	});
	require(newarr,callback);
}