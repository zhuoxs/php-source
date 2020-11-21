function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

App({
    data: {
        version: "6.3.4",
        releaseTime: "2019-07-13"
    },
    onLaunch: function() {
        var a = this;
        wx.getSystemInfo({
            success: function(e) {
                a.globalData.iphoneX = -1 != e.model.indexOf("iPhone X"), a.globalData.phone = e.platform, 
                a.globalData.StatusBar = e.statusBarHeight;
                var t = wx.getMenuButtonBoundingClientRect();
                a.globalData.Custom = t, a.globalData.CustomBar = t.bottom + t.top - e.statusBarHeight, 
                a.globalData.CustomBarRightOffset = e.screenWidth - t.right;
            }
        });
    },
    onShow: function() {
        this.globalData.isOpenSocket && this.initChat();
    },
    onHide: function() {
        var e = {
            type: "logout",
            uid: wx.getStorageSync("userInfo").memberInfo.uid,
            uniacid: this.siteInfo.uniacid
        };
        this.chatMessageSend(e), this.chatClose();
    },
    initChat: function() {
        var a = this;
        a.util.request({
            url: "entry/wxapp/message",
            data: {
                act: "init",
                m: "superman_hand2"
            },
            success: function(e) {
                var t = e.data.data;
                a.chatServerInit(t);
            }
        });
    },
    chatServerInit: function(t) {
        var a = this, n = wx.getStorageSync("userInfo"), o = a.siteInfo.uniacid;
        wx.connectSocket({
            url: t.url,
            fail: function(e) {
                console.log(e);
            }
        }), wx.onSocketOpen(function() {
            console.log("socket open");
            var e = {
                type: "login",
                sid: t.sid,
                uid: n.memberInfo.uid,
                nickname: n.memberInfo.nickname,
                uniacid: o
            };
            a.chatMessageSend(e);
        }), wx.onSocketMessage(function(e) {
            a.chatMessageReceive(e);
        }), wx.onSocketError(function() {
            console.log("服务器连接失败");
        }), wx.onSocketClose(function() {
            console.log("WebSocket 已关闭！");
        });
    },
    chatMessageSend: function(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", a = JSON.stringify(e);
        wx.sendSocketMessage({
            data: a,
            success: function() {
                "function" == typeof t && t();
            }
        });
    },
    chatMessageReceive: function() {
        var t = this;
        wx.onSocketMessage(function(e) {
            switch (JSON.parse(e.data).type) {
              case "ping":
                t.chatMessageSend({
                    type: "pong"
                });
            }
        });
    },
    chatClose: function() {
        wx.closeSocket(), wx.onSocketClose(function() {
            console.log("WebSocket 已关闭！");
        });
    },
    util: require("we7/resource/js/util.js"),
    viewCount: function() {
        this.util.request({
            url: "entry/wxapp/stat",
            cachetime: "0",
            data: {
                m: "superman_hand2"
            },
            success: function() {
                console.log("view +1");
            }
        });
    },
    setTabBar: function(e) {
        var t = e.data.tabBar.list, a = {
            open: !!wx.getStorageSync("recycle_open"),
            style: wx.getStorageSync("recycle_style"),
            bottom: this.globalData.iphoneX ? "57px" : "25px"
        };
        wx.getStorageSync("cube_open") && (t[1].pagePath = "", t[1].text = "分类"), a.open ? 5 != e.data.tabBar.list.length && t.splice(2, 0, {
            iconPath: "",
            pagePath: "",
            pageUrl: "",
            selectedIconPath: "",
            text: ""
        }) : 5 == e.data.tabBar.list.length && t.splice(2, 1), e.setData({
            recycle: a,
            "tabBar.list": t,
            "tabBar.height": this.globalData.iphoneX ? "178rpx" : "110rpx"
        });
    },
    checkRedDot: function(a) {
        this.util.request({
            url: "entry/wxapp/message",
            data: {
                act: "red_dot",
                m: "superman_hand2"
            },
            success: function(e) {
                if (!e.data.errno) {
                    var t = parseInt(a.data.tabBar.list.length) - 2;
                    a.setData(_defineProperty({}, "tabBar.list[" + t + "].redDot", "0" != e.data.data));
                }
            }
        }), this.util.request({
            url: "entry/wxapp/my",
            data: {
                m: "superman_hand2"
            },
            success: function(e) {
                if (!e.data.errno) {
                    var t = parseInt(a.data.tabBar.list.length) - 1;
                    a.setData(_defineProperty({}, "tabBar.list[" + t + "].redDot", "0" != e.data.data.sell_count));
                }
            }
        });
    },
    tabBar: {
        color: "#707070",
        selectedColor: "#f60",
        borderStyle: "#eee",
        backgroundColor: "#fff",
        height: "110rpx",
        list: [ {
            pagePath: "/pages/home/index",
            iconPath: "/we7/resource/icon/home.png",
            selectedIconPath: "/we7/resource/icon/homeselect.png",
            redirect: !0,
            text: "首页"
        }, {
            pagePath: "/pages/post/index",
            iconPath: "/we7/resource/icon/pub.png",
            selectedIconPath: "/we7/resource/icon/pubselect.png",
            redirect: !1,
            text: "发布"
        }, {
            pagePath: "/pages/message/index",
            iconPath: "/we7/resource/icon/msg.png",
            selectedIconPath: "/we7/resource/icon/msgselect.png",
            redirect: !0,
            redDot: !1,
            text: "消息"
        }, {
            pagePath: "/pages/my/index",
            iconPath: "/we7/resource/icon/my.png",
            selectedIconPath: "/we7/resource/icon/myselect.png",
            redirect: !0,
            redDot: !1,
            text: "我的"
        } ]
    },
    globalData: {
        iphoneX: !1,
        phone: null,
        StatusBar: null,
        Custom: null,
        CustomBar: null,
        isOpenSocket: !1
    },
    siteInfo: require("siteinfo.js")
});