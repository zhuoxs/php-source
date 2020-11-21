var t = getApp(), e = t.requirejs("core");

t.requirejs("jquery"), t.requirejs("biz/diyform"), t.requirejs("biz/goodspicker"), 
t.requirejs("foxui");

Page({
    data: {
        page: 1,
        list: [],
        defaults: {
            keywords: "",
            isrecommand: "",
            ishot: "",
            isnew: "",
            isdiscount: "",
            issendfree: "",
            istime: "",
            cate: "",
            order: "",
            by: "desc",
            merchid: 0
        }
    },
    onLoad: function(e) {
        var a = this;
        t.getCache("isIpx") ? a.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            options: e
        }) : a.setData({
            isIpx: !1,
            iphonexnavbar: "",
            options: e
        });
        a.data.options.id;
        a.getList();
    },
    getList: function() {
        var t = this;
        e.post("groups.list", {
            category: t.data.options.id,
            page: t.data.page
        }, function(e) {
            0 == e.error && (e.list.length <= 0 ? t.setData({
                res: e,
                empty: !0
            }) : t.setData({
                page: t.data.page + 1,
                res: e,
                list: t.data.list.concat(e.list),
                empty: !1
            }), e.list.length < e.pagesize && t.setData({
                loaded: !0
            }));
        });
    },
    onReachBottom: function() {
        this.data.loaded || this.data.res.list.length == this.data.total || this.getList();
    },
    bindSearch: function(t) {
        var a = this, i = t.detail.value;
        e.get("groups.list", {
            keyword: i
        }, function(t) {
            t.list.length <= 0 ? a.setData({
                empty: !0
            }) : a.setData({
                empty: !1
            }), a.setData({
                list: t.list
            });
        });
    },
    back: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onShareAppMessage: function() {}
});