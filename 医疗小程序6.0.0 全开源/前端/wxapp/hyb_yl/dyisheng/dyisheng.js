var app = getApp();

Page({
    data: {
        search: {
            searchValue: "",
            showClearBtn: !1
        },
        searchResult: [],
        zhuanjia: [ {
            src: "/yiliao/images/jiang.png"
        } ],
        hidden: !0,
        rotateIndex: "",
        animationData: {},
        statusImage: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/jiazai.png",
        statusClass: "load"
    },
    fenlei: function() {
        this.setData({
            hidden: !this.data.hidden
        });
    },
    xzdoc: function(a) {
        console.log(a);
        var e = a.currentTarget.dataset.z_name, t = a.currentTarget.dataset.zid;
        app.util.request({
            url: "entry/wxapp/SaveCollect1",
            data: {
                openid: wx.getStorageSync("openid"),
                goods_id: t,
                cerated_type: 0
            },
            dataType: "json",
            success: function(a) {
                console.log(a);
                var t = getCurrentPages();
                t[t.length - 2].setData({
                    z_name: e
                }), wx.navigateBack({
                    delta: 1
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), wx.showNavigationBarLoading();
        var e = this;
        app.util.request({
            url: "entry/wxapp/Zhuanjia",
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    zhuanjia: t
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1500);
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var e = this, n = new Date().getTime();
        a.id ? app.util.request({
            url: "entry/wxapp/Kszhuanjia",
            data: {
                id: a.id
            },
            success: function(a) {
                console.log(a);
                var t = a.data.data;
                e.setData({
                    zhuanjia: t,
                    time: new Date().getTime() - n
                }), e.anima();
            },
            fail: function(a) {
                console.log(a);
            }
        }) : app.util.request({
            url: "entry/wxapp/Zhuanjia",
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    zhuanjia: t,
                    time: new Date().getTime() - n
                }), e.anima();
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                e.setData({
                    bq_thumb: a.data.data.bq_thumb,
                    bq_name: a.data.data.bq_name
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    bindFocus: function() {
        wx.navigateTo({
            url: "./serch/serch"
        });
    },
    showClick: function(a) {
        var t = this, e = a.currentTarget.dataset.zid;
        app.util.request({
            url: "entry/wxapp/Zhuanjiaxiangqing",
            data: {
                id: e
            },
            success: function(a) {
                console.log(a), t.setData({
                    xiangqing: a.data.data
                });
            },
            fail: function(a) {}
        }), console.log(a), this.setData({
            overflow: !0
        });
    },
    hideClick: function() {
        this.setData({
            overflow: !1
        });
    },
    payClick: function(a) {
        console.log(a);
        var t = a.currentTarget.dataset.url, e = a.currentTarget.dataset.z_name, n = wx.getStorageSync("openid"), o = a.currentTarget.dataset.money;
        app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: n,
                z_tw_money: o
            },
            success: function(a) {
                console.log(a), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/Joninmoney",
                            data: {
                                use_openid: n,
                                leixing: "电话",
                                name: e,
                                pay: o
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(a) {
                                console.log(a);
                            },
                            fail: function(a) {
                                console.log(a);
                            }
                        }), wx.navigateTo({
                            url: "../webview/webview?src=" + t
                        });
                    }
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onReady: function() {},
    anima: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "ease"
        });
        this.animation = a, this.imageRotators();
    },
    imageRotators: function() {
        this.timeInterval = setInterval(function() {
            this.data.rotateIndex = this.data.rotateIndex + 1, this.animation.rotateZ(360 * this.data.rotateIndex).step(), 
            this.setData({
                animationData: this.animation.export()
            });
        }.bind(this), 100), this.request();
    },
    stopRotators: function() {
        0 < this.timeInterval && (clearInterval(this.timeInterval), this.timeInterval = 0);
    },
    request: function(a) {
        var t = this;
        console.log(t.data.time), setTimeout(function() {
            t.stopRotators(), console.log("请求到了数据或者操作完成,停止旋转");
            t.setData({
                statusImage: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/erddd.png",
                statusClass: "success"
            });
        }, 100);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    searchActiveChangeinput: function(a) {
        var t = a.detail.value;
        this.setData({
            "search.showClearBtn": "" != t,
            "search.searchValue": t
        });
    },
    searchActiveChangeclear: function(a) {
        this.setData({
            "search.showClearBtn": !1,
            "search.searchValue": ""
        });
    },
    searchSubmit: function() {
        var a = this.data.search.searchValue;
        if (a) {
            var o = this, i = getApp();
            wx.showLoading({
                title: "搜索中"
            }), setTimeout(function() {
                wx.hideLoading();
            }, 2e3), i.util.request({
                url: "entry/wxapp/Activity",
                data: {
                    keywords: a
                },
                method: "GET",
                success: function(a) {
                    console.log(a.data.length), a.data.length || wx.showToast({
                        title: "暂无此医生"
                    });
                    for (var t = a.data, e = t.length, n = 0; n < e; n++) t[n].team_avator = i.globalData.STATIC_SOURCE + t[n].team_avator;
                    o.setData({
                        searchResult: t,
                        "search.showClearBtn": !1
                    });
                },
                fail: function() {},
                complete: function() {
                    wx.hideToast();
                }
            });
        }
    }
});