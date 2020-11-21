var app = getApp();

Page({
    data: {
        address: [],
        hasList: !1,
        isChecked: !1,
        color: "#9c9c9c"
    },
    onShow: function() {
        app.look.navbar(this);
        var t = this;
        app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            data: {
                op: "address"
            },
            success: function(a) {
                var s = a.data;
                !s.errno && s.data.list && t.setData({
                    address: s.data.list,
                    hasList: !0
                });
            }
        });
    },
    addAddre: function(a) {
        wx.navigateTo({
            url: "../addAddress/addAddress"
        });
    },
    chooseCatalog: function(a) {
        var s = a.currentTarget.dataset.index, t = this.data.address;
        app.address = t[s], wx.navigateBack({
            delta: 1
        });
    },
    onReady: function() {
        app.look.navbar(this);
    }
});