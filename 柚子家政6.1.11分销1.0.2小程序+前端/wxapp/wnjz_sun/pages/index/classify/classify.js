var app = getApp();

Page({
    data: {
        navTile: "预约服务",
        curIndex: -1,
        nav: [ "常规服务", "深度清洁" ],
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152704392959.png",
        routine: [ "全部", "收纳整理" ],
        deep: [ "全部", "深度清洁" ],
        flag: 0,
        orderpro: [ {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152151553528.png",
            title: "居家保洁-24小时",
            desc: "居家保洁、家电清洗",
            price: "259.00"
        }, {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152151553537.png",
            title: "日式精细擦窗",
            desc: "玻璃窗、百叶窗、卷帘窗、防盗窗",
            price: "259.00"
        }, {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152151553537.png",
            title: "居家保洁-24小时",
            desc: "居家保洁、家电清洗",
            price: "259.00"
        } ]
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("build_id");
        a.getUrl(), app.util.request({
            url: "entry/wxapp/Onecategory",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    cate: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/cateData",
            cachetime: "0",
            data: {
                build_id: e
            },
            success: function(t) {
                a.setData({
                    cateData: t.data
                });
            }
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("keyword"), e = wx.getStorageSync("build_id");
        console.log(t), "" != t && app.util.request({
            url: "entry/wxapp/keywordData",
            cachetime: "0",
            data: {
                keyword: t,
                build_id: e
            },
            success: function(t) {
                a.setData({
                    cateData: t.data
                });
            }
        }), a.setData({
            keyword: t
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bargainTap: function(t) {
        var a = this, e = t.currentTarget.dataset.cid, c = parseInt(t.currentTarget.dataset.index), i = wx.getStorageSync("build_id");
        app.util.request({
            url: "entry/wxapp/HaveSon",
            cachetime: "0",
            data: {
                cid: e,
                build_id: i
            },
            success: function(t) {
                console.log(t.data), a.data.flag = t.data.flag, a.setData({
                    flag: a.data.flag,
                    cateData: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/catepic",
            cachetime: "0",
            data: {
                cid: e
            },
            success: function(t) {
                a.setData({
                    back_pic: t.data.back_pic
                });
            }
        }), a.setData({
            curIndex: c
        });
    },
    toBook: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.cateData[a].cname;
        wx.navigateTo({
            url: "../book/book?cid=" + t.currentTarget.dataset.cid + "&cname=" + e
        });
    },
    toSerdesc: function(t) {
        wx.navigateTo({
            url: "../serdesc/serdesc?id=" + t.currentTarget.dataset.gid
        });
    },
    searchSubmit: function(t) {
        var a = t.detail.value.searchText;
        this.seachFun(a);
    },
    toSearch: function(t) {
        var a = t.detail.value;
        this.seachFun(a);
    },
    seachFun: function(t) {
        var a = this;
        if ("" != t) {
            var e = wx.getStorageSync("build_id");
            "" != t && app.util.request({
                url: "entry/wxapp/keywordData",
                cachetime: "0",
                data: {
                    keyword: t,
                    build_id: e
                },
                success: function(t) {
                    a.setData({
                        cateData: t.data
                    });
                }
            }), a.setData({
                keyword: t
            });
        } else wx.showToast({
            title: "搜索关键词不得微空",
            icon: "none",
            duration: 2500
        });
    }
});