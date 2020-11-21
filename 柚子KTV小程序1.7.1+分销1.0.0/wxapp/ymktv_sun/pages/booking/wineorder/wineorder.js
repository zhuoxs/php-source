var app = getApp();

Page({
    data: {
        navIndex: 0,
        playBtn: !1,
        shopNum: ""
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("url");
        this.setData({
            url: e
        }), t.navIndex && this.setData({
            navIndex: t.navIndex
        });
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/keepwineData",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    Dkeep: t.data.Dkeep,
                    Ykeep: t.data.Ykeep,
                    extwine: t.data.extwine
                });
            }
        });
    },
    changeNav: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            navIndex: e
        });
    },
    closeList: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = e.data.Dkeep, i = n[a].id;
        wx.showModal({
            title: "提示",
            content: "确定删除订单？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/delkeepwine",
                    cachetime: "0",
                    data: {
                        id: i
                    },
                    success: function(t) {
                        n.splice(a, 1), e.setData({
                            Dkeep: n
                        });
                    }
                });
            }
        });
    },
    closeList1: function(t) {
        var e = this, a = t.currentTarget.dataset.index;
        console.log(t);
        var n = e.data.Ykeep, i = n[a].id;
        wx.showModal({
            title: "提示",
            content: "确定删除订单？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/delkeepwine",
                    cachetime: "0",
                    data: {
                        id: i
                    },
                    success: function(t) {
                        n.splice(a, 1), e.setData({
                            Ykeep: n
                        });
                    }
                });
            }
        });
    },
    closeList2: function(t) {
        var e = this, a = t.currentTarget.dataset.index;
        console.log(t);
        var n = e.data.extwine, i = n[a].id;
        wx.showModal({
            title: "提示",
            content: "确定删除订单？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/delkeepwine",
                    cachetime: "0",
                    data: {
                        id: i
                    },
                    success: function(t) {
                        n.splice(a, 1), e.setData({
                            extwine: n
                        });
                    }
                });
            }
        });
    },
    pickUp: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.Ykeep[e].id;
        this.setData({
            playBtn: !0,
            list2Index: e,
            wine_id: a
        });
    },
    closePlay: function(t) {
        this.setData({
            playBtn: !1
        });
    },
    shopNumInput: function(t) {
        this.setData({
            shopNum: t.detail.value
        });
    },
    textInput: function(t) {
        this.setData({
            textData: t.detail.value
        });
    },
    goDetails: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../../my/extractList/extractList?id=" + e
        });
    },
    submit: function() {
        var e = this;
        console.log(e.data);
        var t = e.data.shopNum, a = e.data.textData, n = e.data.wine_id, i = wx.getStorageSync("openid");
        if ("" == t) return wx.showToast({
            icon: "none",
            title: "包厢号不能为空"
        }), !1;
        app.util.request({
            url: "entry/wxapp/extractWine",
            cachetime: "0",
            data: {
                id: n,
                openid: i,
                room_num: t,
                remark: a
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? (wx.showToast({
                    title: "提取成功，请稍后！",
                    icon: "success",
                    duration: 2e3
                }), e.setData({
                    playBtn: !1,
                    deleteBtn: !0
                }), e.deleteList()) : wx.showToast({
                    title: "提取失败！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    deleteList: function() {
        var t = this, e = t.data.deleteBtn, a = t.data.list2Index, n = t.data.Ykeep;
        1 == e && (n.splice(a, 1), t.setData({
            Ykeep: n
        }), t.onShow());
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});