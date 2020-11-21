var a = getApp(), e = require("../../../../3421FA616A7AF98C524792666BF19D70.js");

Page({
    data: {
        nid: "",
        ntype: "",
        info: [],
        starting_place: "",
        end_place: "",
        number: "",
        money: "",
        begin_time: "",
        end_time: "",
        data: "",
        note: "",
        b_lnglat: "",
        e_lnglat: "",
        aarr: [ 1, 2, 3, 4, 5, 6, 7 ],
        arr: "",
        station_num: "",
        mid_i: "",
        show: ""
    },
    onLoad: function(e) {
        var t = this;
        t.location();
        try {
            (n = wx.getStorageSync("session")) && (console.log("logintag:", n), t.setData({
                logintag: n
            }));
        } catch (e) {}
        try {
            (n = wx.getStorageSync("Bid")) && (console.log("Bid:", n), t.setData({
                nid: n
            }));
        } catch (e) {}
        try {
            var n = wx.getStorageSync("Bntype");
            n && (console.log("Bntype:", n), t.setData({
                ntype: n
            }));
        } catch (e) {}
        var o = t.data.ntype, l = t.data.nid, i = t.data.logintag;
        if (1 == o) s = "passenger_modi_task"; else var s = "car_owner_task_modi_view";
        wx.request({
            url: a.data.url + s,
            data: {
                logintag: i,
                nid: l
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                console.log(s + " => 编辑页面数据展现"), console.log(a);
                if ("0000" == a.data.retCode) {
                    var e = a.data.station;
                    for (var n in e) e[n].JWD = e[n].lng + "," + e[n].lat, e[n].dz = e[n].end_addr;
                    console.log(e), t.setData({
                        info: a.data.info,
                        station_num: a.data.station_num,
                        starting_place: a.data.info.starting_place,
                        end_place: a.data.info.end_place,
                        number: a.data.info.number,
                        money: a.data.info.money,
                        begin_time: a.data.info.begin_time.split(" ")[1],
                        end_time: a.data.info.end_time.split(" ")[1],
                        data: a.data.info.end_time.split(" ")[0],
                        note: a.data.info.note,
                        b_lnglat: a.data.info.b_lnglat,
                        e_lnglat: a.data.info.e_lnglat,
                        begin_addr: a.data.info.begin_addr,
                        end_addr: a.data.info.end_addr,
                        arr: e,
                        value1: ""
                    });
                } else wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "没有记录" == a.data.retDesc && t.setData({
                    info: []
                });
            }
        });
    },
    swop: function(a) {
        var e = this, t = e.data.starting_place, n = e.data.end_place, o = e.data.b_lnglat, l = e.data.e_lnglat, i = e.data.begin_addr, s = e.data.end_addr;
        if (console.log("交换之前 => b_lnglat：", o), console.log("交换之前 => e_lnglat：", l), t || n) {
            e.setData({
                starting_place: n,
                end_place: t,
                b_lnglat: l,
                e_lnglat: o,
                begin_addr: s,
                end_addr: i
            }), wx.showToast({
                title: "位置互换成功",
                icon: "none",
                duration: 1e3
            });
            var o = e.data.b_lnglat, l = e.data.e_lnglat;
            console.log("交换之后 => b_lnglat：", o), console.log("交换之后 => e_lnglat：", l);
        } else wx.showToast({
            title: "操作无效",
            icon: "none",
            duration: 1e3
        });
    },
    origin: function(a) {
        var e = this;
        e.setData({
            starting_place: a.detail.value,
            origin_k: a.detail.value,
            commonality: "starting_place"
        }), e.deom(a.detail.value);
    },
    deom: function(a) {
        var t = this;
        console.log(a), new e({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).getSuggestion({
            keyword: a,
            success: function(a) {
                console.log(a.data), t.setData({
                    array: a.data
                });
            },
            fail: function(a) {
                console.log(a);
            },
            complete: function(a) {
                console.log(a);
            }
        });
    },
    title: function(a) {
        var e = this;
        "starting_place" == e.data.commonality ? e.setData({
            origin: a.currentTarget.dataset.address + a.currentTarget.dataset.title,
            origin_k: "",
            begin_addr: a.currentTarget.dataset.address,
            starting_place: a.currentTarget.dataset.title
        }) : e.setData({
            terminus: a.currentTarget.dataset.address + a.currentTarget.dataset.title,
            terminus_k: "",
            end_addr: a.currentTarget.dataset.address,
            end_place: a.currentTarget.dataset.title
        }), e.price();
    },
    price: function(a) {
        var t = this, n = t.data.commonality;
        if ("starting_place" == n) o = t.data.origin; else var o = t.data.terminus;
        new e({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).geocoder({
            address: o,
            success: function(a) {
                if (console.log(a.result.location), "starting_place" == n) {
                    var e = a.result.location.lat + "," + a.result.location.lng;
                    t.setData({
                        b_lnglat: e
                    }), console.log("起点腾讯接口获取经纬度 => b_lnglat", a.result.location.lat + "," + a.result.location.lng), 
                    console.log("起点腾讯接口获取经纬度 => b_lnglat", e);
                } else {
                    var o = a.result.location.lat + "," + a.result.location.lng;
                    t.setData({
                        e_lnglat: o
                    }), console.log("终点腾讯接口获取经纬度 => e_lnglat", a.result.location.lat + "," + a.result.location.lng), 
                    console.log("终点腾讯接口获取经纬度 => e_lnglat", o);
                }
                t.money();
            },
            fail: function(a) {
                console.log(a);
            },
            complete: function(a) {
                console.log(a);
            }
        });
    },
    money: function(e) {
        var t = this, n = t.data.b_lnglat, o = t.data.e_lnglat, l = t.data.logintag;
        n && o && wx.request({
            url: a.data.url + "getprice",
            data: {
                logintag: l,
                b_lnglat: n,
                e_lnglat: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                if (console.log("getprice => 获取用户的车资"), console.log(a), "0000" == a.data.retCode) {
                    var e = a.data.price;
                    t.setData({
                        money: e
                    });
                } else wx.showToast({
                    title: "获取数据失败",
                    icon: "none",
                    duration: 800
                });
            }
        });
    },
    ok: function(a) {
        var e = this;
        e.setData({
            origin_k: "",
            terminus_k: ""
        }), e.price();
    },
    terminus: function(a) {
        var e = this;
        e.setData({
            end_place: a.detail.value,
            terminus_k: a.detail.value,
            commonality: "end_place"
        }), e.deom(a.detail.value);
    },
    bindPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value);
        var e = parseInt(a.detail.value) + 1;
        this.setData({
            number: e
        });
    },
    bindDateChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            data: a.detail.value
        });
    },
    bindTimeChange: function(a) {
        var e = this.data.end_time;
        "00:00" !== e ? e > a.detail.value ? this.setData({
            begin_time: a.detail.value
        }) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        }) : this.setData({
            begin_time: a.detail.value
        });
    },
    bindTimeChange2: function(a) {
        this.data.begin_time < a.detail.value ? this.setData({
            end_time: a.detail.value
        }) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        });
    },
    remark: function(a) {
        var e = this;
        console.log(a.detail.value), e.setData({
            note: a.detail.value
        });
    },
    location: function(a) {
        console.log("index.js => location调用了");
        var t = this, n = new e({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        });
        wx.getLocation({
            type: "gcj02",
            success: function(a) {
                var e = a.latitude, o = a.longitude;
                console.log("yval:", e), console.log("xval:", o), n.reverseGeocoder({
                    location: {
                        latitude: e,
                        longitude: o
                    },
                    success: function(a) {
                        console.log(a.result.address_component.city);
                        var e = a.result.address_component.city;
                        t.setData({
                            location: e
                        }), wx.setStorage({
                            key: "location",
                            data: e
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    },
                    complete: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    },
    confirm: function(e) {
        var t = this, n = t.data.logintag, o = t.data.ntype, l = t.data.nid, i = t.data.data, s = t.data.begin_addr, d = t.data.end_addr, r = t.data.b_lnglat, c = t.data.e_lnglat, g = t.data.starting_place, u = t.data.end_place, _ = t.data.number, f = t.data.money, m = i + " " + t.data.begin_time, w = i + " " + t.data.end_time, v = t.data.note, p = t.data.location, h = t.data.mid_i;
        if (console.log(i), console.log("begin_addr:", s), console.log("end_addr:", d), 
        console.log("b_lnglat:", r), console.log("e_lnglat:", c), console.log("starting_place:", g), 
        console.log("end_place:", u), console.log("number:", _), console.log("money:", f), 
        console.log("begin_time:", m), console.log("end_time:", w), console.log("note:", v), 
        console.log("area_name:", p), console.log("nid:", l), console.log("ntype:", o), 
        console.log("mid_info:", h), "" != i && void 0 != i) if (void 0 != g && "" != g) if ("" != u) if (null != _) if ("00:00" != m) if ("00:00" != w) {
            if (1 == o) x = "passenger_modi_task_handle"; else var x = "car_owner_task_modi_handle";
            wx.request({
                url: a.data.url + x,
                data: {
                    logintag: n,
                    starting_place: g,
                    end_place: u,
                    begin_time: m,
                    end_time: w,
                    number: _,
                    note: v,
                    money: f,
                    area_name: p,
                    b_lnglat: r,
                    e_lnglat: c,
                    begin_addr: s,
                    end_addr: d,
                    nid: l,
                    mid_info: h
                },
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(a) {
                    console.log(x + " => 修改发布行程"), console.log(a), "0000" == a.data.retCode ? (wx.showToast({
                        title: a.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }), setTimeout(function() {
                        console.log("延迟调用============"), wx.navigateBack({
                            delta: 1,
                            success: function(a) {
                                var e = getCurrentPages().pop();
                                void 0 != e && null != e && e.onLoad();
                            }
                        });
                    }, 1e3)) : wx.showToast({
                        title: a.data.retDesc,
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
    delet: function(e) {
        var t = this, n = t.data.logintag, o = t.data.ntype, l = t.data.nid;
        if (1 == o) i = "passenger_del_order"; else var i = "car_owner_task_cancel";
        wx.request({
            url: a.data.url + i,
            data: {
                logintag: n,
                nid: l
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                console.log(i + " => 删除订单"), console.log(a), "0000" == a.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(a) {
                        var e = getCurrentPages().pop();
                        void 0 != e && null != e && e.onLoad();
                    }
                }), wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    add: function(a) {
        var e = this, a = a, t = e.data.fwxm, n = e.data.jiaz, o = e.data.dz, l = e.data.JWD, i = e.data.station_num, s = e.data.arr;
        if (s.length >= i) wx.showToast({
            title: "最多" + i + "个途径站",
            icon: "none",
            duration: 1e3
        }); else {
            if (console.log(t), console.log(n), console.log(o), console.log(l), console.log(s), 
            "" == t) return void wx.showToast({
                title: "途径站不能为空",
                icon: "none",
                duration: 1e3
            });
            if (void 0 == n || "" == n) wx.showToast({
                title: "价格不能为空",
                icon: "none",
                duration: 1e3
            }); else {
                for (var d in s) if (console.log(s[d].end_place), console.log("" == t), s[d].end_place == t) return void wx.showToast({
                    title: "途径站不能相同",
                    icon: "none",
                    duration: 1e3
                });
                var r = [];
                if (r = [ {
                    end_place: t,
                    money: n,
                    dz: o,
                    JWD: l
                } ], s.push(r[0]), console.log(r), e.setData({
                    arr: s,
                    value1: "",
                    value3: "",
                    fwxm: "",
                    jiaz: ""
                }), "add" == a) return void e.quedinyes();
            }
        }
    },
    fwmc: function(a) {
        var e = this;
        console.log(a);
        var t = a.detail.value, n = a.currentTarget.dataset.id, o = a.currentTarget.dataset.name;
        e.setData({
            fwxm: t,
            id: n,
            name: o
        }), e.gai(t);
    },
    jiaz: function(a) {
        var e = this;
        console.log(a);
        var t = a.detail.value, n = a.currentTarget.dataset.id, o = a.currentTarget.dataset.name;
        e.setData({
            jiaz: t,
            id: n,
            name: o
        }), e.gai(t);
    },
    gai: function(a) {
        console.log("修改");
        var e = this, t = e.data.arr, n = e.data.id, o = e.data.name, a = a;
        console.log(t), console.log(n), console.log(o), console.log(a);
        for (var l in t) n == l && (t[l][o] = a);
        console.log(t), e.setData({
            arr: t
        });
    },
    quedinyes: function(a) {
        var e = this, t = e.data.fwxm, n = e.data.arr;
        console.log("fwxm:", t), console.log("arr:", n);
        var o = "";
        if ("" == t) {
            for (var l in n) o += n[l].end_place + "," + n[l].JWD + "," + n[l].dz + "," + n[l].money + "||";
            var i = o.slice(0, -2);
            console.log("mid_i:", i), e.setData({
                classs: "1",
                mid_i: i
            });
        } else e.add("add");
    },
    delqq: function(a) {
        for (var e = this, t = a.currentTarget.dataset.id.fwxm, n = a.currentTarget.dataset.index, o = a.currentTarget.dataset.one, l = e.data.arr, i = 0; i < l.length; i++) 1 == l.length ? l = [] : l[i].fwxm == t && l.splice(n, 1);
        console.log(l), 1 == o ? e.setData({
            array: l,
            arr: l,
            one: 1,
            fwxm: "",
            jiaz: ""
        }) : e.setData({
            arr: l
        });
    },
    seek: function(a) {
        var e = this, t = e.data.station_num, n = e.data.arr;
        console.log(n), void 0 == n || "" == n ? wx.navigateTo({
            url: "/pages/seek/seek"
        }) : n.length >= t ? wx.showToast({
            title: "最多" + t + "个途径站",
            icon: "none",
            duration: 1e3
        }) : wx.navigateTo({
            url: "/pages/seek/seek"
        });
    },
    show: function(a) {
        var e = this, t = e.data.show;
        t ? e.setData({
            show: ""
        }) : e.setData({
            show: "show"
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = a.data.title, n = a.data.address, o = a.data.JWD;
        e.setData({
            value1: t,
            fwxm: t,
            dz: n,
            JWD: o
        }), console.log("11111111111111111111111111");
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});