var version = new Date().getTime();
var myconfig =  {
	path: '../addons/feng_fightgroups/web/resource/',
    alias:{ 
		'jquery': 'js/lib/jquery-1.11.1.min',
		'jquery.ui': 'js/lib/jquery-ui-1.10.3.min',
		'jquery.confirm': 'components/confirm/jquery-confirm',
        'jquery.contextMenu' : 'components/contextMenu/jquery.contextMenu',
        'jquery.nestable' : 'components/nestable/jquery.nestable',
        'select2' : 'components/select2/select2.min',
        'switchery' : 'components/switchery/switchery',
        'scrollLoading' : 'js/jquery.scrollLoading.min',
	}, 
	map:{
		'js':'.js?v='+version,
		'css':'.css?v='+version
	},
    css: {
    	'jquery.confirm': 'components/confirm/jquery-confirm',
        'jquery.contextMenu' : 'components/contextMenu/jquery.contextMenu',
        'select2' : 'components/select2/select2.min',
        'switchery' : 'components/switchery/switchery',
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