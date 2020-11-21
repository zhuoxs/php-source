var app = getApp();

Page({
    data: {
        statusType: [ "审核中", "进行中", "已结束" ],
        currentType: 0,
        tabClass: [ "", "", "" ]
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("url");
        this.setData({
            url: a
        });
    },
    statusTap: function(t) {
        var a = t.currentTarget.dataset.index;
        console.log(a), this.getBargain(a), this.setData({
            currentType: t.currentTarget.dataset.index
        });
    },
    getBargain: function(t) {
        var a = this, e = wx.getStorageSync("openid"), n = wx.getStorageSync("auth_type");
        app.util.request({
            url: "entry/wxapp/GetReleaseBargain",
            cachetime: "0",
            data: {
                currentType: t,
                openid: e,
                auth_type: n
            },
            success: function(t) {
                console.log(t), a.setData({
                    bargainList: t.data
                });
            }
        });
    },
    delBargain: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否确认删除？（此操作不可恢复）",
            success: function(t) {
                console.log(t), t.confirm ? app.util.request({
                    url: "entry/wxapp/delBargain",
                    cachetime: "0",
                    data: {
                        id: a
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
    lookBargain: function(t) {
        console.log(t), wx.navigateTo({
            url: "../../kanjia-list/details?id=" + t.currentTarget.dataset.id
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