var contentIcon = [ [ {
    ic: "icon-naozhong",
    icname: "限时秒杀"
}, {
    ic: "icon-yagaoyashua",
    icname: "每日清仓"
} ], [ {
    ic: "icon-chaoguo",
    icname: "多多矿场"
}, {
    ic: "icon-bijiben",
    icname: "品牌馆"
} ], [ {
    ic: "icon-shucai",
    icname: "一分抽奖"
}, {
    ic: "icon-xiwanye",
    icname: "充值中心"
} ], [ {
    ic: "icon-tangguo",
    icname: "爱逛街"
}, {
    ic: "icon-qingkong",
    icname: "9块9特卖"
} ], [ {
    ic: "icon-tangguo1",
    icname: "电器城"
}, {
    ic: "icon-yugang",
    icname: "砍价免费拿"
} ], [ {
    ic: "icon-diaodai",
    icname: "食品超市"
}, {
    ic: "icon-xiaokuku",
    icname: "天天红包"
} ], [ {
    ic: "icon-chaoguo",
    icname: "开宝箱领钱"
}, {
    ic: "icon-xiwanye",
    icname: "明星送红包"
} ], [ {
    ic: "icon-shejishi2",
    icname: "时尚穿搭"
}, {
    ic: "icon-caidanshejishi",
    icname: "领券中心"
} ] ];

Page({
    data: {
        contentIcons: contentIcon,
        lefOrRigOne: !0,
        leftTwo: "383rpx",
        flag: !0,
        animationData: {}
    },
    onReady: function() {
        var i = wx.createAnimation({
            duration: 200,
            timingFunction: "linear"
        });
        this.animation = i;
    },
    conScroll: function(i) {
        var n, a = this.data.contentIcons.length, t = wx.getSystemInfoSync().windowWidth, c = t / 750 * (148 * a) - t;
        this.data.flag ? (n = 100 + i.detail.scrollLeft / c * 28 + "rpx", console.log("true" + i.detail.scrollLeft)) : (n = 100 + (c - i.detail.scrollLeft) / c * 28 + "rpx", 
        console.log("false" + i.detail.scrollLeft)), this.animation.width(n).step(), this.setData({
            animationData: this.animation.export()
        });
    },
    conScrLower: function(i) {
        this.animation.width("80rpx").step(), this.setData({
            lefOrRigOne: !1,
            leftTwo: "335rpx",
            animationData: this.animation.export(),
            flag: !1
        });
    },
    conScrUpper: function(i) {
        this.animation.width("80rpx").step(), this.setData({
            lefOrRigOne: !0,
            leftTwo: "383rpx",
            animationData: this.animation.export(),
            flag: !0
        });
    }
});