var app = getApp();

function qrcode(a) {
    return require("../../../utils/wxqrcode.js").createQrCodeImg(a, {
        size: 300
    });
}

Page({
    data: {
        curIndex: 1,
        page: 1,
        pagesize: 15,
        loadend: !1,
        drawMethod: !1,
        taokouling: "12345678",
        method: 1
    },
    changeNav: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            curIndex: t,
            list: []
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "loadLotteryCenter",
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    makePhoneCall: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.value
        });
    },
    openLocation: function(a) {
        var t = this.data.index, e = this.data.list;
        console.log(e), wx.openLocation({
            latitude: parseFloat(e[t].address.lat),
            longitude: parseFloat(e[t].address.lng)
        });
    },
    changeMethod: function(a) {
        var t = a.currentTarget.dataset.index;
        if (this.setData({
            method: t
        }), 2 == t && null == this.data.location) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/index",
                showLoading: !0,
                data: {
                    op: "getLocation"
                },
                success: function(a) {
                    e.setData({
                        location: a.data.data
                    });
                }
            });
        }
    },
    drawAward: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.list, d = e[t].type;
        if (1 == d) this.setData({
            drawMethod: !0,
            index: t
        }); else {
            var o = this;
            app.util.request({
                url: "entry/wxapp/lottery",
                showLoading: !1,
                data: {
                    op: "drawAward",
                    id: e[t].id
                },
                success: function(a) {
                    app.look.ok(a.data.message), 3 != d && 4 != d || (app.globalData.userInfo = a.data.data), 
                    1 == this.data.curIndex && (e.splice(t, 1), o.setData({
                        list: e
                    }));
                },
                fail: function(a) {
                    app.look.no(a.data.message);
                }
            });
        }
    },
    confirmReceive: function() {
        var e = this;
        1 != this.data.method || null != this.data.address ? 2 != this.data.method || null != this.data.location ? app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "confirmReceive",
                id: e.data.list[e.data.index].id,
                method: e.data.method,
                address: e.data.address,
                location: e.data.location
            },
            success: function(a) {
                if (app.look.ok(a.data.message), 1 == e.data.curIndex) {
                    var t = e.data.list;
                    t.splice(e.data.index, 1), e.setData({
                        list: t,
                        drawMethod: !1
                    });
                }
            }
        }) : app.look.alert("请切换领取方式") : app.look.alert("请选择地址");
    },
    toCaddress: function() {
        wx.navigateTo({
            url: "/xc_xinguwu/pages/caddress/caddress"
        });
    },
    close: function(a) {
        this.setData({
            drawMethod: !1,
            verificationCode: !1
        });
    },
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "loadLotteryCenter",
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (console.log(t.data.list), e.setData({
                    list: t.data.list
                }));
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        this.setData({
            address: app.address
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "loadLotteryCenter",
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && (console.log(t.data.list), e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                }));
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    verificationCode: function(a) {
        console.log(a), this.setData({
            verificationCode: !0,
            index: a.currentTarget.dataset.index,
            qrcode: qrcode(this.data.list[a.currentTarget.dataset.index].hex + "," + this.data.list[a.currentTarget.dataset.index].id)
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/lottery",
                showLoading: !0,
                data: {
                    op: "loadLotteryCenter",
                    curIndex: e.data.curIndex,
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});