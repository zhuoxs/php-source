var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "普通", "砍价", "拼团", "集卡", "抢购", "优惠券" ],
        goodslist: [],
        page: [ 1, 1, 1, 1, 1, 1 ],
        show: !1,
        goods: []
    },
    onLoad: function(a) {
        var t = this, o = wx.getStorageSync("brand_info");
        app.util.request({
            url: "entry/wxapp/GetBrandGoods",
            data: {
                lid: 1,
                bid: o.bid
            },
            success: function(a) {
                console.log(a.data), 2 == a.data ? t.setData({
                    goodslist: []
                }) : t.setData({
                    goodslist: a.data
                });
            }
        });
    },
    bargainTap: function(a) {
        var t = this, o = parseInt(a.currentTarget.dataset.index), s = o + 1, d = wx.getStorageSync("brand_info");
        app.util.request({
            url: "entry/wxapp/GetBrandGoods",
            data: {
                lid: s,
                bid: d.bid
            },
            success: function(a) {
                2 == a.data ? t.setData({
                    goodslist: []
                }) : t.setData({
                    goodslist: a.data
                });
            }
        }), t.setData({
            curIndex: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var o = this, s = o.data.curIndex, a = s + 1, t = wx.getStorageSync("brand_info"), d = o.data.goodslist, e = o.data.page, n = e[s];
        app.util.request({
            url: "entry/wxapp/GetBrandGoods",
            data: {
                lid: a,
                bid: t.bid,
                page: n
            },
            success: function(a) {
                if (console.log(a.data), 2 == a.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var t = a.data;
                    d = d.concat(t), e[s] = n + 1, o.setData({
                        goodslist: d,
                        page: e
                    });
                }
            }
        });
    },
    showModel: function(a) {
        var t = this, o = a.currentTarget.dataset.gid, s = t.data.curIndex + 1;
        o && app.util.request({
            url: "entry/wxapp/ShowBrandGoods",
            data: {
                lid: s,
                gid: o
            },
            success: function(a) {
                console.log(a.data), 2 == a.data ? console.log("获取数据失败") : t.setData({
                    goods: a.data
                });
            }
        }), t.setData({
            show: !t.data.show
        });
    },
    formSubmit: function(a) {
        var o = this, t = a.detail.value.goodsnum, s = o.data.curIndex, d = s + 1, e = o.data.goods.gid, n = (o.data.goodslist, 
        [ 1, 1, 1, 1, 1, 1 ]);
        e && app.util.request({
            url: "entry/wxapp/SetBrandGoods",
            data: {
                lid: d,
                gid: e,
                num: t
            },
            success: function(a) {
                if (console.log(a.data), o.setData({
                    show: !o.data.show
                }), 2 == a.data) wx.showModal({
                    title: "提示信息",
                    content: "修改失败",
                    showCancel: !1
                }); else {
                    wx.showToast({
                        title: "修改成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var t = wx.getStorageSync("brand_info");
                    app.util.request({
                        url: "entry/wxapp/GetBrandGoods",
                        data: {
                            lid: d,
                            bid: t.bid,
                            page: n
                        },
                        success: function(a) {
                            2 == a.data ? o.setData({
                                goodslist: []
                            }) : o.setData({
                                goodslist: a.data,
                                page: n
                            });
                        }
                    });
                }
            }
        });
    }
});