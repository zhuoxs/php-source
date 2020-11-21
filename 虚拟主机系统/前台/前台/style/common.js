var xmlhttp=false;
function xxkf_obj(id) 
{ 
		if (document.getElementById) 
			return document.getElementById(id); 
		else if (document.all)
			return document.all(id);
		return document.layers[id];
}
function $(id)
{
	return xxkf_obj(id);
}
function create_xmlhttp(){
	var obj=false;
	/*@cc_on @*/
	/*@if (@_jscript_version >= 5)
	// JScript gives us Conditional compilation, we can cope with old IE versions.
	// and security blocked creation of the objects.
	 try {
	  obj = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
	  try {
	   obj = new ActiveXObject("Microsoft.XMLHTTP");
	  } catch (E) {
	   obj = false;
	  }
	 }
	@end @*/
	if (!obj && typeof XMLHttpRequest!='undefined') {
			try {
					obj = new XMLHttpRequest();
			} catch (e) {
					obj=false;
			}
	}
	if (!obj && window.createRequest) {
			try {
					obj = window.createRequest();
			} catch (e) {
					obj=false;
			}
	}
	return obj;
}
function ajax_open_url(url,result_func)
{
	xmlhttp=create_xmlhttp();	
	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange=result_func;
	xmlhttp.send(null);
}
function ajax_open_url2(url,result_func)
{
	xmlhttp2=create_xmlhttp();	
	xmlhttp2.open("GET",url,true);
	xmlhttp2.onreadystatechange=function (){
		result_func(xmlhttp2);
	};
	xmlhttp2.send(null);
}
var xxkf_ftlObj=new Array();
var xxkf_oncaptured = false;
var xxkf_moved=false;
var xxkf_ie =  (document.all) ? true : false; 
var cur_file_id = 0;
var last_upload_status = false;
function xxkf_JSFX_FloatTopDiv(layer_obj,startX,startY)
{
        function xxkf_ml(el)
        {
			//var el=xxkf_obj(id);	
			el.sP=function(x,y){
				this.style.left=x+'px';
				this.style.top=y+'px';
				//alert(this.style.top);
			};			
			el.x=startX;
			el.y=startY;  				
            return el;        
        }
        window.xxkf_stayTopleft=function()
        {
				var pY=0;
				var pX=0;
				if(!xxkf_oncaptured){
					if(xxkf_ie){
						if(document.documentElement&&document.documentElement.scrollTop){
							pY=document.documentElement.scrollTop;
							pX=document.documentElement.scrollLeft;
						}else if(document.body){
							pY=document.body.scrollTop;
							pX=document.body.scrollLeft;
						}					
					}else{
						pY = pageYOffset;
						pX = pageXOffset;
					}
					var total_x=0;
					var total_y=0;
					if(xxkf_ie){
						if(document.documentElement&&document.documentElement.clientWidth){
								total_x=document.documentElement.clientWidth;
								total_y=document.documentElement.clientHeight;
							//	alert(total_y);
						/*		if(document.body){
									total_x=Math.min(total_x,document.body.clientWidth);
									total_y=Math.min(total_y,document.body.clientHeight);
								}
							*/
						}else if(document.body){
								total_x=document.body.clientWidth;
								total_y=document.body.clientHeight;
								//	alert(total_y);
						}
					}else{
						total_x=window.innerWidth-15;
						total_y=window.innerHeight;

					}
					
					for(i=0;i<xxkf_ftlObj.length;i++){
						var x=xxkf_ftlObj[i].x;
						var y=xxkf_ftlObj[i].y;	
						if(x<0 && !xxkf_moved)
							x+=(total_x-xxkf_ftlObj[i].offsetWidth);
						if(y<0 && !xxkf_moved)
							y+=(total_y-xxkf_ftlObj[i].offsetHeight);						
						if(x<0) x=0;
						if(y<0) y=0;
					
						if(x>total_x-xxkf_ftlObj[i].offsetWidth) x=total_x-xxkf_ftlObj[i].offsetWidth;
						if(y>total_y-xxkf_ftlObj[i].offsetHeight) y=total_y-xxkf_ftlObj[i].offsetHeight;
					
						xxkf_ftlObj[i].sP(pX+x,pY+y);
					}
				}
				setTimeout("xxkf_stayTopleft()", 500);				
        }
        xxkf_ftlObj.push(xxkf_ml(layer_obj));
        xxkf_stayTopleft();
}