var app = getApp();

Component({
    properties: {
        hiddenFloat: {
            type: Boolean,
            value: !0,
            _hiddenFloat: function(t, a, n) {}
        }
    },
    data: {
        hiddenBtn: !1
    },
    methods: {
        hiddenBtn: function() {
            this.setData({
                hiddenBtn: !this.data.hiddenBtn
            });
        },
        toLink: function(t) {
            wx.redirectTo({
                url: t.currentTarget.dataset.link
            });
        },
        toTop: function() {
            wx.pageScrollTo({
                scrollTop: 0
            });
        },
        updateUserinfo: function(t) {
            app.util.request({
                url: "entry/wxapp/index",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "get_userinfo"
                },
                success: function(t) {
                    app.look.ok("更新完成"), app.globalData.userInfo = t.data.data.userinfo;
                }
            });
        },
        _hiddenFloat: function(t, a, n) {
            this.setData({
                changePath: t
            });
        }
    },
    lifetimes: {
        created: function() {},
        attached: function() {
            var a = this;
            null == app.floaticon ? app.util.request({
                url: "entry/wxapp/index",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "floaticon"
                },
                success: function(t) {
                    a.setData({
                        floaticon: t.data.data.list
                    }), app.floaticon = t.data.data.list;
                }
            }) : a.setData({
                floaticon: app.floaticon
            });
        }
    }
});