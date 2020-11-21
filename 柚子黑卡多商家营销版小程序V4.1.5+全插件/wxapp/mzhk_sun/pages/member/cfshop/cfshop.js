Page({
    data: {
        navTile: "提交订单",
        shopname: "百佳便利店",
        shopnum: "1300000000",
        shopPic: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152351792032.png",
        goods: [ {
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152351792037.png",
            title: "银鹭花生牛奶",
            price: "11.00",
            num: "3"
        } ],
        times: "24小时内",
        address: "厦门市集美区杏林湾路",
        totalprice: "99.70",
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        cards: [ {
            price: "30",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        }, {
            price: "10",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        } ],
        showRemark: 0,
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        } ],
        payStatus: 0,
        payType: "",
        orderNum: "1111111111111",
        orderTime: "2018-02-02 10:30"
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = a.data.totalprice, i = parseFloat(e);
        a.setData({
            curprice: i
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("550rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(t) {
        var a = this, e = t.currentTarget.dataset.price, i = a.data.totalprice, o = parseFloat(i) - parseFloat(e);
        console.log(i), o < 0 && (o = 0), a.setData({
            cardprice: e,
            curprice: o
        }), a.util("close");
    },
    showPay: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.setData({
            payStatus: a
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    formSubmit: function(t) {
        var a = !0, e = "", i = this.data.payType;
        this.data.time;
        "" == i ? e = "请选择支付方式" : a = "false", 1 == a && wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    toAddress: function() {
        var a = this;
        wx.chooseAddress({
            success: function(t) {
                console.log("获取地址成功"), a.setData({
                    address: t,
                    hasAddress: !0
                });
            },
            fail: function(t) {
                console.log("获取地址失败");
            }
        });
    }
});