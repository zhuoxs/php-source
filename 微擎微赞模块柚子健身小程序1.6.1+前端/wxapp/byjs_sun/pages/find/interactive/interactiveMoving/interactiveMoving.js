var app = getApp();

Page({
    data: {
        tabs: [ {
            name: "达人圈",
            tabimgsrc: "../../../../fyly_sun/resource/images/interactive/icon-talent.png",
            imgclass: "moving-nav-talent"
        }, {
            name: "结伴行",
            tabimgsrc: "../../../../fyly_sun/resource/images/interactive/icon-goWith.png",
            imgclass: "moving-nav-goWith"
        } ],
        activeIndex: 0,
        sliderOffset: 0,
        sliderLeft: 0,
        status: 0,
        lovestatus: 0,
        loveimgsrc1: "../../../../fyly_sun/resource/images/interactive/icon-love.png",
        loveimgsrc2: "../../../../fyly_sun/resource/images/interactive/icon-love-1.png",
        lovenum: 0,
        lovenumadd1: 1,
        talent: [],
        gowith: [],
        seeall: "全文",
        hideall: "收起",
        page: 1
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = this, e = app.globalData.aci, n = wx.getStorageSync("url"), i = wx.getStorageSync("users").id;
        1 == e ? app.util.request({
            url: "entry/wxapp/getGowith",
            cachetime: "0",
            data: {
                user_id: i
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    gowith: t.data,
                    url: n,
                    page: 1,
                    activeIndex: 1
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/getExpert",
            cachetime: "0",
            data: {
                user_id: i
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    talent: t.data,
                    url: n,
                    page: 1,
                    activeIndex: 0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    showalltitle: function(t) {
        var a = this, e = t.currentTarget.dataset.f_index, n = a.data.activeIndex;
        if (1 == n) var i = a.data.gowith; else i = a.data.talent;
        var o = i[e].status;
        i[e].status = 1 == o ? 0 : 1, 1 == n ? a.setData({
            gowith: i
        }) : a.setData({
            talent: i
        });
    },
    seetalentimg: function(t) {
        var a = this, e = wx.getStorageSync("url"), n = t.currentTarget.dataset.f_index, i = t.currentTarget.dataset.s_index;
        if (1 == a.data.activeIndex) var o = a.data.gowith; else o = a.data.talent;
        for (var r = e + o[n].img[i], s = o[n].img, c = [], l = 0; l < s.length; l++) c[l] = e + s[l];
        wx.previewImage({
            current: r,
            urls: c
        });
    },
    tabClick: function(t) {
        this.setData({
            sliderOffset: t.currentTarget.offsetLeft,
            activeIndex: t.currentTarget.id
        });
        var a = wx.getStorageSync("users").id, e = this;
        1 == t.currentTarget.id ? app.util.request({
            url: "entry/wxapp/getGowith",
            cachetime: "0",
            data: {
                user_id: a
            },
            success: function(t) {
                app.globalData.aci = 1, e.setData({
                    gowith: t.data,
                    page: 1
                });
            }
        }) : (app.globalData.aci = "", e.onLoad());
    },
    gointeractiveInfoone: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../interactiveInfoone/interactiveInfoone?id=" + a
        });
    },
    gointeractiveInfotwo: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../interactiveInfotwo/interactiveInfotwo?gowith_id=" + a
        });
    },
    onReady: function() {},
    onShow: function() {
        this.onLoad();
    },
    onHide: function() {
        app.globalData.aci = 0;
    },
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading();
        this.onShow(), wx.hideNavigationBarLoading();
    },
    onReachBottom: function() {
        var e = this, n = wx.getStorageSync("url"), t = wx.getStorageSync("users").id, i = e.data.page, o = e.data.activeIndex;
        if (1 == o) var r = e.data.gowith, a = "entry/wxapp/GetGowith"; else r = e.data.talent, 
        a = "entry/wxapp/getExpert";
        wx.showLoading({
            title: "数据加载中"
        }), app.util.request({
            url: a,
            cachetime: "0",
            data: {
                user_id: t,
                page: i
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    console.log(t.data);
                    var a = t.data;
                    r = r.concat(a), console.log(r), 1 == o ? e.setData({
                        gowith: r,
                        url: n,
                        page: i + 1
                    }) : e.setData({
                        talent: r,
                        url: n,
                        page: i + 1
                    });
                }
                wx.hideLoading();
            }
        });
    },
    attention: function(t) {
        var e = this, n = t.currentTarget.dataset.id, a = wx.getStorageSync("users").id, i = (wx.getStorageSync("url"), 
        t.currentTarget.dataset.f_index), o = 0, r = e.data.activeIndex;
        if (1 == r) var s = e.data.gowith; else s = e.data.talent;
        a == n ? wx.showToast({
            title: "不能关注自己",
            icon: "none"
        }) : (1 == s[i].is_attention ? s[i].is_attention = 0 : (s[i].is_attention = 1, o = 1), 
        app.util.request({
            url: "entry/wxapp/Attention",
            cachetime: "0",
            data: {
                tag: r,
                att_user_id: n,
                user_id: a
            },
            success: function(t) {
                if (1 == t.data) {
                    console.log(s);
                    for (var a = 0; a < s.length; a++) s[a].user_id == n && (s[a].is_attention = o);
                    1 == r ? e.setData({
                        gowith: s
                    }) : e.setData({
                        talent: s
                    });
                } else wx.showToast({
                    title: "关注失败，网络延迟！！！",
                    icon: "none"
                });
            },
            fail: function(t) {
                wx.showToast({
                    title: "关注失败，网络延迟！！！",
                    icon: "none"
                });
            }
        }));
    },
    lovefun: function(t) {
        var a = this, e = (t.currentTarget.dataset.id, wx.getStorageSync("users").id), n = t.currentTarget.dataset.id, i = (wx.getStorageSync("url"), 
        t.currentTarget.dataset.f_index), o = a.data.activeIndex;
        if (1 == o) var r = a.data.gowith; else r = a.data.talent;
        1 == r[i].is_love ? (r[i].is_love = 0, r[i].collect_num = parseInt(r[i].collect_num) - 1) : (r[i].is_love = 1, 
        r[i].collect_num = parseInt(r[i].collect_num) + 1), app.util.request({
            url: "entry/wxapp/lovefun",
            cachetime: "0",
            data: {
                tag: o,
                id: n,
                user_id: e
            },
            success: function(t) {
                1 == t.data ? 1 == o ? a.setData({
                    gowith: r
                }) : a.setData({
                    talent: r
                }) : wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            },
            fail: function(t) {
                wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            }
        });
    },
    gototravalpage: function(t) {
        var a = t.currentTarget.dataset.gid, e = t.currentTarget.dataset.type, n = this.data.gowith, i = "";
        console.log(n), i = 1 == e ? "/fyly_sun/pages/product/visaInfo/visaInfo?id=" + a : 2 == e ? "/fyly_sun/pages/product/moreFight/moreFight?id=" + a : "/fyly_sun/pages/product/index/index", 
        wx.navigateTo({
            url: i
        });
    }
});