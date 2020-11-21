var app = getApp(), id_of_settimtout = "";

Page({
    data: {
        curIndex: 0,
        page: 1,
        pagesize: 20,
        loadend: !1,
        nodata: !1,
        list: null
    },
    bindTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a,
            nodata: !1
        }), clearTimeout(id_of_settimtout), app.util.request({
            url: "entry/wxapp/group",
            showLoading: !0,
            data: {
                op: "get_mygroup",
                page: 1,
                pagesize: e.data.pagesize,
                status: e.data.curIndex
            },
            success: function(t) {
                var a = t.data;
                a.data.list && e.countDown(a.data.list), e.setData({
                    loadend: !1
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0,
                    nodata: !0,
                    list: null
                });
            }
        });
    },
    timeFormat: function(t) {
        return t < 10 ? "0" + t : t;
    },
    onLoad: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/group",
            showLoading: !1,
            data: {
                op: "get_mygroup",
                page: e.data.page,
                pagesize: e.data.pagesize,
                status: e.data.curIndex
            },
            success: function(t) {
                var a = t.data;
                console.log(a), a.data.list && e.countDown(a.data.list);
            },
            fail: function() {
                e.setData({
                    loadend: !0,
                    nodata: !0
                });
            }
        });
    },
    countDown: function(t) {
        for (var a = new Date().getTime(), e = 0, o = t.length; e < o; e++) if (1 == t[e].status) {
            var s = new Date(app.look.change_date(t[e].endtime)).getTime(), n = null;
            if (0 < s - a) {
                var i = (s - a) / 1e3, u = parseInt(i / 86400), d = parseInt(i % 86400 / 3600), r = parseInt(i % 86400 % 3600 / 60), p = parseInt(i % 86400 % 3600 % 60);
                n = {
                    day: this.timeFormat(u),
                    hou: this.timeFormat(d),
                    min: this.timeFormat(r),
                    sec: this.timeFormat(p)
                };
            } else n = {
                day: "00",
                hou: "00",
                min: "00",
                sec: "00"
            }, t[e].status = 3;
            t[e].countDownArr = n;
        }
        this.setData({
            list: t
        });
        var l = this;
        id_of_settimtout = setTimeout(function() {
            l.countDown(t);
        }, 1e3);
    },
    onReady: function() {
        app.look.group_footer(this), app.look.navbar(this), app.look.accredit(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/group",
            showLoading: !1,
            data: {
                op: "get_mygroup",
                page: 1,
                pagesize: e.data.pagesize,
                status: e.data.curIndex
            },
            success: function(t) {
                console.log(t), wx.stopPullDownRefresh();
                var a = t.data;
                a.data.list && (e.setData({
                    list: a.data.list
                }), clearTimeout(id_of_settimtout), e.countDown(a.data.list), e.setData({
                    page: 1,
                    loadend: !1
                }));
            },
            fail: function() {
                console.log("ccc"), e.setData({
                    loadend: !0,
                    list: null,
                    nodata: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        e.data.loadend || app.util.request({
            url: "entry/wxapp/group",
            showLoading: !1,
            data: {
                op: "get_mygroup",
                page: e.data.page + 1,
                pagesize: e.data.pagesize,
                status: e.data.curIndex
            },
            success: function(t) {
                var a = t.data;
                a.data.list && (clearTimeout(id_of_settimtout), e.countDown(e.data.list.concat(a.data.list))), 
                e.setData({
                    page: e.data.page + 1
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onShareAppMessage: function(t) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var a = "";
        if ("button" == t.from) {
            var e = t.target.dataset.index, o = this.data.list[e].group_sponsor_id;
            return a = "../groupdetail/groupdetail?id=" + this.data.list[e].list[0].group_id + "&style=2&sponsor_id=" + o, 
            a = encodeURIComponent(a), console.log("cccccccc"), console.log("/xc_xinguwu/pages/base/base?share=" + a + "&userid=" + app.globalData.userInfo.id), 
            {
                title: "你的朋友邀请您一起参加",
                path: "/xc_xinguwu/pages/base/base?share=" + a + "&userid=" + app.globalData.userInfo.id,
                imageUrl: this.data.list[e].list.img,
                success: function(t) {
                    wx.showToast({
                        title: "转发成功"
                    });
                },
                fail: function(t) {}
            };
        }
    },
    onGotUserInfo: function(t) {
        app.look.getuserinfo(t, this);
    }
});