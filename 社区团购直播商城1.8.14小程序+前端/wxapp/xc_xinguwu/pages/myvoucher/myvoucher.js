var app = getApp();

Page({
    data: {
        curIndex: 0,
        stausid: 1,
        selected: !1,
        voucher: null,
        currentTab: "",
        hidden: !0
    },
    bindTap: function(a) {
        var t = parseInt(a.currentTarget.dataset.index);
        this.setData({
            curIndex: t
        });
    },
    touser: function(a) {
        console.log("asfasdf");
        var t = a.currentTarget.dataset.index, e = this.data.newcard;
        console.log(t), console.log(e), 1 != e[t].outdate && wx.redirectTo({
            url: "../list/sale/sale"
        });
    },
    bindChange: function(a) {
        this.setData({
            currentTab: a.detail.current
        });
    },
    swichNav: function(a) {
        this.setData({
            currentTab: a.target.dataset.current
        });
    },
    myShow: function() {
        0 == this.data.hidden ? this.setData({
            hidden: !0
        }) : this.setData({
            hidden: !1
        });
    },
    onLoad: function(a) {
        app.look.navbar(this);
        var t = a.stausid;
        this.setData({
            stausid: t
        }), console.log(t);
        var s = this;
        if (s.setData({
            voucher_list_style: app.globalData.webset.voucher_list_style,
            voucher_list_diy: app.globalData.webset.voucher_list_diy,
            voucher_list_bg: app.globalData.webset.voucher_list_bg
        }), 1 == t && app.util.request({
            url: "entry/wxapp/my",
            cachetime: "30",
            showLoading: !0,
            method: "POST",
            data: {
                op: "mycard"
            },
            success: function(a) {
                var t = a.data;
                if (console.log(t), t.data.newcard) {
                    for (var e = t.data.newcard, d = new app.util.date(), o = 0, n = e.length; o < n; o++) d.dateToStr("YYYY.MM.dd") > e[o].date_end && (e[o].outdate = 1);
                    s.setData({
                        newcard: e
                    });
                }
                if (t.data.oldcard) {
                    var r = t.data.oldcard;
                    s.setData({
                        oldcard: r
                    });
                }
            }
        }), 2 == t) {
            var e = a.price;
            s.setData({
                mycard_id: a.mycard_id
            }), app.util.request({
                url: "entry/wxapp/goods",
                cachetime: "30",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "use_voucher",
                    price: e
                },
                success: function(a) {
                    console.log(a.data), a.data.data.card && s.setData({
                        usecard: a.data.data.card
                    });
                }
            });
        }
    },
    selectvoucher: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.usecard, d = {};
        if (-1 == t) app.voucher = null; else {
            var o, n = e[t].id, r = e[t].cid;
            "1" == r && (o = e[t].reduce), "2" == r && (o = e[t].replace), "3" == r && (o = e[t].discount), 
            d.id = n, d.cid = r, d.num = o, app.voucher = d;
        }
        wx.navigateBack({
            delta: 1
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});