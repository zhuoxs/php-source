var t = getApp(), s = t.requirejs("core");

t.requirejs("jquery"), t.requirejs("foxui");

Page({
    data: {
        showtab: "do",
        success: "",
        page: 1,
        list: []
    },
    onLoad: function(s) {
        var e = this;
        t.getCache("isIpx") ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), this.get_list();
    },
    get_list: function(t) {
        var e = this;
        s.get("groups/team", {
            success: e.data.success,
            page: e.data.page
        }, function(t) {
            0 == t.error && (e.setData({
                list: e.data.list.concat(t.list)
            }), wx.stopPullDownRefresh());
        });
    },
    tab: function(t) {
        this.data.success != t.target.dataset.success && (this.setData({
            success: t.target.dataset.success,
            page: 1,
            list: []
        }), this.get_list());
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.setData({
            page: 1,
            list: []
        }), this.get_list();
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.get_list();
    },
    onShareAppMessage: function() {},
    selected: function(t) {
        this.setData({
            showtab: t.currentTarget.dataset.type
        });
    }
});