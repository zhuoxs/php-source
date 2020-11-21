var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../../util/cart.js"), _cart2 = _interopRequireDefault(_cart), _pay = require("../../../util/pay.js"), _pay2 = _interopRequireDefault(_pay);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "提交订单",
        shopname: "百佳便利店",
        shopnum: "1300000000",
        shopPic: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152351792032.png",
        goods: [],
        times: "24小时内",
        address: "厦门市集美区杏林湾路",
        contact: "",
        startSince: "09:01",
        endSince: "21:01",
        sincetype: "0",
        distribution: "3.00",
        distributFee: "3.00",
        totalprice: "0",
        cardprice: "0",
        card_id: "0",
        curprice: "0",
        showModalStatus: !1,
        chooseAddress: {
            userName: "",
            telNumber: "",
            provinceName: "",
            cityName: "",
            countyName: "",
            detailInfo: ""
        },
        showRemark: 0,
        choose: [ {
            name: "微信",
            enable: !0,
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            enable: !0,
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: 0,
        payType: "",
        uremark: "",
        time: "",
        checked: !0,
        pay_finish: !1,
        is_enable: !1,
        is_enable_order: !0,
        enable_order_info: "",
        lng: 0,
        lat: 0
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = _cart2.default.totalPrice();
        e.setData({
            goods: _cart2.default.get(),
            totalprice: a
        });
        var i = this.data.choose;
        _request2.default.get("getOrderCoupon", {
            store_id: _cart2.default.getStoreId(),
            amount: a
        }).then(function(t) {
            console.log(t), i[1].enable = t.user_amount_enable, 0 == t.is_enable_order && wx.showModal({
                title: "提示",
                content: t.enable_order_info,
                showCancel: !0
            }), e.setData({
                cards: t.cards,
                shopname: t.store.name,
                shopnum: t.store.phone,
                shopPic: t.store.main_image,
                address: t.store.address,
                distribution: t.distribution,
                distributFee: t.distribution,
                cardprice: t.use_coupon.amount,
                card_id: t.use_coupon.coupon_id,
                choose: i,
                is_enable_order: t.is_enable_order,
                enable_order_info: t.enable_order_info
            }), e.update();
        });
    },
    update: function() {
        console.log(this.data);
        var t = parseFloat(this.data.totalprice) + parseFloat(this.data.distributFee);
        this.data.checked && (t -= parseFloat(this.data.cardprice)), this.setData({
            curprice: t.toFixed(2)
        });
    },
    onReady: function() {},
    onShow: function() {
        console.log("onShow"), this.data.pay_finish && setTimeout(function() {
            wx.reLaunch({
                url: "../../user/user?redirect=order"
            });
        }, 500);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindTimeChange: function(t) {
        this.setData({
            time: t.detail.value
        });
    },
    chooseType: function(t) {
        var e = t.currentTarget.dataset.type, a = this, i = a.data.distribution;
        "1" == e ? a.setData({
            distributFee: 0
        }) : a.setData({
            distributFee: i
        }), a.setData({
            sincetype: e
        }), this.update();
    },
    powerDrawer: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e);
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("550rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(t) {
        var e = parseFloat(t.currentTarget.dataset.price), a = t.currentTarget.dataset.id, i = parseFloat(this.data.totalprice) + parseFloat(this.data.distributFee) - parseFloat(e);
        i < 0 && (i = 0), this.setData({
            curprice: i.toFixed(2),
            cardprice: e,
            card_id: a
        });
        this.util("close");
    },
    showModel: function(t) {
        var e = t.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: e
        });
    },
    showPay: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.setData({
            payStatus: e
        });
    },
    remark: function(t) {
        var e = t.detail.value;
        if (20 < e.length) return e = e.substr(0, 20), void wx.showModal({
            title: "提示",
            content: "不得超过20字",
            showCancel: !0
        });
        this.setData({
            uremark: e
        });
    },
    radioChange: function(t) {
        var e = t.detail.value;
        console.log(e), this.setData({
            payType: e
        });
    },
    toAddress: function(t) {
        var a = this;
        wx.chooseAddress ? wx.chooseAddress({
            success: function(t) {
                a.setData({
                    chooseAddress: t
                });
                var e = {};
                e.address = t.provinceName + t.cityName + t.countyName + t.detailInfo, e.store_id = _cart2.default.getStoreId(), 
                e.amount = a.data.totalprice, _request2.default.get("getDistanceFromAddress", e).then(function(t) {
                    console.log(t), t.is_enable ? (a.setData({
                        is_enable: t.is_enable,
                        distribution: t.distribution,
                        distributFee: t.distribution,
                        lng: t.lng,
                        lat: t.lat
                    }), a.update()) : (a.setData({
                        is_enable: t.is_enable
                    }), wx.showModal({
                        title: "提示",
                        content: "送货地址超过配送范围,无法配送",
                        showCancel: !1
                    }));
                });
            },
            fail: function(t) {
                console.log(JSON.stringify(t));
            }
        }) : console.log("当前微信版本不支持chooseAddress");
    },
    checkboxChange: function() {
        console.log(this.data.checked), this.setData({
            checked: !this.data.checked
        }), this.update();
    },
    formSubmit: function(t) {
        var e = this, a = !0, i = "", s = this, o = s.data.sincetype, r = (s.data.distributFee, 
        s.data.payType), n = s.data.time, d = s.data.uremark, c = s.data.chooseAddress.userName, u = t.detail.formId;
        if ("0" == o ? "" == r ? i = "请选择支付方式" : "" == c ? i = "请选择送货地址" : a = "false" : "1" == o && ("" == n || null == n ? i = "请选择自提时间" : /^1(3|4|5|7|8)\d{9}$/.test(t.detail.value.tel) ? "" == r ? i = "请选择支付方式" : a = "false" : i = "请输入自提电话"), 
        1 == a) wx.showModal({
            title: "提示",
            content: i,
            showCancel: !1
        }); else {
            var l = {};
            l.store_id = wx.getStorageSync("storeId"), l.distribution_amount = this.data.distributFee, 
            s.data.checked ? (l.coupon_id = this.data.card_id, l.pay_amount = this.data.curprice, 
            l.amount = parseFloat(l.pay_amount) + parseFloat(this.data.cardprice)) : (l.coupon_id = 0, 
            l.pay_amount = this.data.curprice, l.amount = parseFloat(l.pay_amount)), l.form_id = u, 
            l.distribution_type = this.data.sincetype, l.take_time = this.data.time, l.remark = d, 
            l.pay_type = "微信" == this.data.payType ? 0 : 1, l.goods = this.data.goods, 0 == o ? (l.address = this.data.chooseAddress, 
            l.take_tel = "") : (l.address = "", l.take_tel = t.detail.value.tel), l.lng = this.data.lng, 
            l.lat = this.data.lat, console.log(l), _request2.default.post("postOrder", l).then(function(t) {
                console.log(t), _cart2.default.clear(), 1 == t.payed || 0 == t.payed && 1 == t.pay_type ? wx.reLaunch({
                    url: "../../user/user?redirect=order"
                }) : _pay2.default.pay(t.sn).then(function(t) {
                    console.log("pay success!"), e.setData({
                        pay_finish: !0
                    });
                }, function(t) {
                    console.log("pay fail!");
                });
            });
        }
    }
});