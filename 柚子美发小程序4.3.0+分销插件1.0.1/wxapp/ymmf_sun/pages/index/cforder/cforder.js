Page({
    data: {
        navTile: "确认订单",
        goodsSrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152151553528.png",
        goodsName: "日式精细擦窗",
        price: "48.80",
        oldprice: "600",
        num: "1",
        totalPrice: "",
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        rstatus: ""
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var o = (a.data.price * a.data.num).toFixed(2);
        a.setData({
            totalPrice: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    showDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.utils(a);
    },
    utils: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationshowData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("500rpx").step(), this.setData({
                animationshowData: a
            }), "close" == t && this.setData({
                showStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showStatus: !0
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        this.setData({
            rstatus: a
        });
    },
    formSubmit: function(t) {}
});