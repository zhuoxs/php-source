define(['core'], function (core) {
    var modal = {imgIndex: 0, createdQr: 0};
    modal.init = function (params) {
        modal.cardConfig = params ? params.cardConfig : {};
        setTimeout(function () {
            $(".share-card-menu .item").eq(0).click();
            var height = $(window).height() - $('.share-card-menu').height() - 40;
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
            modal.cardConfig.callback = function (src) {
                $(".card-html").show(), $(".share-card-loading").fadeOut();
                _this.data('img', src)
            };
            modal.cardConfig.bgImg = _this.data('bg');
            modal.initApp()
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
        modal.initCard(canvas)
    };
    modal.initCard = function (canvas) {
        if (typeof modal.cardConfig != 'object') {
            alert('参数错误');
            return
        }
        /*if (!modal.cardConfig.element || !modal.cardConfig.bgImg || !modal.cardConfig.headImg || !modal.cardConfig.qrCode) {
            return
        }*/
        var context = canvas.getContext('2d');
        var img = new Image;
        img.crossOrigin = '*', img.src = modal.cardConfig.bgImg, img.onload = function () {
            context.drawImage(img, 0, 0, canvas.width, canvas.height);
            modal.initCardBase(canvas)
        }, img.onerror = function () {
            FoxUI.toast.show('背景图片加载失败');
            modal.initCardBase(canvas);
        }
    };
    modal.initCardBase = function (canvas) {
        var context = canvas.getContext('2d');
        var img = new Image;
        img.crossOrigin = 'Anonymous', img.src = modal.cardConfig.createdQr ? modal.cardConfig.headImg : modal.cardConfig.qrCode, img.onload = function () {
            if (modal.cardConfig.createdQr) {
                context.save(), context.arc(canvas.width / 2, 177, 40, 0, 2 * Math.PI), context.strokeStyle = "#ffffff", context.lineWidth = 10, context.stroke(), context.clip();
                context.drawImage(img, canvas.width / 2 - 40, 137, 80, 80);
                context.restore();
                modal.initCardInfo(canvas)
            } else {
                context.drawImage(img, canvas.width / 2 - 73, 882, 146, 146);
                modal.cardConfig.createdQr = true;
                modal.initCardBase(canvas)
            }
        }, img.onerror = function (e) {
            var tip = modal.cardConfig.createdQr ? '头像' : '二维码';
            //FoxUI.toast.show(tip + ' 加载失败');
            if(modal.cardConfig.createdQr){
                var host = window.location.host;
                var url = document.location.toString();
                var arrUrl = url.split("//");
                modal.cardConfig.headImg = arrUrl[0]+"//"+host+'/addons/ewei_shopv2/static/images/noface.png';
                modal.initCardBase(canvas);
            }
            //modal.initCardBase(canvas);
        }
    };
    modal.initCardInfo = function (canvas) {
        var context = canvas.getContext('2d'), font = '"苹方 常规","微软雅黑"';
        var nickName = modal.cardConfig.nickName || '', shareText = modal.cardConfig.shareText || '向您推荐';
        context.textAlign = "center", context.font = "24px " + font, context.fillStyle = "#4D4D4D", context.fillText(nickName.slice(0, 18), canvas.width / 2, 254);
        context.font = "20px " + font, context.fillStyle = "#999999", context.fillText(shareText.slice(0, 22), canvas.width / 2, 284);
        context.font = "22px " + font, context.fillStyle = "#666666";
        var cardName = modal.cardConfig.cardName, cardTitle = modal.cardConfig.cardTitle || '',
            descName = modal.cardConfig.descName || '', descText = modal.cardConfig.descText || '';
        cardName.length > 20 && (cardName = cardName.slice(0, 20), cardName += "..."), context.fillText(cardName, canvas.width / 2, 355), context.font = "32px " + font, context.fillStyle = "#4D4D4D";
        if (cardTitle.length > 24 && (cardTitle = cardTitle.slice(0, 24), cardTitle += "..."), cardTitle.length > 12 && (cardTitle = cardTitle.slice(0, 12) + " " + cardTitle.slice(12)), modal.initCardFillText(context, cardTitle, canvas.width / 2, 430, 431, 55), descText) {
            context.font = "bold 20px " + font, context.fillStyle = "#999999", context.fillText(descName.slice(0, 20), canvas.width / 2, 638), context.font = "22px " + font, context.fillStyle = "#AAAAAA";
            descText.length > 57 && (descText = descText.slice(0, 57), descText += "...."), descText.length > 19 && (descText = descText.slice(0, 19) + " " + descText.slice(19)), descText.length > 38 && (descText = descText.slice(0, 38) + " " + descText.slice(38)), modal.initCardFillText(context, descText, canvas.width / 2, 700, 431, 34)
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