/** layuiAdmin.std-v1.0.0-beta7 LPPL License By http://www.layui.com/admin/ */
 ;layui.extend(
 	{
 		setter:"config",
 		admin:"lib/admin",
 		view:"lib/view"}
 	).define(["setter","admin"],function(a){
 		var e=layui.setter,
 		i=layui.element,
 		n=layui.admin,
 		t=n.tabsPage,
 		d=layui.view,
 		l=function(a,e){
 			var d,l=u("#LAY_app_tabsheader>li"),
 			o=a.replace(/(^http(s*):)|(\?[\s\S]*$)/g,"");
 			l.each(function(e){
 				var i=u(this),n=i.attr("lay-id");
 				n===a&&(d=!0,t.index=e)}
 				),
 			e=e||"新标签页",d||(u(s).append(['<div class="layadmin-tabsbody-item layui-show">','<iframe src="'+a+'" frameborder="0" class="layadmin-iframe"></iframe>',"</div>"].join("")),t.index=l.length,i.tabAdd(r,{title:"<span>"+e+"</span>",id:a,attr:o})),i.tabChange(r,a),n.tabsBodyChange(t.index,{url:a,text:e})},s="#LAY_app_body",r="layadmin-layout-tabs",u=layui.$;u(window);layui.config({base:e.base+"modules/"}),layui.each(e.extend,function(a,i){var n={};n[i]="{/}"+e.base+"lib/extend/"+i,layui.extend(n)}),d().autoRender(),a("index",{openTabsPage:l})});