var app = getApp();

Page({
    data: {
        swiperIndex: 0,
        curIndex: 0,
        page: 1,
        pagesize: 15,
        loadend: !1,
        value: ""
    },
    toDetail: function() {
        wx.navigateTo({
            url: "../liveDetail/liveDetail"
        });
    },
    swiperChange: function(a) {
        this.setData({
            swiperIndex: a.detail.current
        });
    },
    ipt: function(a) {
        this.setData({
            value: a.detail.value
        });
    },
    clear: function() {
        this.setData({
            value: ""
        });
    },
    tolink: function(a) {
        console.log(a);
    },
    tofouus: function() {
        wx.navigateTo({
            url: "../myHomepage/myHomepage?style=1"
        });
    },
    search: function() {
        var t = this;
        t.data.value;
        t.data.loadend = !1, app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            data: {
                op: "get_live_list",
                search: t.data.value,
                curIndex: t.data.curIndex,
                page: 1,
                pagesize: t.data.pagesize
            },
            success: function(a) {
                var e = a.data;
                t.setData({
                    list: e.data.list,
                    page: 1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), t.setData({
                    loadend: !0,
                    list: []
                });
            },
            complete: function() {}
        });
    },
    bindTap: function(a) {
        var e = a.currentTarget.dataset.index;
        this.setData({
            curIndex: e,
            list: []
        });
        var t = this;
        app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            data: {
                op: "get_live_list",
                search: t.data.value,
                curIndex: t.data.curIndex,
                page: 1,
                pagesize: t.data.pagesize
            },
            success: function(a) {
                var e = a.data;
                e.data.list && t.setData({
                    list: e.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), t.setData({
                    loadend: !0
                });
            }
        });
    },
    onLoad: function(a) {
        var t = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), 1 != app.globalData.webset.live && app.look.no("未开放", function() {
            wx.reLaunch({
                url: "../index/index"
            });
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "get_live_ppt"
            },
            success: function(a) {
                var e = a.data;
                console.log(e.data.ppt), e.data.ppt && t.setData({
                    ppt: e.data.ppt
                });
            }
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "get_live_list",
                search: t.data.value,
                curIndex: t.data.curIndex,
                page: t.data.page,
                pagesize: t.data.pagesize
            },
            success: function(a) {
                console.log(a);
                var e = a.data;
                e.data.list && (console.log(e.data.list), t.setData({
                    list: e.data.list
                }));
            },
            fail: function(a) {
                console.log(a), app.look.alert(a.data.message), t.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {
        var a = {};
        a.list_num = app.module_url + "resource/wxapp/live/list_num.png", a.list_com = app.module_url + "resource/wxapp/live/list_com.png", 
        this.setData({
            images: a,
            live_playback: app.globalData.webset.live_playback
        }), app.look.accredit(this);
    },
    onGotUserInfo: function(a) {
        app.look.getuserinfo(a, this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (!this.data.loadend) {
            var t = this;
            app.util.request({
                url: "entry/wxapp/live",
                method: "POST",
                data: {
                    op: "get_live_list",
                    search: t.data.value,
                    curIndex: t.data.curIndex,
                    page: t.data.page + 1,
                    pagesize: t.data.pagesize
                },
                success: function(a) {
                    var e = a.data;
                    e.data.list && t.setData({
                        list: t.data.list.concat(e.data.list),
                        page: t.data.page + 1
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), t.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    onShareAppMessage: function() {
        var a = "/xc_xinguwu/live/liveList/liveList";
        return a = encodeURIComponent(a), {
            title: "小程序" + app.globalData.webset.webname + "直播列表",
            path: "/xc_xinguwu/pages/base/base?share=" + a + "&userid=" + app.globaldata.userInfo.id,
            success: function() {
                app.look.alert("转发成功");
            }
        };
    }
});