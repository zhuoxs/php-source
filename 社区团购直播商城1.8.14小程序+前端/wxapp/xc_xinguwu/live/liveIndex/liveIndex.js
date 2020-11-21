var app = getApp();

Page({
    data: {
        state: 1,
        page: 1,
        pagesize: 12,
        loadend: !1,
        list: []
    },
    attention: function() {
        var t = -this.data.is_focus, e = this;
        app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "live_focus_change",
                id: e.data.options.id,
                status: t
            },
            success: function(a) {
                e.setData({
                    is_focus: t
                });
            }
        });
    },
    tofocus: function() {
        2 == this.data.options.style && wx.navigateTo({
            url: "../myHomepage/myHomepage?id=" + this.data.options.id + "&style=2"
        });
    },
    previewimgs: function(a) {
        wx.previewImage({
            current: this.data.list[a.currentTarget.dataset.index].contents.imgs[a.currentTarget.dataset.idx],
            urls: this.data.list[a.currentTarget.dataset.index].contents.imgs
        });
    },
    onLoad: function(a) {
        var e = this;
        a.style = a.style ? a.style : 1, e.setData({
            state: a.style
        }), e.setData({
            options: a
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "liveindex_getinfo",
                id: e.data.options.id,
                style: e.data.options.style
            },
            success: function(a) {
                var t = a.data;
                e.setData({
                    dynamic_num: t.data.dynamic_num,
                    focus_num: t.data.focus_num
                }), 1 == e.data.options.style && t.data.live && (console.log(t.data.live), e.setData({
                    live: t.data.live,
                    is_focus: t.data.is_focus,
                    nickname: t.data.nickname,
                    avatarurl: t.data.avatarurl
                }));
            }
        });
    },
    onReady: function() {
        var e = this;
        app.look.navbar(this);
        var a = {};
        a.m_remark = app.module_url + "resource/wxapp/live/m-remark.png", a.no_dynamic = app.module_url + "resource/wxapp/live/no-dynamic.png", 
        this.setData({
            images: a
        }), 2 == e.data.options.style && this.setData({
            nickname: app.globalData.userInfo.nickname,
            avatarurl: app.globalData.userInfo.avatarurl
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "load_liveindex",
                id: e.data.options.id,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});