var app = getApp();

Page({
    data: {
        statusType: [ "审核中", "进行中", "已拒绝" ],
        currentType: 0,
        tabClass: [ "", "", "" ]
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("url");
        this.setData({
            url: e
        });
    },
    statusTap: function(t) {
        var e = t.currentTarget.dataset.index;
        console.log(e), this.getGoods(e), this.setData({
            currentType: t.currentTarget.dataset.index
        });
    },
    getGoods: function(t) {
        var e = this, o = wx.getStorageSync("openid"), n = wx.getStorageSync("auth_type");
        app.util.request({
            url: "entry/wxapp/GetReleaseGoods",
            cachetime: "0",
            data: {
                currentType: t,
                openid: o,
                auth_type: n
            },
            success: function(t) {
                console.log(t), e.setData({
                    GoodsList: t.data
                });
            }
        });
    },
    delGoods: function(t) {
        var e = this;
        console.log(t);
        var o = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否确认删除？（此操作不可恢复）",
            success: function(t) {
                console.log(t), t.confirm ? app.util.request({
                    url: "entry/wxapp/delGoods",
                    cachetime: "0",
                    data: {
                        id: o
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data ? (wx.showToast({
                            title: "删除成功！"
                        }), setTimeout(function() {
                            e.onShow();
                        }, 2e3)) : wx.showToast({
                            title: "删除失败！",
                            icon: "none"
                        });
                    }
                }) : t.cancel;
            }
        });
    },
    lookGoods: function(t) {
        console.log(t), wx.navigateTo({
            url: "../../goods-detail/index?gid=" + t.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this.data.currentType;
        this.getGoods(t);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});