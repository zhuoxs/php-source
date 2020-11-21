var app = getApp();

Page({
    data: {
        navTile: "商店",
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png",
        announcement: [ {
            title: "全店包邮",
            src: "../../../style/images/icon1.png"
        }, {
            title: "先行赔付",
            src: "../../../style/images/icon2.png"
        }, {
            title: "七天无忧退款",
            src: "../../../style/images/icon3.png"
        } ],
        classify: [ "全部", "玫瑰", "康乃馨", "花器", "混合包月", "薰衣草", "薰衣草", "薰衣草" ],
        curIndex: 0,
        newList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        } ],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        app.editTabBar();
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = getCurrentPages(), n = a[a.length - 1].route;
        console.log("当前路径为:" + n), 0 < (i = t.tid) && (n = n + "?tid=" + i), console.log(n), 
        e.setData({
            current_url: n
        });
        var r = wx.getStorageSync("tab");
        console.log(r);
        var o = wx.getStorageSync("settings");
        console.log(o);
        var c = wx.getStorageSync("url");
        console.log(o.shop_banner), this.setData({
            tab: r,
            url: c,
            settings: o
        });
        var i = t.tid;
        null == i && (i = 0), e.setData({
            curIndex: i
        }), app.util.request({
            url: "entry/wxapp/TypeGoodList",
            cachetime: "0",
            data: {
                tid: i
            },
            success: function(t) {
                e.setData({
                    goodList: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Type",
            cachetime: "0",
            success: function(t) {
                console.log(t), e.setData({
                    typeData: t.data
                });
            }
        });
    },
    goTap: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 0 == e.data.current && wx.redirectTo({
            url: "../index/index?currentIndex=0"
        }), 1 == e.data.current && wx.redirectTo({
            url: "../shop/shop?currentIndex=1"
        }), 2 == e.data.current && wx.redirectTo({
            url: "../active/active?currentIndex=2"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../carts/carts?currentIndex=3"
        }), 4 == e.data.current && wx.redirectTo({
            url: "../user/user?currentIndex=4"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    navChange: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index), n = parseInt(t.currentTarget.dataset.id);
        e.setData({
            curIndex: a
        }), app.util.request({
            url: "entry/wxapp/TypeGoodList",
            cachetime: "0",
            data: {
                tid: n
            },
            success: function(t) {
                console.log(t), e.setData({
                    goodList: t.data
                });
            }
        });
    },
    toGoodsdet: function(t) {
        var e = parseInt(t.currentTarget.dataset.id);
        wx.navigateTo({
            url: "../index/goodsDet/goodsDet?gid=" + e
        });
    },
    toTab: function(t) {
        var e = t.currentTarget.dataset.url;
        e = "/" + e, wx.redirectTo({
            url: e
        });
    }
});