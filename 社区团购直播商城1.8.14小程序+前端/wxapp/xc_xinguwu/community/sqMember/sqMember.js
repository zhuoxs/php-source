var app = getApp();

Page({
    data: {
        paeg: 1,
        pagesize: 20,
        loadend: !1
    },
    makePhoneCall: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.value
        });
    },
    search: function(a) {
        var t = a.detail.value;
        "" != t && app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadClubMember",
                club_id: that.data.options.club_id,
                page: 1,
                pagesize: that.data.pagesize,
                text: t
            },
            success: function(a) {
                var t = a.data;
                t.data.list && that.setData({
                    list: t.data.list,
                    loadend: !0
                });
            },
            fail: function(a) {
                app.look.no("没有查询到信息"), that.setData({
                    loadend: !0
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            options: a
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadClubMember",
                club_id: e.data.options.club_id,
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
    onReady: function() {
        var a = {};
        a.sq_gcall = app.module_url + "resource/wxapp/community/sq-gcall.png", a.sq_mem_pos = app.module_url + "resource/wxapp/community/sq-mem-pos.png", 
        this.setData({
            images: a
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        this.setData({
            searchValue: ""
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "loadClubMember",
                club_id: e.data.options.club_id,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
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
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "loadClubMember",
                    club_id: e.data.options.club_id,
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