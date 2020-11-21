function _defineProperty(o, e, t) {
    return e in o ? Object.defineProperty(o, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : o[e] = t, o;
}

var app = getApp();

Page({
    data: {
        tel: "",
        noS: "",
        id: "",
        fabu_id: "",
        yh_id: ""
    },
    onLoad: function(o) {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: t
            },
            success: function(o) {
                console.log("查看用户id"), console.log(o), e.setData({
                    comment_xqy: o.data
                }), wx.setStorageSync("user_id", o.data.id);
            }
        });
        var a = o.id;
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(o) {
                console.log("页面加载请求"), console.log(o), wx.getStorageSync("url", o.data), e.setData({
                    url: o.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Circle_qz",
            data: {
                id: a
            },
            success: function(o) {
                console.log("查看圈子详情页数据"), console.log(o), e.setData({
                    list: o.data,
                    tel: o.data[0].tel,
                    fabu_id: o.data[0].id
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Circle_qz_pl",
            data: {
                id: a
            },
            success: function(o) {
                console.log("查看圈子详情页评论数据"), console.log(o), e.setData({
                    list1: o.data
                });
            }
        });
        var n = wx.getStorageSync("user_id");
        console.log(n), app.util.request({
            url: "entry/wxapp/Status_qz",
            data: {
                id: a,
                user_id: n
            },
            success: function(o) {
                console.log("查看收藏状态"), console.log(o), console.log(a), console.log(o.data), 0 == o.data ? e.setData({
                    noS: 0
                }) : e.setData({
                    noS: 1
                });
            }
        }), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: t
            },
            success: function(o) {
                console.log("查看当前用户id"), console.log(o), e.setData({
                    yh_id: o.data.id
                });
            }
        }), this.diyWinColor();
    },
    praise: function(o) {
        var e = this;
        console.log("圈子说说id"), console.log(o.currentTarget.dataset.id);
        var t = o.currentTarget.dataset.idx, a = e.data.list[t].id, n = wx.getStorageSync("user_id");
        e.diyWinColor(), app.util.request({
            url: "entry/wxapp/Tickle_qz",
            data: {
                openid: n,
                fabu_id: a
            },
            success: function(o) {
                console.log("圈子点赞数据信息"), console.log(o), 1 == o.data && e.setData(_defineProperty({}, "list[" + t + "].praise", e.data.list[t].praise - 0 + 1));
            }
        });
    },
    diyWinColor: function(o) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "圈子详情"
        });
    },
    writeComments: function(o) {
        wx.navigateTo({
            url: "../../fabu/fabu"
        });
    },
    makePhone: function(o) {
        console.log("电话的参数"), console.log(o);
        o.currentTarget.dataset.id;
        console.log("打电话"), console.log(this.data.tel), wx.makePhoneCall({
            phoneNumber: this.data.tel,
            success: function(o) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(o) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    makePhone1: function(o) {
        console.log("电话的参数"), console.log(o);
        o.currentTarget.dataset.id;
        console.log("打电话"), console.log(this.data.tel), wx.makePhoneCall({
            phoneNumber: this.data.tel,
            success: function(o) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(o) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    collectTap: function(o) {
        var e = this, t = wx.getStorageSync("openid");
        console.log("发布用户id查询"), console.log(o), console.log(e.data.yh_id), 0 == e.data.noS ? app.util.request({
            url: "entry/wxapp/Collect_qz",
            data: {
                noS: "1",
                openid: t,
                yh_id: e.data.yh_id,
                id: o.currentTarget.dataset.id
            },
            success: function(o) {
                console.log("收藏数据"), console.log(o), e.setData({
                    comment_xqy: o.data,
                    noS: "1"
                });
            }
        }) : 1 == e.data.noS && app.util.request({
            url: "entry/wxapp/Collect_qz",
            data: {
                noS: "0",
                openid: t,
                yh_id: e.data.yh_id,
                id: o.currentTarget.dataset.id
            },
            success: function(o) {
                console.log("收藏数据"), console.log(o), e.setData({
                    comment_xqy: o.data,
                    noS: "0"
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});