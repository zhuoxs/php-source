var app = getApp(), pageNum = 0;

Page({
    data: {
        thiseven: 0,
        gun: !0,
        text: [ "综合", "佣金比例", "销量", "价格" ],
        zoor: 0,
        searchinput: "",
        rankno: 0,
        loding: !0,
        staffList: [ {
            lastName: "张",
            firstName: "三",
            id: 0
        }, {
            lastName: "李",
            firstName: "四",
            id: 1
        } ],
        title: "tom",
        jingxu: [ "拼多多", "蘑菇街" ],
        parameter: 0,
        pageNum: 0
    },
    bindchange: function(a) {
        this.setData({
            tuhight: a.detail.current
        });
    },
    onLoad: function(a) {
        var t = a.cateid, e = a.jdcateid, i = this, s = app.globalData.Headcolor;
        app.globalData.title;
        console.log(t), console.log(e), i.setData({
            qieone: 0,
            qietwo: 0,
            qiethree: 0,
            cateid: t,
            jdcateid: e,
            backgroundColor: s
        }), i.Headcolor(), i.joggle();
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 0
        }), this.joggle();
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
    fanhui: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    bindHideKeyboard: function(a) {
        var t = a.detail.value;
        this.setData({
            inputValue: t
        });
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
                user_id: app.globalData.user_id,
                cateid: i.data.cateid,
                jdcateid: i.data.jdcateid
            },
            success: function(a) {
                console.log(a);
                var t = a.data.data.list;
                if (0 == i.data.parameter) {
                    var e = a.data.data.toplist;
                    i.setData({
                        goodsist: t,
                        toplist: e
                    });
                } else i.setData({
                    goodsist: t
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
        var s = this, t = a.currentTarget.dataset.cateid, e = a.currentTarget.dataset.jdcateid;
        console.log(t, e), s.setData({
            cateid: t,
            jdcateid: e
        }), app.util.request({
            url: "entry/wxapp/Goodslist",
            method: "POST",
            data: {
                cateid: t,
                jdcateid: e,
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
                rankno: i.data.rankno,
                cateid: i.data.cateid,
                jdcateid: i.data.jdcateid
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
        console.log(this.data.goods);
        var a = this.data.pageNum;
        a++, this.jaizai(a), this.setData({
            loding: !1,
            pageNum: a
        });
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id, e = (a.currentTarget.dataset.jump, a.currentTarget.dataset.hui), i = a.currentTarget.dataset.itemurl, s = a.currentTarget.dataset.skuid, d = this.data.parameter, o = a.currentTarget.dataset.materialurl, n = a.currentTarget.dataset.couponurl;
        "" != t && (0 == d ? wx.navigateTo({
            url: "../details/details?goods_id=" + t + "&hui=" + e + "&parameter=" + d
        }) : 1 == d ? wx.navigateTo({
            url: "../details/details?itemUrl=" + i + "&parameter=" + d
        }) : 2 == d && (app.globalData.couponUrl = n, wx.navigateTo({
            url: "../details/details?skuId=" + s + "&parameter=" + d + "&materialUrl=" + o
        })));
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
        });
    },
    qirw: function(a) {
        this.setData({
            zoor: a.currentTarget.dataset.index
        });
    },
    Headcolor: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config.search_color, e = a.data.data.config.share_icon, i = a.data.data.config.shenhe, s = a.data.data.is_daili, d = a.data.data.config, o = a.data.data.config.kaiguan;
                n.setData({
                    search_color: t,
                    share_icon: e,
                    shenhe: i,
                    config: d,
                    is_daili: s,
                    kaiguan: o
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
                user_id: app.globalData.user_id,
                cateid: s.data.cateid,
                jdcateid: s.data.jdcateid
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
    onShareAppMessage: function(a) {
        if ("button" === a.from) {
            var t = this, e = a.target.dataset.src, i = a.target.dataset.id, s = a.target.dataset.name, d = a.target.dataset.goods_title, o = a.target.dataset.itemurl, n = a.target.dataset.skuid, r = t.data.parameter, l = a.target.dataset.materialurl, u = a.target.dataset.couponurl;
            if (t.setData({
                goods_src: e,
                goods_id: i,
                goods_name: s,
                goods_title: d
            }), 0 == r) var c = "hc_pdd/pages/details/details?goods_id=" + i + "&parameter=" + r + "&user_id=" + app.globalData.user_id + "&sharein=sharein"; else if (1 == r) c = "hc_pdd/pages/details/details?itemUrl=" + o + "&parameter=" + r + "&user_id=" + app.globalData.user_id + "&sharein=sharein"; else if (2 == r) c = "hc_pdd/pages/details/details?skuId=" + n + "&parameter=" + r + "&materialUrl=" + l + "&couponUrl=" + u + "&user_id=" + app.globalData.user_id + "&sharein=sharein";
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