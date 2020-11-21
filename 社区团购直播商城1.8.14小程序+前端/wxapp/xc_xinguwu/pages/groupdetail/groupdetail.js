var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        animationData: {},
        num: 1,
        show_img: "",
        price: 0,
        totalprice: 0,
        attr: "",
        size: 0,
        staus: 1,
        cid: "",
        curIndex: 0
    },
    holdBack: function() {},
    bindTap: function(t) {
        this.setData({
            curIndex: t.currentTarget.dataset.index
        });
    },
    addCount: function(t) {
        var a = this;
        if ("" != a.data.attr) if (2 != a.data.list.pattern || 0 != a.data.size) {
            var e = a.data.stock, o = a.data.num;
            "0" != a.data.list.limit_num && parseInt(o) + 1 > parseInt(a.data.list.limit_num) ? app.look.alert("单次限购" + a.data.list.limit_num) : parseInt(o) + 1 > parseInt(e) || a.setData({
                num: o + 1,
                totalprice: a.data.price * (o + 1)
            });
        } else app.look.alert("请先选择属性"); else app.look.alert("请先选择属性");
    },
    minusCount: function(t) {
        var a = this;
        if ("" != a.data.attr) if (2 != a.data.list.pattern || 0 != a.data.size) {
            var e = a.data.num;
            1 != e && a.setData({
                num: e - 1,
                totalprice: a.data.price * (e - 1)
            });
        } else app.look.alert("请先选择属性"); else app.look.alert("请先选择属性");
    },
    toindex: function() {
        wx.reLaunch({
            url: "../index/index"
        });
    },
    seeMore: function() {
        var t = this.data.sponsor;
        app.look.istrue(t) && this.countDown(t), this.setData({
            group: !0
        });
    },
    close: function() {
        this.setData({
            group: !1,
            tjoin: !1,
            joindetail: !1
        });
    },
    join: function(t) {
        var o = this.data.sponsor[t.currentTarget.dataset.index], s = o.scale, i = this, n = [];
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "get_sponsor_tuxedo",
                id: o.id
            },
            success: function(t) {
                var a = t.data;
                if (a.data.tuxedo) {
                    s -= a.data.tuxedo.length;
                    for (var e = 0; e < s; e++) n.push("1");
                    i.setData({
                        tuxedo: a.data.tuxedo,
                        tuxedo_none: n
                    });
                } else {
                    for (e = 0; e < s; e++) n.push("1");
                    i.setData({
                        tuxedo_none: n
                    });
                }
                i.setData({
                    bd_sponsor: o,
                    group: !1,
                    tjoin: !0
                });
            }
        });
    },
    joindetail: function() {
        this.setData({
            tjoin: !1,
            joindetail: !0
        });
    },
    chooseSezi: function(t) {
        var a = this, e = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (a.animation = e).translateY(100).step(), a.setData({
            animationData1: e.export(),
            chooseSize: !0,
            show2: !0
        }), setTimeout(function() {
            e.translateY(0).step(), a.setData({
                animationData1: e.export()
            });
        }, 200);
    },
    hideModal: function(t) {
        var a = this, e = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (a.animation = e).translateY(100).step(), a.setData({
            animationData1: e.export()
        }), setTimeout(function() {
            e.translateY(0).step(), a.setData({
                animationData1: e.export(),
                chooseSize: !1,
                show2: !0,
                step: !0
            });
        }, 200);
    },
    onLoad: function(i) {
        var n = this;
        i.style = 0 < i.style ? i.style : 1, n.setData({
            options: i
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "get_group_detail",
                id: i.id,
                style: i.style,
                sponsor_id: i.sponsor_id
            },
            success: function(t) {
                var a = t.data;
                if (a.data.list && (n.countDown_group(a.data.list), n.setData({
                    totalprice: a.data.list.show_price
                })), a.data.good && (WxParse.wxParse("article", "html", a.data.good.contents, n, 10), 
                n.setData({
                    good: a.data.good,
                    show_img: a.data.good.bimg
                })), a.data.sponsor && (n.setData({
                    sponsor: a.data.sponsor
                }), app.look.istrue(a.data.sponsor) && n.countDown(a.data.sponsor)), a.data.sponsor_self && n.countDown_sponsor(a.data.sponsor_self), 
                a.data.sponsor_share && (2 == a.data.sponsor_share.status ? (a.data.sponsor_share = null, 
                n.setData({
                    "options.style": 1
                }), wx.showModal({
                    title: "提示",
                    content: "当前拼团已满员，请 重新开团",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm ? console.log("用户点击确定") : t.cancel && console.log("用户点击取消");
                    }
                })) : n.countDown_sponsor_share(a.data.sponsor_share)), 2 == i.style) if (a.data.tuxedo) {
                    for (var e = a.data.sponsor_share.scale - a.data.tuxedo.length, o = [], s = 0; s < e; s++) o.push("1");
                    n.setData({
                        tuxedo: a.data.tuxedo,
                        tuxedo_none: o
                    });
                } else {
                    for (e = a.data.sponsor_share.scale, o = [], s = 0; s < e; s++) o.push("1");
                    n.setData({
                        tuxedo_none: o
                    });
                }
                a.data.sponsor_share && n.setData({
                    size: a.data.sponsor_share.scale
                }), n.selectAttrmi(n);
            }
        });
    },
    onReady: function() {
        app.look.navbar(this), app.look.accredit(this), app.look.goHome(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "get_group_detail",
                id: i.data.options.id,
                style: i.data.options.style,
                sponsor_id: i.data.options.sponsor_id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                if (a.data.list && (i.countDown_group(a.data.list), i.setData({
                    totalprice: a.data.list.show_price
                })), a.data.good && i.setData({
                    good: a.data.good,
                    show_img: a.data.good.bimg
                }), a.data.sponsor && i.setData({
                    sponsor: a.data.sponsor
                }), a.data.sponsor_self && i.countDown_sponsor(a.data.sponsor_self), a.data.sponsor_share && i.countDown_sponsor_share(a.data.sponsor_share), 
                2 == options.style) if (a.data.tuxedo) {
                    for (var e = a.data.sponsor_share.scale - a.data.tuxedo.length, o = [], s = 0; s < e; s++) o.push("1");
                    i.setData({
                        tuxedo: a.data.tuxedo,
                        tuxedo_none: o
                    });
                } else {
                    for (e = a.data.sponsor_share.scale, o = [], s = 0; s < e; s++) o.push("1");
                    i.setData({
                        tuxedo_none: o
                    });
                }
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var a = "你的朋友邀请您一起参加" + this.data.list.good_name + "的团购活动", e = "", o = "";
        app.look.istrue(this.data.good.share.img) && (o = this.data.good, share.img);
        var s = this.data.list.id;
        if ("button" == t.from) {
            t.target.dataset.index;
            return e = "../groupdetail/groupdetail?id=" + s + "&style=2&sponsor_id=" + this.data.sponsor_self[this.data.index].id, 
            {
                title: a,
                path: "/xc_xinguwu/pages/base/base?share=" + (e = encodeURIComponent(e)) + "&userid=" + app.globalData.userInfo.id,
                imageUrl: o,
                success: function(t) {
                    wx.showToast({
                        title: "转发成功"
                    });
                },
                fail: function(t) {}
            };
        }
    },
    previewImage: function(t) {
        var a = t.currentTarget.dataset.src, e = this.data.good;
        wx.previewImage({
            current: a,
            urls: e.imgs
        });
    },
    selectAttr: function(t) {
        var a = this, e = t.currentTarget.dataset.index, o = a.data.list, s = a.data.good;
        if (0 != s.attrs[e].stock) {
            if (app.look.istrue(s.attrs[e].img)) var i = s.attrs[e].img; else i = s.bimg;
            1 == o.pattern && a.setData({
                attr: e,
                totalprice: o.attr.attr[e].group_price,
                price: o.attr.attr[e].group_price,
                num: 1,
                show_img: i,
                stock: s.attrs[e].stock
            }), 2 == o.pattern && (a.setData({
                attr: e,
                num: 1,
                show_img: i,
                stock: s.attrs[e].stock
            }), app.look.istrue(a.data.size) && a.setData({
                totalprice: o.attr[a.data.size][e].group_price,
                price: o.attr[a.data.size][e].group_price
            }));
        }
    },
    selectAttrmi: function(t) {
        var a = t.data.list, e = t.data.good, o = Object.keys(e.attrs)[0];
        if (0 != e.attrs[o].stock) {
            if (app.look.istrue(e.attrs[o].img)) var s = e.attrs[o].img; else s = e.bimg;
            if (1 == a.pattern && t.setData({
                attr: o,
                totalprice: a.attr.attr[o].group_price,
                price: a.attr.attr[o].group_price,
                num: 1,
                show_img: s,
                stock: e.attrs[o].stock
            }), 2 == a.pattern) {
                var i = Object.keys(a.attr)[0];
                console.log("attrsizeattrsizeattrsizeattrsize"), console.log(a.attr), Object.keys(a.attr), 
                t.setData({
                    attr: o,
                    num: 1,
                    show_img: s,
                    stock: e.attrs[o].stock,
                    size: i
                }), app.look.istrue(t.data.size) && t.setData({
                    totalprice: a.attr[t.data.size][o].group_price,
                    price: a.attr[t.data.size][o].group_price
                });
            }
        }
    },
    selectSize: function(t) {
        var a = t.currentTarget.dataset.size, e = this;
        e.setData({
            size: a
        }), app.look.istrue(e.data.attr) && e.setData({
            totalprice: e.data.list.attr[a][e.data.attr].group_price,
            price: e.data.list.attr[a][e.data.attr].group_price
        });
    },
    selectSizemi: function(t, a) {
        t.setData({
            size: a
        }), app.look.istrue(t.data.attr) && t.setData({
            totalprice: t.data.list.attr[a][t.data.attr].group_price,
            price: t.data.list.attr[a][t.data.attr].group_price
        });
    },
    sureBuy: function() {
        var t = this, a = t.data.list.id, e = t.data.num, o = t.data.attr, s = t.data.cid, i = t.data.options.style;
        if ("" != o) if (2 != t.data.list.pattern || 1 != t.options.style || 0 != t.data.size) {
            var n = [];
            n.push({
                id: this.data.list.good_id,
                img: this.data.good.bimg,
                num: e,
                price: this.data.price,
                name: this.data.list.good_name,
                attr: o,
                attr_name: this.data.good.attr_name,
                weight: this.data.good.weight
            });
            var r = [];
            r = {
                content: n,
                totalPrice: this.data.totalprice,
                totalNum: e,
                cid: 5,
                cid_type: s,
                style: i,
                group_id: a
            };
            var d;
            1 == i && (r.size = this.data.size, 2 == s && (r.sponsor_id = this.data.bd_sponsor.id)), 
            2 == i && (r.size = this.data.sponsor_share.scale, r.sponsor_id = this.data.options.sponsor_id), 
            r = JSON.stringify(r), d = "../submit/submit?order=" + (r = encodeURIComponent(r)), 
            console.log(d), wx.navigateTo({
                url: d
            });
        } else app.look.alert("请先选择属性"); else app.look.alert("请先选择属性");
    },
    singleBuy: function() {
        wx.navigateTo({
            url: "../detail/detail?id=" + this.data.list.good_id
        });
    },
    timeFormat: function(t) {
        return t < 10 ? "0" + t : t;
    },
    countDown_group: function(t) {
        var a = new Date().getTime(), e = new Date(app.look.change_date(t.deadline)).getTime(), o = null;
        if (!(0 < e - a)) return o = {
            day: "00",
            hou: "00",
            min: "00",
            sec: "00"
        }, void wx.showToast({
            title: "该活动已结束!",
            type: "none",
            success: function() {
                wx.redirectTo({
                    url: "../detail/detail?id=" + t.good_id
                });
            }
        });
        var s = (e - a) / 1e3, i = parseInt(s / 86400), n = parseInt(s % 86400 / 3600), r = parseInt(s % 86400 % 3600 / 60), d = parseInt(s % 86400 % 3600 % 60);
        o = {
            day: this.timeFormat(i),
            hou: this.timeFormat(n),
            min: this.timeFormat(r),
            sec: this.timeFormat(d)
        }, t.countDownArr = o, this.setData({
            list: t
        });
        var p = this;
        setTimeout(function() {
            p.countDown_group(t);
        }, 1e3);
    },
    countDown: function(t) {
        for (var a = new Date().getTime(), e = 0, o = t.length; e < o; e++) {
            var s = new Date(app.look.change_date(t[e].endtime)).getTime(), i = null;
            if (0 < s - a) {
                var n = (s - a) / 1e3, r = parseInt(n / 86400), d = parseInt(n % 86400 / 3600), p = parseInt(n % 86400 % 3600 / 60), u = parseInt(n % 86400 % 3600 % 60);
                i = {
                    day: this.timeFormat(r),
                    hou: this.timeFormat(d),
                    min: this.timeFormat(p),
                    sec: this.timeFormat(u)
                };
            } else i = {
                day: "00",
                hou: "00",
                min: "00",
                sec: "00"
            }, t[e].status = -1;
            t[e].countDownArr = i;
        }
        this.setData({
            sponsor: t
        });
        var c = this;
        setTimeout(function() {
            c.countDown(t);
        }, 1e3);
    },
    countDown_sponsor: function(t) {
        for (var a = new Date().getTime(), e = 0, o = t.length; e < o; e++) {
            var s = new Date(app.look.change_date(t[e].endtime)).getTime(), i = null;
            if (0 < s - a) {
                var n = (s - a) / 1e3, r = parseInt(n / 86400), d = parseInt(n % 86400 / 3600), p = parseInt(n % 86400 % 3600 / 60), u = parseInt(n % 86400 % 3600 % 60);
                i = {
                    day: this.timeFormat(r),
                    hou: this.timeFormat(d),
                    min: this.timeFormat(p),
                    sec: this.timeFormat(u)
                };
            } else i = {
                day: "00",
                hou: "00",
                min: "00",
                sec: "00"
            }, t[e].status = -1;
            t[e].countDownArr = i;
        }
        this.setData({
            sponsor_self: t
        });
        var c = this;
        setTimeout(function() {
            c.countDown_sponsor(t);
        }, 1e3);
    },
    countDown_sponsor_share: function(t) {
        var a = new Date().getTime(), e = new Date(app.look.change_date(t.endtime)).getTime(), o = null;
        if (0 < e - a) {
            var s = (e - a) / 1e3, i = parseInt(s / 86400), n = parseInt(s % 86400 / 3600), r = parseInt(s % 86400 % 3600 / 60), d = parseInt(s % 86400 % 3600 % 60);
            o = {
                day: this.timeFormat(i),
                hou: this.timeFormat(n),
                min: this.timeFormat(r),
                sec: this.timeFormat(d)
            };
        } else o = {
            day: "00",
            hou: "00",
            min: "00",
            sec: "00"
        }, t.status = -1;
        t.countDownArr = o, this.setData({
            sponsor_share: t
        });
        var p = this;
        setTimeout(function() {
            p.countDown_sponsor_share(t);
        }, 1e3);
    },
    sureJoin: function() {
        this.setData({
            cid: 2
        }), this.close(), this.chooseSezi();
    },
    suresponsor: function() {
        this.setData({
            cid: 1
        }), this.chooseSezi();
    },
    joinsponsor: function() {
        1 == this.data.sponsor_share.status && (this.setData({
            cid: 2
        }), this.chooseSezi());
    },
    toshare: function(t) {
        -1 != this.data.sponsor_self[t.currentTarget.dataset.index].status && (this.setData({
            index: t.currentTarget.dataset.index
        }), this.share());
    },
    share: function(t) {
        var a = this, e = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (a.animation = e).translateY(100).step(), a.setData({
            animationData: e.export(),
            share: !0,
            show1: !0
        }), setTimeout(function() {
            e.translateY(0).step(), a.setData({
                animationData: e.export()
            });
        }, 200);
    },
    hideshare: function() {
        var t = this, a = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (t.animation = a).translateY(100).step(), t.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.translateY(0).step(), t.setData({
                animationData: a.export(),
                share: !1,
                show1: !1
            });
        }, 200);
    },
    shengcheng: function() {
        var a = this, t = this.data.list;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "groupdetail_poster",
                good_img: a.data.good.bimg,
                good_name: t.good_name,
                old_price: t.old_price,
                price: t.show_price,
                id: t.id,
                sponsor_id: a.data.sponsor_self[a.data.index].id
            },
            success: function(t) {
                wx.hideLoading(), a.setData({
                    poster: t.data.data,
                    shengc: !0,
                    share: !1
                });
            }
        });
    },
    saveImageToPhotosAlbum: function() {
        wx.downloadFile({
            url: this.data.poster,
            success: function(t) {
                var a = t.tempFilePath;
                wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function(t) {
                        wx.saveImageToPhotosAlbum({
                            filePath: a,
                            success: function(t) {
                                app.look.alert("保存成功");
                            },
                            fail: function(t) {
                                "saveImageToPhotosAlbum:fail auth deny" === t.errMsg && wx.openSetting({
                                    success: function(t) {}
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    previewImage_poster: function() {
        wx.previewImage({
            urls: [ this.data.poster ]
        });
    },
    hidesc: function() {
        this.setData({
            shengc: !1
        });
    },
    onGotUserInfo: function(t) {
        app.look.getuserinfo(t, this);
    }
});