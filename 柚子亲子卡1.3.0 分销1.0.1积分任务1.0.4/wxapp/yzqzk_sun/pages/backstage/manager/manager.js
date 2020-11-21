var app = getApp();

Page({
    data: {
        manager: [],
        id: "",
        searchFlag: !1,
        isRequest: 0
    },
    onLoad: function(t) {
        this.setData({
            store_id: t.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("setting");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), this.getHxStaff();
    },
    getHxStaff: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getHxstaff",
            cachetime: "0",
            data: {
                store_id: e.data.store_id
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    hxstaff: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    enterInput: function(t) {
        this.setData({
            id: t.detail.value
        });
    },
    submit: function(t) {
        var e = this, a = e.data.id;
        console.log(a), "" == a ? wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "id不得为空"
        }) : app.util.request({
            url: "entry/wxapp/getUserXz",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(t) {
                e.setData({
                    user: t.data,
                    searchFlag: !0
                });
            }
        });
    },
    toDelete: function(t) {
        var e = this, a = t.currentTarget.dataset.name, o = t.currentTarget.dataset.id;
        t.currentTarget.dataset.index;
        wx.showModal({
            title: "",
            content: "确定删除核销员：" + a,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/delHxstaff",
                    cachetime: "0",
                    data: {
                        id: o
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "删除成功",
                            icon: "none"
                        }), e.getHxStaff();
                    }
                });
            }
        });
    },
    toAdd: function(t) {
        console.log(t);
        var e = this, a = t.currentTarget.dataset.openid;
        e.setData({
            isRequest: ++e.data.isRequest
        }), 1 == e.data.isRequest ? app.util.request({
            url: "entry/wxapp/setHxstaff",
            cachetime: "0",
            data: {
                openid: a,
                store_id: e.data.store_id
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: "添加成功",
                    showCancel: !1,
                    success: function(t) {
                        e.getHxStaff(), e.setData({
                            searchFlag: !1
                        });
                    }
                });
            },
            complete: function(t) {
                e.setData({
                    isRequest: 0
                });
            }
        }) : wx.showToast({
            title: "正在请求中...",
            icon: "none"
        });
    }
});