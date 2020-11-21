var t = getApp(), e = 1;

Page({
    data: {
        list: [],
        display: !0,
        ophiden: !0,
        one_open: 1
    },
    onLoad: function() {
        var e = this;
        if ("" == wx.getStorageSync("uid")) t.util.getUserInfo(function(t) {
            if (t.memberInfo) {
                wx.setStorageSync("uid", t.memberInfo.uid);
                var i = t.memberInfo.uid;
                e.getList(0, i), console.log(t.memberInfo.uid);
            } else e.hideDialog();
        }); else {
            var i = wx.getStorageSync("uid");
            e.getList(0, i);
        }
    },
    onShow: function() {
        "1" == this.data.one_open ? (this.setData({
            one_open: 2
        }), console.log(1)) : (e = 1, this.setData({
            list: [],
            display: !0,
            ophiden: !0,
            houseList: [],
            listUrls: [],
            imgUrls: []
        }), console.log(2), this.getList(0, wx.getStorageSync("uid")));
    },
    onReachBottom: function() {
        this.getList(e, wx.getStorageSync("uid"));
    },
    getList: function(i, a) {
        var s = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                r: "home.index",
                page: i,
                uid: a
            },
            success: function(t) {
                if (0 !== t.data.data.list.length) {
                    var i = s.data.list;
                    i.push.apply(i, t.data.data.list), s.setData({
                        houseList: i,
                        listUrls: t.data.data.type,
                        imgUrls: t.data.data.banner
                    }), e++;
                } else 1 !== e ? s.setData({
                    display: !1
                }) : s.setData({
                    ophiden: !1
                });
            }
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(e) {
        var i = this;
        i.hideDialog(), e.detail.userInfo && t.util.getUserInfo(function(t) {
            var e = t.memberInfo.uid;
            i.getList(0, e), wx.setStorageSync("uid", t.memberInfo.uid);
        }, e.detail);
    }
});