var app = getApp();

Page({
    data: {
        currentTab: 0,
        setinterval: "",
        have_data: !1,
        current: null,
        currentFriend: null,
        start: null,
        end: null,
        startFriend: null,
        endFriend: null,
        list: [],
        haoyou_list: [],
        footer: {
            footdex: 0,
            txtcolor: "#A2A2A2",
            seltxt: "#EC6464",
            background: "#fff",
            list: []
        }
    },
    switch_tab: function(t) {
        this.setData({
            currentTab: t.currentTarget.dataset.index
        });
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "../liao_detail/liao_detail?tid=" + t.currentTarget.dataset.tid + "&fid=" + t.currentTarget.dataset.fid + "&name=" + t.currentTarget.dataset.name
        });
    },
    del: function(t) {
        var a = this, e = a.data.list, n = t.currentTarget.dataset.id, r = t.currentTarget.dataset.fid, i = t.currentTarget.dataset.tid;
        wx.showModal({
            title: "提示",
            content: "确定删除和TA的所有聊天信息",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/DeleteMsg",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        fid: r,
                        tid: i
                    },
                    success: function(t) {
                        console.log(t), e.splice(n, 1), a.setData({
                            list: e,
                            current: null
                        });
                    }
                });
            }
        });
    },
    start: function(t) {
        this.setData({
            start: t.changedTouches[0].pageX
        });
    },
    move: function(t) {},
    end: function(t) {
        this.setData({
            end: t.changedTouches[0].pageX
        }), 0 < this.data.start - this.data.end ? this.setData({
            current: t.currentTarget.dataset.id
        }) : this.data.start - this.data.end < 0 && this.setData({
            current: null
        });
    },
    delFriend: function(t) {
        var e = this, n = e.data.haoyou_list, r = t.currentTarget.dataset.id, i = t.currentTarget.dataset.fid, o = t.currentTarget.dataset.tid;
        wx.showModal({
            title: "提示",
            content: "确定删除好友和TA的所有聊天信息",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/DeleteHaoyou",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        fid: i,
                        tid: o
                    },
                    success: function(t) {
                        console.log(a), n.splice(r, 1), e.setData({
                            haoyou_list: n,
                            currentFriend: null
                        });
                    }
                });
            }
        });
    },
    startFriend: function(t) {
        this.setData({
            startFriend: t.changedTouches[0].pageX
        });
    },
    moveFriend: function(t) {},
    endFriend: function(t) {
        this.setData({
            endFriend: t.changedTouches[0].pageX
        }), 0 < this.data.startFriend - this.data.endFriend ? this.setData({
            currentFriend: t.currentTarget.dataset.id
        }) : this.data.startFriend - this.data.endFriend < 0 && this.setData({
            currentFriend: null
        });
    },
    look_newmess: function() {
        wx.navigateTo({
            url: "/hyb_jiaoyou/new_add/new_add"
        });
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var e = this;
        if (null != t.index) {
            var n = e.data.footer;
            n.footdex = t.index, e.setData({
                footer: n
            });
        }
        e.getChatList();
        var r = setInterval(function() {
            e.getChatList(), wx.hideNavigationBarLoading();
        }, 6e3);
        e.setData({
            setinterval: r
        });
    },
    getChatList: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/HaoyouList",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t);
                var a = t.data.data;
                e.setData({
                    list: a
                });
            }
        });
    },
    getDaohang: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Daohang",
            success: function(t) {
                var a = e.data.footer;
                a.list = t.data.data, e.setData({
                    footer: a
                });
            }
        });
    },
    onReady: function() {},
    onUnload: function() {
        clearInterval(this.data.setinterval);
    },
    onShow: function() {},
    onHide: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});