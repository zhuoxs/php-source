var app = getApp();

Page({
    data: {
        statusType: [ "审核中", "进行中", "已结束" ],
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
        console.log(e), this.getBargain(e), this.setData({
            currentType: t.currentTarget.dataset.index
        });
    },
    lookGroups: function(t) {
        console.log(t), wx.navigateTo({
            url: "../../pintuan-list/details?id=" + t.currentTarget.dataset.id
        });
    },
    getBargain: function(t) {
        var e = this, n = wx.getStorageSync("openid"), a = wx.getStorageSync("auth_type");
        app.util.request({
            url: "entry/wxapp/GetReleaseGroups",
            cachetime: "0",
            data: {
                currentType: t,
                openid: n,
                auth_type: a
            },
            success: function(t) {
                console.log(t), e.setData({
                    groupsList: t.data
                });
            }
        });
    },
    delGroups: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否确认删除？（此操作不可恢复）",
            success: function(t) {
                console.log(t), t.confirm ? app.util.request({
                    url: "entry/wxapp/delGroups",
                    cachetime: "0",
                    data: {
                        id: e
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data ? (wx.showToast({
                            title: "删除成功！"
                        }), setTimeout(function() {
                            that.onShow();
                        }, 2e3)) : wx.showToast({
                            title: "删除失败！",
                            icon: "none"
                        });
                    }
                }) : t.cancel;
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this.data.currentType;
        this.getBargain(t);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});