/***
	name:Men MaoJia
	qq:273142650
	Download by http://www.codefans.net
	email:iatt@qq.com
	date:2010.3.22
***/
(function (){
	var divInnerHtml = '<div style="width:255px;height:255px;margin:12px 0 0 10px;_margin:12px 0 0 5px;float:left"><div style="width:255px;height:255px;background:#ff0000;"><div style="width:255px;height:255px;background:url(/addons/hc_pdd/template/img/masks.png);_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=crop, src=/addons/hc_pdd/template/img/masks.png);_background:none;" onmousedown="Jcolor().palette(this)"><div style="width:12px;height:12px;background:url(/addons/hc_pdd/template/img/choose.png);position:absolute;top:5px;left:4px;_font-size:0;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=crop, src=/addons/hc_pdd/template/img/choose.png);_background:none;"></div></div></div></div><div style="width:20px;height:255px;background:url(/addons/hc_pdd/template/img/rolling.png);float:left;margin:12px 0 0 12px;" onmousedown="Jcolor().rolling(this)"><div style="width:32px;height:9px;background:url(/addons/hc_pdd/template/img/rolling_B.png);position:absolute;top:9px;left:272px;_font-size:0;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=crop, src=/addons/hc_pdd/template/img/rolling_B.png);_background:none;"></div></div>';
	var colorDiv = '<div style="width:410px;height:284px;background:url(/addons/hc_pdd/template/img/bg.png);">'+divInnerHtml+'<div style="width:60px;height:auto;float:left;margin:10px 0 0 10px;font-size:12px;"><div style="width:auto;height:195px;"><table width="100%" height="100 border="0" cellpadding="0" cellspacing="5"><tr><td align="center" valign="middle">R:</td><td align="center" valign="middle"><input style="width:40px;height:14px;" type="text" value="255"/></td></tr><tr><td align="center" valign="middle">G:</td><td align="center" valign="middle"><input  style="width:40px;height:14px;" type="text" value="255"/></td></tr><tr><td align="center" valign="middle">B:</td><td align="center" valign="middle"><input style="width:40px;height:14px;" type="text" value="255"/></td></tr><tr><td></td><td style="border:solid 1px #000;background:#fff;height:40px;"></td></tr><tr><td></td><td><input type="text" style="width:40px;" value="#ffffff"/></td></tr></table></div><div style="width:81px;height:59px;background:url(/addons/hc_pdd/template/img/button.png);margin-left:3px;cursor:pointer;" onclick="Jcolor().Ru();"></div></div></div>';
	var ID = 'Jcolor';
	var R = 255;
	var G = 255;
	var B = 255;
	var Ma = 255;
	var Mi = 255;
	var Cr = 0;
	var Cg = 0;
	var Cb = 0;
	var Ct = 'R';
	var Jq = false;
	( typeof(window.jQuery) == "undefined" ) ? Jq = false : Jq = true;
	window.Jcolor = function(obj) {
		if ( obj != null ) {
			typeof( obj ) == 'string' ? this.obj = document.getElementById( obj ) : this.obj = obj;
		}
		return new newColor();
	}
	var newColor = function() {}
	newColor.prototype = {
		id: function(v){
			ID = v;
			return this;
		},
		color: function() {
			this.init();
			divTop = this.offset( obj ).split(',')[0];
			divLeft = this.offset( obj ).split(',')[1];
			div = document.createElement('div');
			div.id = ID;
			div.style.cssText = ';left:0;top:0;width:255px;height:255px;position:absolute;';
			div.style.left = divLeft + 'px';
			div.style.top = divTop + 'px';
			div.innerHTML = colorDiv;
			document.getElementById( ID ) != null ? document.body.removeChild( document.getElementById( ID ) ) : '';
			document.body.appendChild( div );
			if( Jq ){
				$('#'+ID).fadeOut(0,function(){$('#'+ID).fadeIn(200)});
			}
			document.onselectstart = function() { return false; } 
			return this;
		},
		palette: function( obj ) {
			pDrag = true;
			choose = obj.getElementsByTagName('div')[0];
			ev = window.event || arguments.callee.caller.arguments[0];
			choose.style.left = Jcolor().mouseXY( ev ).split(',')[0] - 6 + 'px';
			choose.style.top = Jcolor().mouseXY( ev ).split(',')[1] - 6 + 'px';
			rgb = Jcolor().paleRGB( parseInt( choose.style.left ) - 4 , parseInt( choose.style.top ) - 5 );
			Jcolor().toColor( rgb );
			Jcolor().toHEX( Jcolor().RGBtoHEX( rgb ) );
			document.onmousemove = function(){
				if (pDrag) {
					ev = window.event || arguments.callee.arguments[0];
					mX = Jcolor().mouseXY( ev ).split(',')[0] - 6;
					mY = Jcolor().mouseXY( ev ).split(',')[1] - 6;
					choose.style.left = mX + 'px';
					choose.style.top = mY + 'px';
					mX < 4 ? choose.style.left = 4 + 'px' : '';
					mX > 259 ? choose.style.left = 259 + 'px' : '';
					mY < 5 ? choose.style.top = 5 + 'px' : '';
					mY > 260 ? choose.style.top = 260 + 'px' : '';
					rgb = Jcolor().paleRGB( parseInt( choose.style.left ) - 4 , parseInt( choose.style.top ) - 5 );
					Jcolor().toColor( rgb );
					Jcolor().toHEX( Jcolor().RGBtoHEX( rgb ) );
				}
			}
			document.onmouseup = function() {
				pDrag = false;
			}
		},
		paleRGB: function(X,Y) {
			r = document.getElementById( ID ).getElementsByTagName('input')[0];
			g = document.getElementById( ID ).getElementsByTagName('input')[1];
			b = document.getElementById( ID ).getElementsByTagName('input')[2];
			xrs = ( 255 - Cr ) / 255;
			xgs = ( 255 - Cg ) / 255;
			xbs = ( 255 - Cb ) / 255;
			yrs = ( 255 - X * xrs ) / 255;
			ygs = ( 255 - X * xgs ) / 255;
			ybs = ( 255 - X * xbs ) / 255;
			if ( Ct === 'R' ) {
				r.value = 255 - Y * 1;
				g.value = parseInt( 255 - X * xgs - Y * ygs );
				b.value = parseInt( 255 - X * xbs - Y * ybs );
			} else if ( Ct === 'G' ) {
				r.value = parseInt( 255 - X * xrs - Y * yrs );
				g.value = 255 - Y * 1;
				b.value = parseInt( 255 - X * xbs - Y * ybs );
			} else if ( Ct === 'B' ) {
				r.value = parseInt( 255 - X * xrs - Y * yrs );
				g.value = parseInt( 255 - X * xgs - Y * ygs );
				b.value = 255 - Y * 1;
			}
			R = r.value;
			G = g.value;
			B = b.value;
			this.Max();
			this.Min();
			return R+','+G+','+B;
		},
		rolling: function( obj ) {
			rDrag = true;
			roll = obj.getElementsByTagName('div')[0];
			ev = window.event||arguments.callee.caller.arguments[0];
			mY = Jcolor().mouseXY( ev ).split(',')[1] - 3;
			roll.style.top = mY + 'px';
			mY < 9 ? roll.style.top = 9 + 'px' : '';
			mY > 264 ? roll.style.top = 264 + 'px' : '';
			rgb = Jcolor().rollRGB( parseInt( roll.style.top ) - 9 );
			Jcolor().toColor( rgb );
			Jcolor().toHEX( Jcolor().RGBtoHEX( rgb ) );
			document.onmousemove = function(){
				if (rDrag) {
					ev = window.event||arguments.callee.arguments[0];
					mY = Jcolor().mouseXY( ev ).split(',')[1] - 3;
					roll.style.top = mY + 'px';
					mY < 9 ? roll.style.top = 9 + 'px' : '';
					mY > 264 ? roll.style.top = 264 + 'px' : '';
					rgb = Jcolor().rollRGB( parseInt( roll.style.top ) - 9 );
					Jcolor().toColor( rgb );
					Jcolor().toHEX( Jcolor().RGBtoHEX( rgb ) );
				}
			}
			document.onmouseup = function() {
				rDrag = false;
			}
		},
		rollRGB: function(Y) {
			r = document.getElementById( ID ).getElementsByTagName('input')[0];
			g = document.getElementById( ID ).getElementsByTagName('input')[1];
			b = document.getElementById( ID ).getElementsByTagName('input')[2];
			is = (Ma-Mi)/42.5;
			if ( Y >= 0 && Y <= 43 ) {
				mr = 255;
				mg = 0;
				mb = Y * 6 > 255 ? 255 : Y * 6;
				nr = Ma;
				ng = Mi;
				nb = Y * is + Mi > Ma ? Ma : parseInt( Y * is + Mi );
				Ct = 'R';
			} else if ( Y >= 43 && Y <= 86 ) {
				mr = 255 - ( ( Y - 43 ) * 6 > 255 ? 255 : ( Y - 43 ) * 6 );
				mg = 0;
				mb = 255;
				nr = Ma - (( Y - 43 ) * is > Ma ?  Ma : parseInt( ( Y - 43 ) * is ) );
				nr < Mi ? nr = Mi : '';
				ng = Mi;
				nb = Ma;
				Ct = 'B';
			} else if ( Y >= 86 && Y <= 129 ) {
				mr = 0;
				mg = ( ( Y - 86 ) * 6 > 255 ? 255 : ( Y - 86 ) * 6 );
				mb = 255;
				nr = Mi;
				ng = ( ( Y - 86 ) * is + Mi > Ma ? Ma : parseInt( ( Y - 86 ) * is + Mi ) );
				nb = Ma;
				Ct = 'B';
			} else if ( Y >= 129 && Y <= 172 ) {
				mr = 0;
				mg = 255;
				mb = 255 - ( ( Y - 129 ) * 6 > 255 ? 255 : ( Y - 129 ) * 6 );
				nr = Mi;
				ng = Ma;
				nb = Ma - ( ( Y - 129 ) * is > Ma ? Ma : parseInt( ( Y - 129 ) * is ) );
				nb < Mi ? nb = Mi : '';
				Ct = 'G';
			} else if ( Y >= 172 && Y <= 215 ) {
				mr = ( ( Y - 172 ) * 6 > 255 ? 255 : ( Y - 172 ) * 6 );
				mg = 255;
				mb = 0;
				nr = ( ( Y - 172 ) * is + Mi > Ma ? Ma : parseInt( ( Y - 172 ) * is + Mi ) );
				ng = Ma;
				nb = Mi;
				Ct = 'G';
			} else {
				mr = 255;
				mg = 255 - ( ( Y - 212 ) * 6 > 255 ? 255 : ( Y - 212 ) * 6 );
				mb = 0;
				nr = Ma;
				ng = Ma - ( ( Y - 212 ) * is > Ma ? Ma : parseInt( ( Y - 212 ) * is ) );
				ng < Mi ? ng = Mi : '';
				nb = Mi;
				Ct = 'R';
			}
			R = r.value = nr;
			G = g.value = ng;
			B = b.value = nb;
			Cr = mr;
			Cg = mg;
			Cb = mb;
			masks = document.getElementById( ID ).getElementsByTagName('div')[0].getElementsByTagName('div')[0].getElementsByTagName('div')[0];
			masks.style.background = 'rgb('+mr+','+mg+','+mb+')';
			return nr + ',' + ng + ',' + nb;
		},
		init: function(){
			R = 255;
			G = 255;
			B = 255;
			Ma = 255;
			Mi = 255;
			Cr = 0;
			Cg = 0;
			Cb = 0;
			Ct = 'R';
		},
		Ru: function(){
			color = document.getElementById( ID ).getElementsByTagName('input')[3].value;
			( typeof( obj.checked ) != 'undefined' ) ? obj.value = color : obj.innerHTML = color;
			this.Close( ID );
			return color;
		},
		Close: function(id){
			if( Jq ) {
				$('#'+id).stop();
				$('#'+id).fadeOut(200,function(){document.body.removeChild( document.getElementById( id ) );});
			} else {
				document.body.removeChild( document.getElementById( id ) );
			}
		},
		Max: function() {
			var array = new Array(parseInt(R),parseInt(G),parseInt(B)); 
			var Max = array[0]; 
			for ( var i = 1 ; i < 3 ; i++ ) {    
				if ( array[i] > Max ) {       
					Max = array[i];    
				}  
			}
			Ma = Max;
		},
		Min: function() {
			var array = new Array(parseInt(R),parseInt(G),parseInt(B));
			var Min = array[0];
			for ( var i = 1 ; i < 3 ; i++ ){
				if ( array[i] < Min) {
					Min = array[i];
				}
			}
			Mi = Min;
		},
		toColor: function(RGB) {
			document.getElementById( ID ).getElementsByTagName('table')[0].getElementsByTagName('tr')[3].getElementsByTagName('td')[1].style.background='rgb('+RGB+')';
		},
		mouseXY: function(e) {
			var X = e.clientX - ( parseInt( document.getElementById( ID ).style.left ) - document.documentElement.scrollLeft - document.body.scrollLeft );
			var Y = e.clientY - ( parseInt( document.getElementById( ID ).style.top ) - document.documentElement.scrollTop - document.body.scrollTop );
			return X + ',' + Y;
		},
		toHEX: function(hex){
			document.getElementById( ID ).getElementsByTagName('input')[3].value='#'+hex;
		},
		RGBtoHEX: function(RGB) {
			RGB = RGB.split(/\D/ig);
			Hex = parseInt(RGB[0]) * 65536 + parseInt(RGB[1]) * 256 + parseInt(RGB[2]);
			Hex = Hex.toString(16);
			while ( Hex.length < 6 ) {
				Hex = '0' + Hex;
			}
			return Hex;
		},
		offset: function( obj ) {
			divTop = obj.offsetTop;
			divLeft = obj.offsetLeft;
			while( obj = obj.offsetParent ) {
				divTop += obj.offsetTop;
				divLeft += obj.offsetLeft;
			}
			return divTop + ',' + divLeft;
		}
	}
})();