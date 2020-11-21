var app = getApp();

Page({
    data: {
        navTile: "商品详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        showModalStatus: !1,
        totalprice: 48.8,
        goods: [],
        curGroup: [],
        num: 1,
        joinOn: "0",
        show: !1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var n = this;
        setInterval(function() {
            n.setData({
                curr: Date.now()
            });
        }, 1e3), wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var o = t.id, a = t.group_id;
        a && n.setData({
            joinOn: 1,
            group_id: a
        }), app.get_imgroot().then(function(t) {
            n.setData({
                imgroot: t
            }), app.get_store_info().then(function(t) {
                n.setData({
                    store: t
                }), app.util.request({
                    url: "entry/wxapp/GetGroupGoods",
                    cachetime: "0",
                    data: {
                        goods_id: o,
                        store_id: t.id
                    },
                    success: function(t) {
                        var o = t.data.info, a = JSON.parse(o.pics);
                        o.imgUrls = a, o.detail = o.content;
                        var i = t.data.list;
                        n.setData({
                            goods: [ o ],
                            curGroup: i
                        });
                    }
                });
            });
        }), t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id);
    },
    onReady: function() {},
    onShow: function() {
        console.log(this.data.curGroup);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var o = this.data.goods[0], a = wx.getStorageSync("users"), i = {};
        return i.title = o.title, i.path = "yzhyk_sun/pages/index/groupDet/groupDet?id=" + o.id + "&d_user_id=" + a.id, 
        i.success = function() {}, i.fail = function() {}, "button" === t.from && 1 == t.target.dataset.tag && (i.path = "yzhyk_sun/pages/index/groupjoin/groupjoin?id=" + this.data.group_id + "&d_user_id=" + a.id), 
        i;
    },
    formSubmit: function(t) {
        for (var o = this, a = (o.data.specConn, o.data.style), i = o.data.goods[0].spec, n = !0, e = 0; e < i.length; e++) if (0 == i[e].isChoose) {
            n = !1;
            break;
        }
        if (n) {
            if (1 == a) console.log("单独购买"), wx.navigateTo({
                url: "../cforder3/cforder3"
            }); else if (2 == a) {
                console.log("拼团");
                o.data.joinOn;
                o.setData({
                    joinOn: "1"
                });
            }
        } else wx.showModal({
            title: "",
            content: "请选择商品规格",
            showCancel: !1,
            success: function(t) {}
        });
    },
    toGroup: function(t) {
        var o = this.data.goods[0];
        app.group_cart_clear(), app.group_cart_add({
            id: o.id,
            price: o.price,
            src: o.pic,
            num: 1,
            title: o.title
        }), wx.navigateTo({
            url: "../cforder3/cforder3?group=1"
        });
    },
    toBuy: function(t) {
        var o = this.data.goods[0];
        app.group_cart_clear(), app.group_cart_add({
            id: o.goods_id,
            price: o.shopprice,
            src: o.pic,
            num: 1,
            title: o.title
        }), wx.navigateTo({
            url: "../cforder3/cforder3?group=0"
        });
    },
    toJoin: function(t) {
        var o = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/yzhyk_sun/pages/index/groupjoin/groupjoin?id=" + o
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    toGrouppro: function(t) {
        wx.navigateTo({
            url: "../groupPro/groupPro"
        });
    },
    showGroup: function(t) {
        this.setData({
            show: !this.data.show
        });
    }
});