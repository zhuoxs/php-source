var t = new getApp(), a = t.util.url("entry/wxapp/funding") + "m=kundian_farm_plugin_funding";

Page({
    data: {
        curindex: 1,
        list: [],
        page: 1
    },
    onLoad: function(a) {
        this.getList(!1), t.util.setNavColor();
    },
    getList: function(t) {
        var n = this, e = this.data, i = e.page, s = (e.curindex, e.list);
        wx.request({
            url: a,
            data: {
                op: "getInvest",
                control: "index",
                page: i
            },
            success: function(a) {
                var e = a.data.listData;
                t ? (e.map(function(t) {
                    s.push(t);
                }), i = parseInt(i) + 1) : s = e, n.setData({
                    list: s,
                    page: i
                });
            }
        });
    },
    changeCurrent: function(t) {
        var a = t.currentTarget.dataset.curindex;
        this.setData({
            curindex: a
        });
    }
});