var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, app = getApp();

Page({
    data: {
        navTile: "商品详情",
        showModalStatus: !1,
        join: 0,
        imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png",
        title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
        price: "100",
        minPrice: "68",
        surplus: "100",
        startTime: "2017-12-12 00:00:00",
        endTime: "2018-01-12 00:00:00",
        imgArr: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png" ],
        bargainList: {
            endTime: "1529519898765",
            clock: ""
        },
        clock: "",
        isIpx: app.globalData.isIpx
    },
    onLoad: function(e) {
        var i = this;
        setInterval(function() {
            i.setData({
                curr: Date.now()
            });
        }, 1e3);
        wx.setNavigationBarTitle({
            title: i.data.navTile
        }), app.get_imgroot().then(function(o) {
            app.get_user_info().then(function(a) {
                app.get_store_info().then(function(t) {
                    i.setData({
                        imgroot: o,
                        user: a,
                        store: t,
                        storecutgoods_id: e.id
                    }), i.updatePageData();
                });
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var a = this, o = a.data.goods, e = a.data.cut_info, i = a.data.user, n = {};
        return n.title = o.title, n.path = "yzhyk_sun/pages/index/help/help?id=" + e.id + "&d_user_id=" + i.id, 
        n.success = function() {
            console.log("成功");
        }, n.fail = function() {
            console.log("失败");
        }, n;
    },
    order: function(t) {},
    bargain: function(t) {},
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
        var o = t.currentTarget.dataset.join;
        this.setData({
            join: o
        });
        var e = this, i = (e.data.store, e.data.goods, e.data.user), n = e.data.storecutgoods_id;
        app.util.request({
            url: "entry/wxapp/AddCut",
            cachetime: "0",
            data: {
                storecutgoods_id: n,
                user_id: i.id
            },
            success: function(t) {
                e.setData({
                    cut_id: t.data.cut_id,
                    cut_price: t.data.cut_price
                }), e.updatePageData();
            }
        });
    },
    powerDrawer2: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
        var o = t.currentTarget.dataset.join;
        this.setData({
            join: o
        });
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
            a.opacity(1).height("488rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    help: function(t) {
        wx.updateShareMenu({
            withShareTicket: !0,
            success: function() {}
        });
    },
    toCforder: function(t) {
        var a = this, o = a.data.goods, e = a.data.cut_info, i = a.data.storecutgoods_id;
        app.group_cart_clear(), app.group_cart_add({
            id: i,
            price: parseFloat(o.shopprice - e.cut_price, 2),
            src: o.pic,
            num: 1,
            title: o.title
        }), wx.redirectTo({
            url: "../cforder3/cforder3?iscut=1&cut_id=" + e.id
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index"
        });
    },
    updatePageData: function() {
        var i = this, t = i.data.storecutgoods_id, a = i.data.store, o = i.data.user;
        app.util.request({
            url: "entry/wxapp/GetCutGoods",
            cachetime: "0",
            data: {
                storecutgoods_id: t,
                store_id: a.id,
                user_id: o.id
            },
            success: function(t) {
                var a = t.data.cut_info, o = t.data.list, e = t.data.info;
                console.log("------------------------"), console.log(e.pics), console.log(_typeof(JSON.parse(e.pics))), 
                e.imgUrls = JSON.parse(e.pics), e.detail = e.content, i.setData({
                    goods: e,
                    join: a ? 1 : 0,
                    cut_list: o,
                    cut_info: a,
                    code: t.data.code
                });
            }
        });
    }
});