var app = getApp();

Page({
    data: {
        curIndex: 1,
        currentTab: "",
        hidden: !0,
        voucher: []
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        this.setData({
            currentTab: t.target.dataset.current
        });
    },
    myShow: function() {
        0 == this.data.hidden ? this.setData({
            hidden: !0
        }) : this.setData({
            hidden: !1
        });
    },
    bindTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    get_voucher: function(t) {
        var a = this, e = t.currentTarget.dataset.index, o = this.data.voucher, s = o[e].id;
        wx.showLoading({
            title: "领取中"
        }), 2 != o[e].status ? 1 == o[e].numlimt && o[e].num <= 0 ? wx.showToast({
            title: "已取完"
        }) : app.util.request({
            url: "entry/wxapp/index",
            showLoading: !1,
            method: "POST",
            data: {
                op: "get_voucher",
                id: s
            },
            success: function(t) {
                wx.showToast({
                    title: t.data.message
                }), o[e].status = 2, a.setData({
                    voucher: o
                });
            }
        }) : wx.showToast({
            title: "已领取"
        });
    },
    onLoad: function(t) {
        var d = this;
        d.setData({
            voucher_list_style: app.globalData.webset.voucher_list_style,
            voucher_list_diy: app.globalData.webset.voucher_list_diy,
            voucher_list_bg: app.globalData.webset.voucher_list_bg
        }), app.util.request({
            url: "entry/wxapp/my",
            cachetime: "30",
            showLoading: !0,
            method: "POST",
            data: {
                op: "voucher"
            },
            success: function(t) {
                var a = t.data;
                if (a.data.voucher) {
                    for (var e = a.data.voucher, o = new app.util.date(), s = a.data.mycard, n = 0, r = e.length; n < r; n++) if (e[n].status = 1, 
                    o.dateToStr("yyyy.MM.dd") > e[n].date_end && (e[n].outdate = 1), a.data.mycard) for (var u = 0, i = s.length; u < i; u++) e[n].id == s[u].voucherid && (e[n].status = 2) == s[u].voucherstatus && (e[n].useed = 1);
                    d.setData({
                        voucher: e
                    });
                }
            }
        });
    },
    touser: function() {
        wx.redirectTo({
            url: "../list/sale/sale"
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var d = this;
        app.util.request({
            url: "entry/wxapp/my",
            cachetime: "30",
            showLoading: !0,
            method: "POST",
            data: {
                op: "voucher"
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                if (a.data.voucher) for (var e = a.data.voucher, o = new app.util.date(), s = a.data.mycard, n = 0, r = e.length; n < r; n++) {
                    if (e[n].status = 1, o.dateToStr("yyyy.MM.dd") > e[n].date_end && (e[n].outdate = 1), 
                    a.data.mycard) for (var u = 0, i = s.length; u < i; u++) e[n].id == s[u].voucherid && (e[n].status = 2);
                    d.setData({
                        voucher: e
                    });
                }
            }
        });
    },
    onReachBottom: function() {}
});