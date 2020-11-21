var app = getApp();

Page({
    data: {
        goods: {
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "3",
            userNum: 5,
            status: 2
        },
        guarantee: [ "正品保障", "超时赔付", "7天无忧退货" ],
        user: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg" ]
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = t.order_id;
        o.setData({
            order_id: a
        }), console.log("获取拼单详情"), app.util.request({
            url: "entry/wxapp/getGroupsDetail",
            cachetime: "0",
            data: {
                order_id: a
            },
            success: function(t) {
                console.log(t.data.data.goodsdetail), o.setData({
                    groupsdetail: t.data.data
                });
            }
        }), o.urls();
    },
    urls: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var o = this.data.order_id, a = this.data.groupsdetail.goodsdetail.goods_name;
        return "button" === t.from && console.log(t.target), {
            title: a,
            path: "yzmdwsc_sun/pages/index/groupjoin/groupjoin?order_id=" + o,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    toGrouppro: function(t) {
        wx.navigateTo({
            url: "../../index/groupPro/groupPro"
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});