var t = getApp();

Page({
    data: {
        FiterCur: 9,
        Page: 1,
        is_last: !1,
        list: []
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            uid: wx.getStorageSync("uid")
        }), a.list();
    },
    onPullDownRefresh: function() {
        var t = this;
        t.clean(), t.list(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var t = this;
        t.data.is_last || t.list();
    },
    navorder: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/pages/store/pages/takeDetail/index?id=" + a
        });
    },
    filterSelect: function(t) {
        var a = this;
        a.setData({
            FiterCur: t.currentTarget.dataset.id
        }), a.clean(), a.list();
    },
    clean: function() {
        this.setData({
            list: [],
            Page: 1,
            is_last: !1
        });
    },
    list: function(a) {
        var e = this, s = e.data.Page;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.takeList",
                page: s,
                status: e.data.FiterCur,
                uid: e.data.uid
            },
            success: function(t) {
                t.data.data.list.length < 1 && e.setData({
                    is_last: !0
                });
                for (var a = e.data.list, s = 0; s < t.data.data.list.length; s++) a.push(t.data.data.list[s]);
                e.setData({
                    list: a,
                    Page: e.data.Page + 1
                });
            }
        });
    }
});