var t = getApp(), a = require("../../../../3421FA616A7AF98C524792666BF19D70.js");

Page({
    data: {
        time: "00:00",
        time2: "00:00",
        array: [ "单程", "往返" ],
        flag: "",
        b_lnglat: "",
        e_lnglat: "",
        site: "",
        address: "",
        arrdata: [ {
            name: "周一",
            value: "1"
        }, {
            name: "周二",
            value: "2",
            checked: "true"
        }, {
            name: "周三",
            value: "3"
        }, {
            name: "周四",
            value: "4"
        }, {
            name: "周五",
            value: "5"
        }, {
            name: "周六",
            value: "6"
        }, {
            name: "周日",
            value: "7"
        } ],
        showModal: !1,
        depart: "",
        info: "",
        price: ""
    },
    onLoad: function(t) {
        var a = this;
        try {
            var e = wx.getStorageSync("session");
            e && (console.log("logintag:", e), a.setData({
                logintag: e
            }));
        } catch (t) {}
        a.bidding_addshow();
    },
    bidding_addshow: function(a) {
        var e = this, o = e.data.logintag;
        wx.request({
            url: t.data.url + "bidding_addshow",
            data: {
                logintag: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("bidding_addshow => 获取信息"), console.log(t), "0000" == t.data.retCode) {
                    var a = [];
                    for (var o in t.data.info) a[o] = t.data.info[o].daynum + " 天 => " + t.data.info[o].price + " 元";
                    console.log(a), e.setData({
                        info: a
                    });
                } else wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    daynum: function(t) {
        var a = this, e = t.detail.value, o = a.data.info[e], n = o.split("=>")[1].split(" ")[1];
        console.log(n), a.setData({
            put_time: n,
            price: o
        });
    },
    origin: function(t) {
        var a = this;
        a.setData({
            origin: t.detail.value,
            origin_k: t.detail.value,
            commonality: "origin"
        }), a.deom(t.detail.value);
    },
    deom: function(t) {
        var e = this;
        console.log(t), new a({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).getSuggestion({
            keyword: t,
            success: function(t) {
                console.log(t.data), e.setData({
                    data: t.data
                });
            },
            fail: function(t) {
                console.log(t);
            },
            complete: function(t) {
                console.log(t);
            }
        });
    },
    title: function(t) {
        var a = this;
        "origin" == a.data.commonality ? a.setData({
            origin: t.currentTarget.dataset.address + t.currentTarget.dataset.title,
            origin_k: "",
            site: t.currentTarget.dataset.address,
            QDTIT: t.currentTarget.dataset.title
        }) : a.setData({
            terminus: t.currentTarget.dataset.address + t.currentTarget.dataset.title,
            terminus_k: "",
            address: t.currentTarget.dataset.address,
            ZDTIT: t.currentTarget.dataset.title
        }), a.price();
    },
    terminus: function(t) {
        var a = this;
        a.setData({
            terminus: t.detail.value,
            terminus_k: t.detail.value,
            commonality: "terminus"
        }), a.deom(t.detail.value);
    },
    ok: function(t) {
        var a = this;
        a.setData({
            origin_k: "",
            terminus_k: ""
        }), a.price();
    },
    price: function(t) {
        var e = this, o = e.data.commonality;
        if ("origin" == o) n = e.data.origin; else var n = e.data.terminus;
        new a({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).geocoder({
            address: n,
            success: function(t) {
                if (console.log(t.result.location), "origin" == o) {
                    var a = t.result.location.lat + "," + t.result.location.lng;
                    e.setData({
                        b_lnglat: a
                    }), console.log("起点腾讯接口获取经纬度 => b_lnglat", t.result.location.lat + "," + t.result.location.lng), 
                    console.log("起点腾讯接口获取经纬度 => b_lnglat", a);
                } else {
                    var n = t.result.location.lat + "," + t.result.location.lng;
                    e.setData({
                        e_lnglat: n
                    }), console.log("终点腾讯接口获取经纬度 => e_lnglat", t.result.location.lat + "," + t.result.location.lng), 
                    console.log("终点腾讯接口获取经纬度 => e_lnglat", n);
                }
            },
            fail: function(t) {
                console.log(t);
            },
            complete: function(t) {
                console.log(t);
            }
        });
    },
    swop: function(t) {
        var a = this, e = a.data.QDTIT, o = a.data.ZDTIT, n = a.data.b_lnglat, i = a.data.e_lnglat;
        if (console.log("交换之前 => b_lnglat：", n), console.log("交换之前 => e_lnglat：", i), e || o) {
            a.setData({
                QDTIT: o,
                ZDTIT: e,
                b_lnglat: i,
                e_lnglat: n
            }), wx.showToast({
                title: "位置互换成功",
                icon: "none",
                duration: 1e3
            });
            var n = a.data.b_lnglat, i = a.data.e_lnglat;
            console.log("交换之后 => b_lnglat：", n), console.log("交换之后 => e_lnglat：", i);
        } else wx.showToast({
            title: "操作无效",
            icon: "none",
            duration: 1e3
        });
    },
    bindTimeChange: function(t) {
        var a = this.data.time2;
        "00:00" !== a ? a > t.detail.value ? this.setData({
            time: t.detail.value
        }) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        }) : this.setData({
            time: t.detail.value
        });
    },
    bindTimeChange2: function(t) {
        this.data.time < t.detail.value ? this.setData({
            time2: t.detail.value
        }) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        });
    },
    bindPickerChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value);
        var a = parseInt(t.detail.value) + 1;
        if (1 == a) e = "单程"; else var e = "往返";
        this.setData({
            flag: a,
            index: e
        });
    },
    account: function(a) {
        console.log(a);
        var e = this, o = (a.detail.formId, e.data.logintag), n = e.data.QDTIT, i = e.data.ZDTIT, l = e.data.site, s = e.data.address, d = e.data.b_lnglat, r = e.data.e_lnglat, c = e.data.time, u = e.data.time2, g = e.data.flag, h = e.data.depart, w = a.detail.value.mobile, f = a.detail.value.weixin, m = e.data.put_time, v = a.detail.value.truename, T = "";
        for (var _ in h) console.log(h[_]), T += h[_] + ",";
        console.log("" == T), console.log("put_time:", m), void 0 != n && "" != n ? void 0 != i && "" != i ? "" != T ? "00:00" != c ? "00:00" != u ? "" != g ? "" != w ? "" != f ? "" != m ? "" != v ? wx.request({
            url: t.data.url + "bidding_addhandle",
            data: {
                logintag: o,
                starting_place: n,
                end_place: i,
                begin_time: c,
                end_time: u,
                flag: g,
                mobile: w,
                weixin: f,
                put_time: m,
                truename: v,
                b_lnglat: d,
                e_lnglat: r,
                begin_addr: l,
                end_addr: s,
                ccc: T
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("bidding_addhandle => 提交车主竞价"), console.log(t), "0000" == t.data.retCode ? (setTimeout(function() {
                    console.log("延迟调用============"), wx.navigateBack({
                        delta: 1,
                        success: function(t) {
                            var a = getCurrentPages().pop();
                            void 0 != a && null != a && a.onLoad();
                        }
                    });
                }, 1e3), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        }) : wx.showToast({
            title: "真实姓名不能为空",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "投放时间不能为空",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "微信号码不能为空",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "手机号码不能为空",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "是否往返???",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "最晚出发时间未选择",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "最早出发时间未选择",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "未勾选发车日期",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "未填写终点",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "未填写起点",
            icon: "none",
            duration: 1e3
        });
    },
    submit: function() {
        this.setData({
            showModal: !0
        });
    },
    preventTouchMove: function() {},
    go: function() {
        this.setData({
            showModal: !1
        });
    },
    checkboxChange: function(t) {
        var a = this, e = t.detail.value;
        console.log(e), a.setData({
            depart: e
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