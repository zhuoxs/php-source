function t(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var e, a = getApp(), o = require("../../../3421FA616A7AF98C524792666BF19D70.js");

Page((e = {
    data: {
        logintag: "",
        gender: "",
        terminus: "",
        array: [ 1, 2, 3, 4, 5, 6, 7 ],
        time: "00:00",
        time2: "00:00",
        remark: "",
        data: "",
        commonality: "",
        origin_k: "",
        b_lnglat: "",
        e_lnglat: "",
        price: "",
        location: "",
        nclass: "",
        date: "",
        site: "",
        address: "",
        QDTIT: "",
        ZDTIT: "",
        buttom: "",
        is_autoprice: "",
        arr: [],
        fwxm: "",
        jiaz: "",
        dz: "",
        JWD: "",
        station_num: "",
        mid_i: "",
        latitude: "",
        longitude: "",
        show: "",
        ymd: ""
    },
    onLoad: function(t) {
        var e = this;
        try {
            (a = wx.getStorageSync("session")) && (console.log("logintag:", a), e.setData({
                logintag: a
            }));
        } catch (t) {}
        try {
            (a = wx.getStorageSync("location")) && (console.log("location:", a), e.setData({
                location: a
            }));
        } catch (t) {}
        try {
            var a = wx.getStorageSync("nclass");
            a && (console.log("nclass:", a), e.setData({
                nclass: a
            }));
        } catch (t) {}
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var a = t.latitude, o = t.longitude;
                console.log("yval:", a), console.log("xval:", o), e.setData({
                    latitude: t.latitude,
                    longitude: t.longitude
                }), e.locntiion();
            }
        }), e.fbrw(), e.ymd();
    },
    ymd: function(t) {
        var e = this, a = Date.parse(new Date()), o = 1e3 * (a /= 1e3), n = new Date(o), i = n.getFullYear() + "-" + (n.getMonth() + 1 < 10 ? "0" + (n.getMonth() + 1) : n.getMonth() + 1) + "-" + (n.getDate() < 10 ? "0" + n.getDate() : n.getDate());
        console.log(i), e.setData({
            ymd: i
        });
    },
    shi: function(t) {
        var e = this, a = e.data.date, o = a + " " + e.data.time + ":00", n = a + " " + e.data.time2 + ":00";
        console.log(o), console.log(n);
        var i = Date.parse(new Date()), l = 1e3 * (i /= 1e3), s = (a = new Date(l)).getFullYear(), r = a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1, c = a.getDate() < 10 ? "0" + a.getDate() : a.getDate(), d = a.getHours(), g = a.getMinutes(), u = a.getSeconds(), f = r.toString().length, m = c.toString().length, w = d.toString().length, h = g.toString().length;
        if (console.log(w), console.log(h), 2 == f) if (2 == m) D = s + "-" + r + "-" + c; else D = s + "-" + r + "-0" + c; else if (2 == m) D = s + "-0" + r + "-" + c; else var D = s + "-0" + r + "-0" + c;
        if (2 == w) if (2 == h) v = d + ":" + g + ":" + u; else v = d + ":0" + g + ":" + u; else if (2 == h) v = "0" + d + ":" + g + ":" + u; else var v = "0" + d + ":0" + g + ":" + u;
        var T = D + " " + v;
        console.log(T), T > o ? wx.showToast({
            title: "最早出发时间小于当前时间",
            icon: "none",
            duration: 2e3
        }) : T > n && wx.showToast({
            title: "最晚出发时间小于当前时间",
            icon: "none",
            duration: 2e3
        });
    },
    show: function(t) {
        var e = this, a = e.data.show;
        console.log(a), a ? e.setData({
            show: ""
        }) : e.setData({
            show: "show"
        });
    },
    fbrw: function(t) {
        var e = this, o = e.data.logintag;
        wx.request({
            url: a.data.url + "fbrw",
            data: {
                logintag: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("fbrw => 获取FBRW数据信息"), console.log(t), "0000" == t.data.retCode) {
                    var a = t.data.is_autoprice, o = t.data.station_num;
                    e.setData({
                        is_autoprice: a,
                        station_num: o
                    });
                } else wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    regionchange: function(t) {
        if (console.log(t), "end" == t.type && ("scale" == t.causedBy || "drag" == t.causedBy)) {
            console.log(t);
            var e = this;
            this.mapCtx = wx.createMapContext("map4select"), this.mapCtx.getCenterLocation({
                type: "gcj02",
                success: function(t) {
                    console.log(t, 11111), e.locntiion(), e.setData({
                        latitude: t.latitude,
                        longitude: t.longitude,
                        circles: [ {
                            latitude: t.latitude,
                            longitude: t.longitude,
                            color: "#FF0000DD",
                            fillColor: "#d1edff88",
                            radius: 100,
                            strokeWidth: 1
                        } ]
                    });
                }
            });
        }
    },
    locntiion: function(t) {
        var e = this, a = e.data.latitude, n = e.data.longitude, i = e.data.commonality;
        "" == i && (i = "origin"), console.log(a), console.log(n), new o({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).reverseGeocoder({
            location: {
                latitude: a,
                longitude: n
            },
            success: function(t) {
                console.log(t);
                var o = t.result.address, l = t.result.formatted_addresses.recommend, s = a + "," + n;
                "origin" == i ? e.setData({
                    b_lnglat: s,
                    site: o,
                    QDTIT: l
                }) : e.setData({
                    e_lnglat: s,
                    address: o,
                    ZDTIT: l
                }), console.log(l), console.log(o), console.log(s), e.money();
            },
            fail: function(t) {
                console.error(t);
            },
            complete: function(t) {
                console.log(t);
            }
        });
    },
    my_location: function(t) {
        this.onLoad();
    },
    origin: function(t) {
        var e = this;
        e.setData({
            origin: t.detail.value,
            origin_k: t.detail.value,
            commonality: "origin"
        }), e.deom(t.detail.value);
    },
    deom: function(t) {
        var e = this;
        console.log(t), new o({
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
        var e = this;
        "origin" == e.data.commonality ? e.setData({
            origin: t.currentTarget.dataset.address + t.currentTarget.dataset.title,
            origin_k: "",
            site: t.currentTarget.dataset.address,
            QDTIT: t.currentTarget.dataset.title
        }) : e.setData({
            terminus: t.currentTarget.dataset.address + t.currentTarget.dataset.title,
            terminus_k: "",
            address: t.currentTarget.dataset.address,
            ZDTIT: t.currentTarget.dataset.title
        }), e.price();
    },
    ok: function(t) {
        var e = this;
        1 == t.currentTarget.dataset.num ? e.setData({
            QDTIT: e.data.origin
        }) : e.setData({
            ZDTIT: e.data.terminus
        }), e.setData({
            origin_k: "",
            terminus_k: ""
        }), e.price();
    },
    price: function(t) {
        var e = this, a = e.data.commonality;
        if ("origin" == a) n = e.data.origin; else var n = e.data.terminus;
        new o({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).geocoder({
            address: n,
            success: function(t) {
                if (console.log(t.result.location), "origin" == a) {
                    var o = t.result.location.lat + "," + t.result.location.lng;
                    e.setData({
                        b_lnglat: o
                    }), console.log("起点腾讯接口获取经纬度 => b_lnglat", t.result.location.lat + "," + t.result.location.lng), 
                    console.log("起点腾讯接口获取经纬度 => b_lnglat", o);
                } else {
                    var n = t.result.location.lat + "," + t.result.location.lng;
                    e.setData({
                        e_lnglat: n
                    }), console.log("终点腾讯接口获取经纬度 => e_lnglat", t.result.location.lat + "," + t.result.location.lng), 
                    console.log("终点腾讯接口获取经纬度 => e_lnglat", n);
                }
                e.money();
            },
            fail: function(t) {
                console.log(t);
            },
            complete: function(t) {
                console.log(t);
            }
        });
    },
    money: function(t) {
        var e = this, o = e.data.b_lnglat, n = e.data.e_lnglat, i = e.data.logintag, l = e.data.location;
        console.log(l), o && n && wx.request({
            url: a.data.url + "getprice",
            data: {
                logintag: i,
                b_lnglat: o,
                e_lnglat: n,
                area: l
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("getprice => 获取用户的车资"), console.log(t), "0000" == t.data.retCode) {
                    var a = t.data.price;
                    e.setData({
                        price: a
                    });
                } else wx.showToast({
                    title: "获取数据失败",
                    icon: "none",
                    duration: 800
                });
            }
        });
    },
    terminus: function(t) {
        var e = this;
        e.setData({
            terminus: t.detail.value,
            terminus_k: t.detail.value,
            commonality: "terminus"
        }), e.deom(t.detail.value);
    },
    swop: function(t) {
        var e = this, a = e.data.QDTIT, o = e.data.ZDTIT, n = e.data.b_lnglat, i = e.data.e_lnglat, l = e.data.address, s = e.data.site;
        if (console.log("交换之前 => b_lnglat：", n), console.log("交换之前 => e_lnglat：", i), a || o) {
            e.setData({
                QDTIT: o,
                ZDTIT: a,
                b_lnglat: i,
                e_lnglat: n,
                address: s,
                site: l
            }), wx.showToast({
                title: "位置互换成功",
                icon: "none",
                duration: 1e3
            });
            var n = e.data.b_lnglat, i = e.data.e_lnglat;
            console.log("交换之后 => b_lnglat：", n), console.log("交换之后 => e_lnglat：", i);
        } else wx.showToast({
            title: "操作无效",
            icon: "none",
            duration: 1e3
        });
    },
    bindPickerChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value);
        var e = parseInt(t.detail.value) + 1;
        this.setData({
            index: e
        });
    },
    bindTimeChange: function(t) {
        var e = this.data.time2;
        "00:00" !== e ? e > t.detail.value ? (this.setData({
            time: t.detail.value
        }), this.shi()) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        }) : (this.setData({
            time: t.detail.value
        }), this.shi());
    },
    bindTimeChange2: function(t) {
        this.data.time < t.detail.value ? (this.setData({
            time2: t.detail.value
        }), this.shi()) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        });
    },
    bindDateChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            date: t.detail.value
        }), this.shi();
    },
    remark: function(t) {
        var e = this;
        console.log(t.detail.value), e.setData({
            remark: t.detail.value
        });
    },
    account: function(t) {
        console.log(t);
        var e = this, o = t.detail.formId, n = e.data.logintag, i = e.data.is_autoprice, l = e.data.nclass, s = e.data.date, r = e.data.site, c = e.data.address, d = e.data.b_lnglat, g = e.data.e_lnglat, u = e.data.QDTIT, f = e.data.ZDTIT, m = e.data.index;
        if (1 == i) w = t.detail.value.price; else var w = e.data.price;
        var h = s + " " + e.data.time, D = s + " " + e.data.time2, v = e.data.remark, T = e.data.location, p = e.data.mid_i;
        if (console.log("begin_time", h), console.log("end_time", D), console.log("logintag", n), 
        console.log("money", w), console.log("mid_info", p), console.log("begin_addr", r), 
        console.log("b_lnglat", d), console.log("starting_place", u), "" != s && void 0 != s) if (void 0 != u && "" != u) if ("" != f) if (null != m) if ("00:00" != h) if ("00:00" != D) {
            if (0 == l || 1 == l) x = "passenger_add_task"; else var x = "car_owner_add_task";
            wx.request({
                url: a.data.url + x,
                data: {
                    logintag: n,
                    starting_place: u,
                    end_place: f,
                    begin_time: h,
                    end_time: D,
                    number: m,
                    note: v,
                    money: w,
                    area_name: T,
                    form_id: o,
                    b_lnglat: d,
                    e_lnglat: g,
                    begin_addr: r,
                    end_addr: c,
                    mid_info: p
                },
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(t) {
                    console.log(x + " => 提交发布行程"), console.log(t), console.log(l), 0 == l || 1 == l ? "0000" == t.data.retCode ? "红包支付成功" == t.data.retDesc ? (wx.showToast({
                        title: t.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }), setTimeout(function() {
                        console.log("延迟调用 => home"), wx.navigateTo({
                            url: "/pages/index/index"
                        });
                    }, 1e3), e.setData({
                        buttom: "trun"
                    })) : e.bindtap(t.data.nid) : "请完善手机号" == t.data.retDesc ? wx.showModal({
                        title: "提示",
                        content: t.data.retDesc,
                        success: function(t) {
                            t.confirm && wx.navigateTo({
                                url: "/pages/index/phone/phone"
                            });
                        }
                    }) : wx.showToast({
                        title: t.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }) : "0000" == t.data.retCode ? (wx.showToast({
                        title: t.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }), setTimeout(function() {
                        console.log("延迟调用 => home"), wx.navigateTo({
                            url: "/pages/index/issueaa/issueaa"
                        });
                    }, 1e3)) : "请完善手机号" == t.data.retDesc ? wx.showModal({
                        title: "提示",
                        content: t.data.retDesc,
                        success: function(t) {
                            t.confirm && wx.navigateTo({
                                url: "/pages/index/phone/phone"
                            });
                        }
                    }) : wx.showToast({
                        title: t.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    });
                }
            });
        } else wx.showToast({
            title: "最晚出发时间未选择",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "最早出发时间未选择",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "乘车人数未选择",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "未填写终点",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "未填写起点",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "出发日期未选择",
            icon: "none",
            duration: 1e3
        });
    },
    bordera: function(t) {
        this.setData({
            commonality: "origin"
        });
    },
    borderb: function(t) {
        this.setData({
            commonality: "terminus"
        });
    },
    bindtap: function(t) {
        var e = this, o = e.data.logintag, n = t;
        console.log("进来了...."), console.log(t), wx.request({
            url: a.data.url + "passenger_task_pay",
            data: {
                logintag: o,
                nid: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("乘客发布任务支付操作"), console.log(t), e.setData({
                    buttom: "trun"
                }), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: "MD5",
                    paySign: t.data.paySign,
                    success: function(t) {
                        wx.navigateTo({
                            url: "/pages/index/issueaa/issueaa"
                        }), wx.showToast({
                            title: t.data.retDesc,
                            icon: "none",
                            duration: 1e3
                        });
                    },
                    fail: function(t) {
                        e.setData({
                            buttom: ""
                        });
                    }
                });
            }
        });
    },
    hint: function(t) {
        wx.showToast({
            title: "后台自动计算价格",
            icon: "none",
            duration: 1e3
        });
    },
    add: function(t) {
        var e = this, t = t, a = e.data.fwxm, o = e.data.jiaz, n = e.data.dz, i = e.data.JWD, l = e.data.station_num, s = e.data.arr;
        if (s.length >= l) wx.showToast({
            title: "最多" + l + "个途径站",
            icon: "none",
            duration: 1e3
        }); else {
            if (console.log(a), console.log(o), console.log(n), console.log(i), console.log(s), 
            "" == a) return void wx.showToast({
                title: "途径站不能为空",
                icon: "none",
                duration: 1e3
            });
            if ("" == o) wx.showToast({
                title: "价格不能为空",
                icon: "none",
                duration: 1e3
            }); else {
                for (var r in s) if (console.log(s[r].fwxm), console.log("" == a), s[r].fwxm == a) return void wx.showToast({
                    title: "途径站不能相同",
                    icon: "none",
                    duration: 1e3
                });
                var c = [];
                if (c = [ {
                    fwxm: a,
                    jiaz: o,
                    dz: n,
                    JWD: i
                } ], s.push(c[0]), console.log(c), e.setData({
                    arr: s,
                    value1: "",
                    value3: "",
                    fwxm: "",
                    jiaz: ""
                }), "add" == t) return void e.quedinyes();
            }
        }
    },
    fwmc: function(t) {
        var e = this;
        console.log(t);
        var a = t.detail.value, o = t.currentTarget.dataset.id, n = t.currentTarget.dataset.name;
        e.setData({
            fwxm: a,
            id: o,
            name: n
        }), e.gai(a);
    },
    jiaz: function(t) {
        var e = this;
        console.log(t);
        var a = t.detail.value, o = t.currentTarget.dataset.id, n = t.currentTarget.dataset.name;
        e.setData({
            jiaz: a,
            id: o,
            name: n
        }), e.gai(a);
    },
    gai: function(t) {
        console.log("修改");
        var e = this, a = e.data.arr, o = e.data.id, n = e.data.name, t = t;
        console.log(a), console.log(o), console.log(n), console.log(t);
        for (var i in a) o == i && (a[i][n] = t);
        console.log(a), e.setData({
            arr: a
        });
    },
    quedinyes: function(t) {
        var e = this, a = e.data.fwxm, o = e.data.arr;
        console.log("fwxm:", a), console.log("arr:", o);
        var n = "";
        if ("" == a) {
            for (var i in o) n += o[i].fwxm + "," + o[i].JWD + "," + o[i].dz + "," + o[i].jiaz + "||";
            var l = n.slice(0, -2);
            console.log("mid_i:", l), e.setData({
                classs: "1",
                mid_i: l
            });
        } else e.add("add");
    },
    onReady: function() {},
    delqq: function(t) {
        for (var e = this, a = t.currentTarget.dataset.id.fwxm, o = t.currentTarget.dataset.index, n = t.currentTarget.dataset.one, i = e.data.arr, l = 0; l < i.length; l++) 1 == i.length ? i = [] : i[l].fwxm == a && i.splice(o, 1);
        console.log(i), 1 == n ? e.setData({
            array: i,
            arr: i,
            one: 1,
            fwxm: "",
            jiaz: ""
        }) : e.setData({
            arr: i
        });
    },
    seek: function(t) {
        var e = this, a = e.data.station_num;
        e.data.arr.length >= a ? wx.showToast({
            title: "最多" + a + "个途径站",
            icon: "none",
            duration: 1e3
        }) : wx.navigateTo({
            url: "/pages/seek/seek"
        });
    }
}, t(e, "onReady", function() {}), t(e, "onShow", function() {
    var t = this, e = a.data.title, o = a.data.address, n = a.data.JWD;
    t.setData({
        value1: e,
        fwxm: e,
        dz: o,
        JWD: n
    }), console.log("11111111111111111111111111");
}), t(e, "onHide", function() {}), t(e, "onUnload", function() {}), t(e, "onPullDownRefresh", function() {}), 
t(e, "onReachBottom", function() {}), t(e, "onShareAppMessage", function() {}), 
e));