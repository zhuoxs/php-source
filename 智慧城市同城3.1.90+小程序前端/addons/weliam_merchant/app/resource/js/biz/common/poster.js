define(['jquery','light7'], function($) {
    var modal = {imgIndex: 0, createdQr: 0};
    var styleData = {
    	'cW':640,
    	'cH':1136,
    	'borW':100,
    	'createdLogo':false,
		'rush':{
    		'logo':{
    			'top':110,
    			'left':function(){
    				return styleData.cW/2 - styleData.rush.logo.width/2;
    			}, 
    			'width':430,
    			'height':430
    		},
    		'code':{
    			'top':912,
    			'left':function(){
    				return styleData.cW/2 - 162;
    			}, 
    			'width':146,
    			'height':146
    		},
    		'headImg':{
    			'top':695,
    			'left':function(){
    				return styleData.cW/2-40;
    			},
    			'width':80,
    			'height':80
    		},
    		'nickName':{
    			'top':810,
    			'left':640/2
    		},
    		'shareText':{
    			'top':845,
    			'left':640/2
    		},
    		'descName':{
    			'top':628+8,
    			'left':100+50
    		},
    		'cardTitle':{
    			'top':function(){
    				return styleData.rush.logo.top + styleData.rush.logo.width + 50;
    			},
    			'left':640/2
    		},
    		'descText':{
    			'top':function(){
    				return styleData.rush.logo.top + styleData.rush.logo.width + styleData.rush.headImg.width + 60;
    			},
    			'left':640/2
    		},
    		'cardName':{
    			'top':628+10,
    			'left':640/2
    		}
    	}
    }
    modal.init = function (params) {
        modal.cardConfig = params ? params.cardConfig : {};
        console.log(modal.cardConfig)
        setTimeout(function () {
            $(".share-card-menu .item").eq(0).click();
            var height = $(window).height() - $('.share-card-menu').height() - 60;
            $('#img').css({height: height + 'px', marginTop: 20 + 'px'})
        }, 100);
        $(".share-card-menu .item").click(function () {
            var _this = $(this);
            if (_this.hasClass('active')) {
                return
            }
            _this.addClass('active').siblings().removeClass('active');
            if (_this.data('img')) {
                $("#img").attr('src', _this.data('img'));
                return
            }
            $(".share-card-loading").fadeIn();
            modal.cardConfig.createdQr = false;
            styleData.createdLogo = false;
            modal.cardConfig.callback = function (src) {
                $(".card-html").show(), $(".share-card-loading").fadeOut();
                _this.data('img', src)
            };
            modal.cardConfig.bgImg = _this.data('bg');
            modal.initApp();
        });
        $('.share-card-menu .tips').click(function () {
            $('.share-card-mask').fadeIn();
            $('.share-card-tips').fadeIn()
        });
        $('.share-card-tips .button').click(function () {
            $('.share-card-mask').fadeOut();
            $('.share-card-tips').fadeOut()
        })
    };
    modal.initApp = function () {
        var canvas = document.createElement('canvas');
        canvas.width = 640, canvas.height = 1136;
        modal.initCard(canvas);
    };
    modal.initCard = function (canvas) {
        if (typeof modal.cardConfig != 'object') {
            alert('参数错误');
            return;
        }
        /*if (!modal.cardConfig.element || !modal.cardConfig.bgImg || !modal.cardConfig.headImg || !modal.cardConfig.qrCode) {
            return
        }*/
        var context = canvas.getContext('2d');
        var img = new Image;
        img.crossOrigin = '*', img.src = modal.cardConfig.bgImg, img.onload = function () {
            context.drawImage(img, 0, 0, canvas.width, canvas.height);
            modal.initCardBase(canvas);
            alert('背景图加载成功');
        }, img.onerror = function () {
            alert('背景图片加载失败');
            modal.initCardBase(canvas);
        }
    };
    modal.initCardBase = function (canvas) {
        var context = canvas.getContext('2d');
        var img = img||new Image;
        img.setAttribute("crossOrigin",'anonymous');
        img.src = modal.cardConfig.createdQr ? styleData.createdLogo?modal.cardConfig.logoimg:modal.cardConfig.headImg: modal.cardConfig.qrCode;
        img.onload = function () {
        	alert('load');
        	if(styleData.createdLogo){
            	//绘制海报图
            	console.log('createdLogo');
            	context.shadowBlur=8;
				context.shadowColor="rgba(0,0,0,.4)";
            	context.drawImage(img, styleData.rush.logo.left(), styleData.rush.logo.top, styleData.rush.logo.width, styleData.rush.logo.height);
				context.strokeStyle = "#fff";  
				context.lineWidth = 5; 
				context.strokeRect(styleData.rush.logo.left(), styleData.rush.logo.top, styleData.rush.logo.width, styleData.rush.logo.height);  //绘制矩形（无填充）
				context.shadowBlur=0;
				modal.initCardInfo(canvas);
            }
            else if (modal.cardConfig.createdQr) {
            	console.log('createdBg');
                modal.circleImg(context, img, styleData.rush.headImg.left(), styleData.rush.headImg.top, styleData.rush.headImg.width/2);
                styleData.createdLogo = true;
                modal.initCardBase(canvas);
            } else{
            	console.log('createdQr');
            	//绘制二维码
                context.drawImage(img, styleData.rush.code.left(), styleData.rush.code.top, styleData.rush.code.width, styleData.rush.code.height);
                modal.cardConfig.createdQr = true;
                modal.initCardBase(canvas);
            }
        }, img.onerror = function (e) {
//      	console.log(img.src);
            var tip = modal.cardConfig.createdQr ? '头像' : '二维码';
            alert(img.src,' 加载失败');
            if(modal.cardConfig.createdQr){
                modal.cardConfig.headImg = modal.cardConfig.logoimg;
                modal.initCardBase(canvas);
            }
        }
                
    };
    modal.circleImg = function(ctx, img, x, y, r){
		ctx.save();
		var d = 2 * r;
		var cx = x + r;
		var cy = y + r;
		ctx.arc(cx, cy, r, 0, 2 * Math.PI);
		ctx.clip();
		ctx.drawImage(img, x, y, d, d);
		ctx.restore();
	};
    modal.initCardInfo = function (canvas) {
        var context = canvas.getContext('2d'), font = '"苹方 常规","微软雅黑"';
        var nickName = modal.cardConfig.nickName || '', shareText = modal.cardConfig.shareText || '向您推荐';
        context.textAlign = "left";
        context.font = "20px " + font;
        context.fillStyle = "#4D4D4D";
        context.fillText(nickName.slice(0, 18), styleData.rush.nickName.left - context.measureText(nickName.slice(0, 18)).width/2, styleData.rush.nickName.top);
        context.font = "16px " + font;
        context.fillStyle = "#999999";
        context.fillText(shareText.slice(0, 22), styleData.rush.shareText.left - context.measureText(shareText.slice(0, 22)).width/2, styleData.rush.shareText.top);
        context.font = "26px " + font;
        context.fillStyle = "#666666";
        var cardName = modal.cardConfig.cardName, 
        	cardTitle = modal.cardConfig.cardTitle || '',
            descName = modal.cardConfig.descName || '',
            descText = modal.cardConfig.descText || '';
        cardName.length > 20 && (cardName = cardName.slice(0, 20), cardName += "...");
        context.fillStyle = "#FF5520";
        context.fillText(cardName, styleData.borW, styleData.rush.cardName.top);
        context.font = "32px " + font;
        context.fillStyle = "#4D4D4D";
        if (cardTitle.length > 24 && (cardTitle = cardTitle.slice(0, 24), cardTitle += "..."), cardTitle.length > 12 && (cardTitle = cardTitle.slice(0, 12) + " " + cardTitle.slice(12)), modal.initCardFillText(context, cardTitle, styleData.borW, styleData.rush.cardTitle.top(), 431, 55), descText) {
            context.font = "20px " + font;
            context.fillStyle = "#999999";
            context.fillText(descName.slice(0, 20), styleData.rush.descName.left + context.measureText(cardName).width, styleData.rush.descName.top);
            context.font = "18px " + font;
            context.fillStyle = "#AAAAAA";
            descText.length > 57 && (descText = descText.slice(0, 57), descText += "....");
            descText.length > 19 && (descText = descText.slice(0, 19) + " " + descText.slice(19));
            descText.length > 38 && (descText = descText.slice(0, 38) + " " + descText.slice(38));
            modal.initCardFillText(context, descText, styleData.borW, styleData.rush.descText.top(), 431, 34)
        }
        var src = canvas.toDataURL("image/png");
        $(modal.cardConfig.element).attr('src', src);
        if (modal.cardConfig.callback) {
            modal.cardConfig.callback(src)
        }
    };
    modal.initCardFillText = function (e, n, t, i, l, o) {
        for (var r = n.split(" "), a = "", c = 0; c < r.length; c++) {
            var s = a + r[c] + " ", f = e.measureText(s), d = f.width;
            d > l && c > 0 ? (e.fillText(a, t, i), a = r[c] + " ", i += o) : a = s
        }
        e.fillText(a, t, i)
    };
    return modal
});