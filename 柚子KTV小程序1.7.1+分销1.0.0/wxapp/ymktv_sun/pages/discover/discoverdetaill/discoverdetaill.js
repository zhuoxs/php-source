var app = getApp();

Page({
    data: {
        releaseFocus: !1,
        releasedata: !0,
        peraonal: {
            headerimgsrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152349920201_medium.jpg",
            name: "小白",
            time: "2015-10-10",
            findimgsrcs: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152342845743_medium.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152341453956_medium.jpg" ],
            gender: "1",
            attention: "0",
            praisenum: "10",
            praisetatus: 0,
            commentnum: "11",
            commentnumtatus: 0,
            content: "唱歌吧！有人要一起的嘛2月21号 晚上8点"
        }
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = wx.getStorageSync("id"), i = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/ActiveDetails",
            cachetime: "0",
            data: {
                id: a,
                openid: i
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    activedetails: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    tappraise: function(t) {
        var e = this, a = t.currentTarget.dataset.id, i = wx.getStorageSync("userid"), n = e.data.activedetails;
        1 == n.iszan ? (n.iszan = 0, n.zanlen = n.zanlen - 1) : (n.iszan = 1, n.zanlen = n.zanlen + 1), 
        app.util.request({
            url: "entry/wxapp/clickzan",
            cachetime: "0",
            data: {
                openid: i,
                id: a
            },
            success: function(t) {
                e.setData({
                    activedetails: n
                });
            }
        });
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("userid"), a = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/UserComment",
            cachetime: "0",
            data: {
                id: a,
                openid: t
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    comment: t.data
                });
            }
        });
    },
    attention: function(t) {
        var e = this, a = e.data.activedetails;
        console.log(a);
        var i = wx.getStorageSync("userid"), n = a.openid, s = e.data.activedetails;
        1 == s.isfollow ? s.isfollow = 0 : s.isfollow = 1, app.util.request({
            url: "entry/wxapp/Follow",
            cachetime: "0",
            data: {
                openid: i,
                user_id: n
            },
            success: function(t) {
                e.setData({
                    activedetails: s
                });
            }
        });
    },
    goDiscoverdetaill: function() {
        wx.navigateTo({
            url: "../discoverdetaill/discoverdetaill"
        });
    },
    previewImage: function(t) {
        for (var e = this, a = t.currentTarget.dataset.index, i = [], n = 0; n < e.data.activedetails.imgs.length; n++) i.push(e.data.url + e.data.activedetails.imgs[n]);
        wx.previewImage({
            current: i[a],
            urls: i
        });
    },
    bindReplyshow: function(t) {
        this.setData({
            releaseFocus: !0
        });
    },
    formSubmit: function(t) {
        var e = this;
        console.log(t), console.log(e.data);
        var a = t.detail.value.contents, i = e.data.activedetails.id, n = wx.getStorageSync("userid"), s = e.data.activedetails;
        s.comment_num = parseInt(s.comment_num) + 1, app.util.request({
            url: "entry/wxapp/Comment",
            cachetime: "0",
            data: {
                openid: n,
                contents: a,
                id: i
            },
            success: function(t) {
                1 == t.data && (e.setData({
                    qingkong: "",
                    activedetails: s
                }), e.onShow());
            }
        }), this.setData({
            releaseFocus: !1
        });
    }
});