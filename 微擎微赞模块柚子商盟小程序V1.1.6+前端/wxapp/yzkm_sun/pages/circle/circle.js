function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), template = require("../template/template.js");

Page({
    data: {
        showModalStatus: !1,
        currentTab: 0,
        currentIndex: 0,
        statusType: [ "热门圈子", "最新发布", "距离最近" ],
        latitude_dq: "",
        longitude_dq: "",
        fabu_id: "",
        store: [ {
            pic: "http://oydmq0ond.bkt.clouddn.com/3c6d55fbb2fb4316b81c19dd2ca4462309f7d312.jpg",
            text: "房产租售"
        } ]
    },
    onLoad: function(t) {
        var s = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/system",
            success: function(t) {
                console.log("****************************"), wx.setStorageSync("system", t.data), 
                wx.getLocation({
                    type: "wgs84 ",
                    success: function(t) {
                        console.log("获取当前用户经纬度"), s.setData({
                            latitude_dq: t.latitude,
                            longitude_dq: t.longitude
                        }), app.util.request({
                            url: "entry/wxapp/Circle_zx",
                            data: {
                                openid: a,
                                post_id: 0,
                                currentIndex: 0,
                                latitude_dq: s.data.latitude_dq,
                                longitude_dq: s.data.longitude_dq
                            },
                            success: function(t) {
                                console.log("圈子分类数据"), console.log(t), s.setData({
                                    post_list: t.data.type,
                                    list: t.data.res
                                }), s.data.post_list.length <= 5 ? s.setData({
                                    height: 150
                                }) : 5 < s.data.post_list.length && s.setData({
                                    height: 300
                                });
                                for (var a = [], e = 0, o = s.data.post_list.length; e < o; e += 10) a.push(s.data.post_list.slice(e, e + 10));
                                s.setData({
                                    nav: a
                                });
                            }
                        });
                    }
                }), wx.setNavigationBarColor({
                    frontColor: t.data.color,
                    backgroundColor: t.data.fontcolor,
                    animation: {
                        timingFunc: "easeIn"
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log("页面加载请求"), wx.setStorageSync("url", t.data), s.setData({
                    url: t.data
                });
            }
        }), s.diyWinColor(), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: a
            },
            success: function(t) {
                console.log("查看用户id"), s.setData({
                    comment_xqy: t.data
                }), wx.setStorageSync("user_id", t.data.id);
            }
        }), app.util.request({
            url: "entry/wxapp/Custom_photo",
            success: function(t) {
                console.log("自定义数据显示");
                var a = wx.getStorageSync("url");
                0 == t.data.key ? template.tabbar("tabBar", 3, s, t, a) : template.tabbar("tabBar", 2, s, t, a);
            }
        });
    },
    goclassDetails: function(t) {
        var s = this, a = s.data.currentIndex, e = t.currentTarget.dataset.id, o = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/Circle_zx",
            data: {
                openid: o,
                post_id: e,
                currentIndex: a,
                latitude_dq: s.data.latitude_dq,
                longitude_dq: s.data.longitude_dq
            },
            success: function(t) {
                console.log("圈子分类数据"), console.log(t), s.setData({
                    post_list: t.data.type,
                    list: t.data.res
                }), s.data.post_list.length <= 5 ? s.setData({
                    height: 150
                }) : 5 < s.data.post_list.length && s.setData({
                    height: 300
                });
                for (var a = [], e = 0, o = s.data.post_list.length; e < o; e += 10) a.push(s.data.post_list.slice(e, e + 10));
                s.setData({
                    nav: a
                });
            }
        }), s.setData({
            post_id: e
        });
    },
    cancleBtn: function(t) {
        var a = t.currentTarget.dataset.statu;
        t.target.dataset.star;
        this.util(a);
    },
    statusTap: function(t) {
        var s = this, a = s.data.post_id, e = t.currentTarget.dataset.index, o = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/Circle_zx",
            data: {
                openid: o,
                post_id: a,
                currentIndex: e,
                latitude_dq: s.data.latitude_dq,
                longitude_dq: s.data.longitude_dq
            },
            success: function(t) {
                console.log("圈子分类数据"), console.log(t), s.setData({
                    post_list: t.data.type,
                    list: t.data.res
                }), s.data.post_list.length <= 5 ? s.setData({
                    height: 150
                }) : 5 < s.data.post_list.length && s.setData({
                    height: 300
                });
                for (var a = [], e = 0, o = s.data.post_list.length; e < o; e += 10) a.push(s.data.post_list.slice(e, e + 10));
                s.setData({
                    nav: a
                });
            }
        }), s.setData({
            currentIndex: e
        });
    },
    onShow: function() {},
    details: function(t) {
        console.log("圈子说说id"), console.log(t.currentTarget.dataset.id);
        var a = this, e = t.currentTarget.dataset.id, o = wx.getStorageSync("user_id");
        a.diyWinColor(), app.util.request({
            url: "entry/wxapp/Details_qz",
            data: {
                openid: o,
                fabu_id: e
            },
            success: function(t) {
                console.log("圈子详情页面信息"), console.log(t), a.setData({
                    Details_xqy: t.data
                }), wx.navigateTo({
                    url: "./details/details?id=" + e
                });
            }
        });
    },
    praise: function(t) {
        console.log("圈子说说id"), console.log(t.currentTarget.dataset.id);
        var a = t.currentTarget.dataset.idx, e = this.data.list[a].id, o = this, s = wx.getStorageSync("user_id");
        o.diyWinColor(), app.util.request({
            url: "entry/wxapp/Tickle_qz",
            data: {
                openid: s,
                fabu_id: e
            },
            success: function(t) {
                console.log("圈子点赞数据信息"), console.log(t), 1 == t.data && o.setData(_defineProperty({}, "list[" + a + "].praise", o.data.list[a].praise - 0 + 1));
            }
        });
    },
    toCircleDetails: function(t) {
        wx.navigateTo({
            url: "./details/details"
        });
    },
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "圈子"
        });
    },
    bindSubmit: function(t) {
        console.log("圈子用户评论内容"), console.log(t);
        var a = t.detail.value.contents, e = wx.getStorageSync("user_id");
        console.log(e);
        var o = this.data.fabu_id;
        console.log("d465654646465"), "" == a ? wx.showToast({
            title: "内容不能为空！！！",
            icon: "none"
        }) : app.util.request({
            url: "entry/wxapp/Comments_qz",
            data: {
                openid: e,
                contents: a,
                fabu_id: o
            },
            success: function(t) {
                console.log("查看圈子评论说说"), console.log(t), wx.navigateTo({
                    url: "./details/details?id=" + this.data.fabu_id
                });
            }
        });
    },
    writeComments: function(t) {
        console.log("111111e"), console.log(t);
        var a = t.currentTarget.dataset.statu, e = t.currentTarget.dataset.id;
        console.log(e), this.setData({
            fabu_id: e
        }), this.util(a);
    },
    close: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("630rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.target.dataset.current) return !1;
        this.setData({
            currentTab: t.target.dataset.current
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});