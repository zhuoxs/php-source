var app = getApp();

Page({
    data: {
        thiseven: 0,
        liaa: 0,
        gun: !0,
        text: [ "综合", "佣金比例", "销量", "价格" ],
        zoor: 0,
        searchinput: "",
        fen: !0,
        loding: !0,
        rankno: 0,
        jingxu: [ "拼多多", "蘑菇街" ],
        parameter: 0,
        edition: !1,
        doneLoading: !0,
        pageNum: 0,
        currentTab: 0,
        navScrollLeft: 0,
        jump: 0
    },
    bindchange: function(a) {
        this.setData({
            tuhight: a.detail.current
        });
    },
    joggle: function() {
        var a = this, t = a.data.parameter;
        if (0 == t) var e = "entry/wxapp/Goodslist", i = "../../resource/images/pd.png"; else if (1 == t) e = "entry/wxapp/Mogugoodslist", 
        i = "../../resource/images/mg.png"; else if (2 == t) e = "entry/wxapp/Jdgoodslist", 
        i = "../../resource/images/jd.png";
        a.setData({
            Goodslist: e,
            sahngf_view_img: i
        }), a.shangpin();
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 0
        }), this.joggle();
    },
    submitInfotwo: function(a) {
        console.log("获取id");
        var t = a.detail.formId;
        console.log(t), console.log("获取formid结束"), this.setData({
            formid: t
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: this.data.formid
            },
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/Formid",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    },
    submitInfodetails: function(a) {
        this.submitInfotwo(a), this.details(a);
    },
    onLoad: function(a) {
        var t = this, e = (a.cateid, a.currentTab);
        if ("" == e || null == e) var i = 0; else {
            i = e;
            setTimeout(function() {
                t.switchTabviewlist();
            }, 2e3);
        }
        t.setData({
            qieone: 0,
            qietwo: 0,
            qiethree: 0,
            currentTab: e,
            jump: i
        }), t.Headcolor(), t.goodslista(t.data.jump);
    },
    switchTabviewlist: function() {
        var t = this;
        wx.getSystemInfo({
            success: function(a) {
                t.setData({
                    windowHeight: a.windowHeight,
                    windowWidth: a.windowWidth
                });
            }
        });
        var a = t.data.windowWidth / 5, e = t.data.jump;
        t.setData({
            navScrollLeft: (Number(e) - 2) * a
        });
    },
    fanhui: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    fenleiqie: function() {
        var a = this.data.fen;
        this.setData({
            fen: !a
        });
    },
    bindHideKeyboard: function(a) {
        var t = a.detail.value;
        this.setData({
            inputValue: t
        });
    },
    bindViewTap: function() {
        console.log("搜索");
        var s = this, a = s.data.inputValue;
        s.setData({
            inputValue: a
        }), app.util.request({
            url: "entry/wxapp/Goodslist",
            method: "POST",
            data: {
                inputValue: a,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.banner, i = a.data.data.nav;
                s.setData({
                    goodsist: t,
                    banner: e,
                    nav: i
                }), console.log(t.length);
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    quxiao: function(a) {
        console.log("删除文字");
        this.data.inputValue, this.data.goodsist;
        this.setData({
            searchinput: "",
            inputValue: "",
            goodsist: null
        });
    },
    shangpin: function() {
        var i = this;
        app.util.request({
            url: i.data.Goodslist,
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.goodtoplist;
                i.setData({
                    goodsist: t,
                    goodtoplist: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    tu: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Share",
            method: "POST",
            success: function(a) {
                a.data.data.fenxtu;
                t.setData({
                    goodsist: goodsist
                });
            }
        });
    },
    fenlei: function(a) {
        var s = this, t = a.currentTarget.dataset.cateid;
        s.setData({
            cateid: t
        }), app.util.request({
            url: "entry/wxapp/Goodslist",
            method: "POST",
            data: {
                cateid: t,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.banner, i = a.data.data.nav;
                s.setData({
                    goodsist: t,
                    banner: e,
                    nav: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    jaizai: function(a) {
        var i = this, s = i.data.goodsist;
        app.util.request({
            url: i.data.Goodslist,
            method: "POST",
            data: {
                pageNum: a,
                user_id: app.globalData.user_id,
                rankno: i.data.rankno
            },
            success: function(a) {
                for (var t = a.data.data.list, e = 0; e < t.length; e++) s.push(t[e]);
                i.setData({
                    goodsist: s,
                    loding: !0
                });
            }
        });
    },
    onReachBottom: function() {
        if (0 == this.data.config.tuijian_type) {
            var a = this.data.pageNum;
            a++, this.jaizai(a), this.setData({
                loding: !1,
                pageNum: a
            });
        }
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.jump, i = a.currentTarget.dataset.hui, s = a.currentTarget.dataset.itemurl, o = a.currentTarget.dataset.skuid;
        if (1 == e) var n = 1; else if (7 == e) n = 2; else n = this.data.parameter;
        var d = a.currentTarget.dataset.materialurl, r = a.currentTarget.dataset.couponurl;
        0 == n ? wx.navigateTo({
            url: "../details/details?goods_id=" + t + "&hui=" + i + "&parameter=" + n
        }) : 1 == n ? wx.navigateTo({
            url: "../details/details?itemUrl=" + s + "&parameter=" + n
        }) : 2 == n && (app.globalData.couponUrl = r, wx.navigateTo({
            url: "../details/details?skuId=" + o + "&parameter=" + n + "&materialUrl=" + d
        }));
    },
    swiperChange: function(a) {
        this.setData({
            swiperCurrent: a.detail.current
        });
    },
    dianji: function(a) {
        var t = this, e = t.data.inputValue;
        null == e && (e = "");
        var i = a.currentTarget.dataset.index;
        if (0 == i) {
            t.data.qieone;
            0 == t.data.qieone ? (t.setData({
                qieone: 0
            }), t.paixu(0, e)) : (t.setData({
                qieone: 1
            }), t.paixu(1, e));
        }
        if (1 == i) {
            t.data.qieone;
            1 == t.data.qieone ? (t.setData({
                qieone: 2
            }), t.paixu(2, e)) : (t.setData({
                qieone: 1
            }), t.paixu(1, e));
        } else 1 != i && t.setData({
            qieone: 0
        });
        if (2 == i) {
            t.data.qietwo;
            1 == t.data.qietwo ? (t.setData({
                qietwo: 2
            }), t.paixu(6, e)) : (t.setData({
                qietwo: 1
            }), t.paixu(5, e));
        } else 2 != i && t.setData({
            qietwo: 0
        });
        if (3 == i) {
            t.data.qiethree;
            1 == t.data.qiethree ? (t.setData({
                qiethree: 2
            }), t.paixu(4, e)) : (t.setData({
                qiethree: 1
            }), t.paixu(3, e));
        } else 2 != i && t.setData({
            qiethree: 0
        });
        t.setData({
            thiseven: a.currentTarget.dataset.index
        }), setTimeout(function() {
            t.setData({
                liaa: a.currentTarget.dataset.index
            });
        }, 1e3);
    },
    qirw: function(a) {
        this.setData({
            zoor: a.currentTarget.dataset.index
        });
    },
    Headcolor: function() {
        var r = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a, t) {
                console.log(t);
                var e = a.data.data.config.search_color, i = a.data.data.config.share_icon, s = a.data.data.config.shenhe, o = a.data.data.config, n = a.data.data.is_daili;
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                a.data.data.config.title;
                app.globalData.title = a.data.data.config.title;
                var d = a.data.data.config.kaiguan;
                r.setData({
                    backgroundColor: a.data.data.config.head_color,
                    title: a.data.data.config.title,
                    search_color: e,
                    share_icon: i,
                    shenhe: s,
                    config: o,
                    is_daili: n,
                    kaiguan: d
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    paixu: function(a, t) {
        var s = this;
        a = a;
        s.setData({
            rankno: a
        }), app.util.request({
            url: s.data.Goodslist,
            method: "POST",
            data: {
                rankno: a,
                inputValue: t,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.banner, i = a.data.data.nav;
                s.setData({
                    goodsist: t,
                    banner: e,
                    nav: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onShow: function() {
        var t = this;
        this.Headcolor(), this.joggle(), wx.getSystemInfo({
            success: function(a) {
                t.setData({
                    windowHeight: a.windowHeight,
                    windowWidth: a.windowWidth
                });
            }
        });
    },
    switchNav: function(a) {
        var t = a.currentTarget.dataset.current, e = this.data.windowWidth / 5;
        if (this.setData({
            navScrollLeft: (t - 2) * e
        }), this.data.currentTab == t) return !1;
        this.setData({
            currentTab: t,
            pageNum: 0
        }), this.goodslista(t);
    },
    switchTab: function(a) {
        var t = a.detail.current, e = this.data.windowWidth / 5;
        this.setData({
            currentTab: t,
            navScrollLeft: (t - 2) * e,
            pageNum: 0
        }), this.goodslista(t);
    },
    goodslista: function(s) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Tuijianlist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                jump: s
            },
            success: function(a) {
                var t = a.data.data.goodslist;
                if (null == o.setData.sortcolor || null == o.setData.sortcolor) {
                    var e = a.data.data.color;
                    o.setData({
                        sortcolor: e
                    });
                }
                if (0 == s) {
                    (i = a.data.data.toplist)[0].goodslist = t;
                    i[0].titlecolor;
                } else {
                    if (i) var i = o.data.sort; else i = a.data.data.toplist;
                    i[s].goodslist = t;
                    i[s].titlecolor;
                }
                o.setData({
                    sort: i
                }), console.log(i);
            }
        });
    },
    switchTabta: function(a) {
        console.log(a);
    },
    sortjaizai: function(a) {
        var i = this, s = i.data.sort;
        app.util.request({
            url: "entry/wxapp/Tuijianlist",
            method: "POST",
            data: {
                pageNum: a,
                user_id: app.globalData.user_id,
                jump: i.data.currentTab
            },
            success: function(a) {
                var t = a.data.data.goodslist;
                console.log(t);
                for (var e = 0; e < t.length; e++) s[i.data.currentTab].goodslist.push(t[e]);
                i.setData({
                    sort: s,
                    loding: !0
                });
            }
        });
    },
    bindscrolltolower: function(a) {
        console.log(a);
        var t = this.data.pageNum;
        t++, this.sortjaizai(t), this.setData({
            pageNum: t,
            loding: !1
        });
    },
    onShareAppMessage: function(a) {
        if ("button" === a.from) {
            var t = this, e = a.target.dataset.src, i = a.target.dataset.id, s = a.target.dataset.name, o = a.target.dataset.goods_title, n = a.target.dataset.itemurl, d = a.target.dataset.skuid, r = t.data.parameter, l = a.target.dataset.materialurl, u = a.target.dataset.couponurl;
            if (t.setData({
                goods_src: e,
                goods_id: i,
                goods_name: s,
                goods_title: o
            }), 0 == r) var c = "hc_pdd/pages/details/details?goods_id=" + i + "&parameter=" + r + "&user_id=" + app.globalData.user_id; else if (1 == r) c = "hc_pdd/pages/details/details?itemUrl=" + n + "&parameter=" + r + "&user_id=" + app.globalData.user_id; else if (2 == r) c = "hc_pdd/pages/details/details?skuId=" + d + "&parameter=" + r + "&materialUrl=" + l + "&couponUrl=" + u + "&user_id=" + app.globalData.user_id;
            return {
                title: t.data.goods_title,
                path: c,
                imageUrl: t.data.goods_src,
                success: function(a) {},
                fail: function(a) {}
            };
        }
        var g = (t = this).data.config;
        return t.setData({
            config: g
        }), 0 == t.data.is_daili ? {
            title: t.data.config.indextitle,
            path: "hc_pdd/pages/index/index",
            imageUrl: t.data.config.indexpic,
            success: function(a) {},
            fail: function(a) {}
        } : {
            title: t.data.config.indextitle,
            path: "hc_pdd/pages/index/index?user_id=" + app.globalData.user_id,
            imageUrl: t.data.config.indexpic,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});