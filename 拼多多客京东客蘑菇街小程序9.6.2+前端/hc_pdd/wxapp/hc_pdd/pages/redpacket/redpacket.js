var app = getApp(), pageNum = 0;

Page({
    data: {
        hubo: !1,
        img: [ "../../resource/images/red_packet_popup_back.png", "../../resource/images/red_packet_popup_front.png" ]
    },
    onLoad: function(t) {
        var a = t.goodsistcsa, o = t.hubo, e = t.endtime;
        this.setData({
            endtime: e
        });
        var n = app.globalData.Headcolor, i = app.globalData.title;
        this.setData({
            goodsistcsa: a,
            hubo: o,
            backgroundColor: n,
            title: i
        }), this.Headcolor(), setTimeout(function() {
            this.countDown();
        }.bind(this), 800), this.rotateAndScale(), this.moveXBox(), this.moveXBoxtwo(), 
        this.moveXBoxtree();
    },
    submitInfo: function(t) {
        console.log("获取id");
        var a = t.detail.formId;
        console.log(a), console.log("获取formid结束"), this.setData({
            formid: a
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: this.data.formid
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Canyusccess",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(t) {
                        console.log(t);
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    Headcolor: function() {
        var g = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(t) {
                var a = t.data.data.config.search_color, o = t.data.data.config.share_icon;
                t.data.data.config.head_color;
                app.globalData.Headcolor = t.data.data.config.head_color;
                var e = t.data.data.config.title, n = t.data.data.yesno, i = t.data.data.config.shenhe, s = t.data.data.config.text, r = t.data.data.theme, u = t.data.data.config, d = u.enable, c = t.data.data.hongbao, p = t.data.data.hb, l = g.data.hb, h = p.endtime;
                l = 0 == c.status ? c.firstmoney : c.zhuanfamoney, g.setData({
                    search_color: a,
                    share_icon: o,
                    yesno: n,
                    shenhe: i,
                    text: s,
                    theme: r,
                    config: u,
                    enable: d,
                    hongbaoqiy: c,
                    hbmoney: l,
                    hb: p,
                    endtime: h
                }), wx.setNavigationBarTitle({
                    title: e
                }), g.Hongbaolist(), g.timetime();
            },
            fail: function(t) {
                console.log("失败" + t);
            }
        });
    },
    timetime: function() {
        var u = this.data.hb.e_time - Date.parse(new Date()) / 1e3, d = setInterval(function() {
            var t = u, a = Math.floor(t / 3600 / 24), o = a.toString();
            1 == o.length && (o = "0" + o);
            var e = Math.floor((t - 3600 * a * 24) / 3600), n = e.toString();
            1 == n.length && (n = "0" + n);
            var i = Math.floor((t - 3600 * a * 24 - 3600 * e) / 60), s = i.toString();
            1 == s.length && (s = "0" + s);
            var r = (t - 3600 * a * 24 - 3600 * e - 60 * i).toString();
            1 == r.length && (r = "0" + r), this.setData({
                countDownDay: o,
                countDownHour: n,
                countDownMinute: s,
                countDownSecond: r
            }), --u < 0 && (clearInterval(d), this.setData({
                countDownDay: "00",
                countDownHour: "00",
                countDownMinute: "00",
                countDownSecond: "00"
            }));
        }.bind(this), 1e3);
    },
    Hongbaolist: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Hongbaolist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                hbmoney: e.data.hbmoney
            },
            success: function(t) {
                var a = t.data.data.list, o = t.data.data;
                e.setData({
                    goodsist: a,
                    goodsistcsa: o
                });
            },
            fail: function(t) {
                console.log("失败" + t);
            }
        });
    },
    jaizai: function(t) {
        var e = this, n = e.data.goodsist;
        app.util.request({
            url: "entry/wxapp/Hongbaolist",
            method: "POST",
            data: {
                pageNum: t,
                user_id: app.globalData.user_id,
                hbmoney: e.data.hbmoney
            },
            success: function(t) {
                for (var a = t.data.data.list, o = 0; o < a.length; o++) n.push(a[o]);
                e.setData({
                    goodsist: n
                });
            }
        });
    },
    onReachBottom: function() {
        console.log(this.data.goods), pageNum++, this.jaizai(pageNum);
    },
    countDown: function() {
        var t = this, a = 10;
        t.setData({
            timer: setInterval(function() {
                a--, t.setData({
                    countDownNum: a
                }), 0 != a || (a = 10);
            }, 100)
        });
    },
    lijsh: function() {
        var t = this.data.hubo;
        this.setData({
            hubo: !t
        });
    },
    onHide: function() {},
    tiao: function(t) {
        var o = this, a = t.currentTarget.dataset.id;
        o.setData({
            goods_id: a,
            user_id: app.globalData.user_id
        }), app.util.request({
            url: "entry/wxapp/Shareurl",
            method: "POST",
            data: {
                goods_id: a,
                user_id: app.globalData.user_id
            },
            success: function(t) {
                app.globalData.we_app_info = t.data.data.we_app_info;
                var a = t.data.data.we_app_info;
                o.setData({
                    we_app_info: a
                }), o.mai();
            },
            fail: function(t) {}
        });
    },
    mai: function() {
        this.data.enable;
        wx.navigateToMiniProgram({
            appId: this.data.we_app_info.app_id,
            path: this.data.we_app_info.page_path,
            extraData: {
                user_id: this.data.user_id
            },
            envVersion: "release",
            success: function(t) {
                console.log("成功");
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onUnload: function() {},
    rotateAndScale: function() {
        var t = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (this.animation = t).opacity(1).scale(2, 2).step(), this.setData({
            animationData: t.export()
        }), setTimeout(function() {
            this.setData({
                animationData: t.export()
            });
        }.bind(this), 1e3);
    },
    moveXBox: function() {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear"
        });
        (this.animation = t).top(18).step(), t.top(22).step(), setTimeout(function() {
            t.top(18).step(), this.setData({
                lAnimate: t.export()
            });
        }.bind(this), 200);
    },
    preventTouchMove: function() {},
    moveXBoxtwo: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear"
        });
        (this.animation = a).top(50).step(), a.top(55).step(), setTimeout(function() {
            wx.getSystemInfo({
                success: function(t) {
                    0 <= t.system.indexOf("iOS") ? a.top(67).step() : a.top(58).step();
                }
            }), this.setData({
                rAnimate: a.export()
            });
        }.bind(this), 500);
    },
    moveXBoxtree: function() {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear"
        });
        (this.animation = t).opacity(1).scale(1.5).step(), setTimeout(function() {
            this.setData({
                opAnimate: t.export()
            });
        }.bind(this), 500);
    },
    onPullDownRefresh: function() {},
    zhuan: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Hbzhuanfa",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                zhuanfa: 1
            },
            success: function(t) {
                a.Headcolor();
            }
        });
    },
    onShareAppMessage: function(t) {
        return this.zhuan(), "button" === t.from && console.log(t.target), {
            title: this.data.hongbaoqiy.fenxiangtitle,
            path: "hc_pdd/pages/index/index",
            imageUrl: this.data.hongbaoqiy.fenxiangpic
        };
    }
});