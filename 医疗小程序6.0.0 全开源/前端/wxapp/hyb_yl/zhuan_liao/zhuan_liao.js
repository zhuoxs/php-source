var app = getApp();

Page({
    data: {
        id: 2,
        value: "",
        scrollTop: "10000000",
        chatArr: [ {
            id: 1,
            himg: "../images/header_01.png",
            con: "发神经弗兰克萨解放路开始看就付款刘三姐抗裂砂浆啊客服就流口水发了啥浪费"
        }, {
            id: 2,
            himg: "../images/header_02.png",
            con: "发神经弗兰克萨解放路开始看就付款刘三姐抗裂砂浆啊客服就流口水发了啥浪费"
        } ],
        hide: "",
        heights: "860",
        footerArr: [ {
            img: "../images/baogao_01.png",
            title: "体检报告",
            btn: "baoClick"
        }, {
            img: "../images/jiankangdangan_01.png",
            title: "健康档案",
            btn: "baoClick"
        }, {
            img: "../images/zhaopian_01.png",
            title: "发送照片",
            btn: "phoneClick"
        } ],
        footerArr1: [ {
            img: "../images/chufang_01.png",
            title: "病情诊断",
            btn: "zhenClick"
        }, {
            img: "../images/zhaopian_01.png",
            title: "发送照片",
            btn: "phoneClick"
        } ],
        overflow: "",
        tiao: "tiao",
        tiao1: "aa",
        focus: !1,
        obj: ""
    },
    inputClick: function(a) {
        var t = a.detail.value;
        this.setData({
            value: t
        });
    },
    hideClick: function() {
        var a = this, t = a.data.hide, e = a.data.heights;
        "" == t ? (t = !0, e = "680") : (t = "", e = "860"), a.setData({
            hide: t,
            heights: e
        });
    },
    faClick: function() {
        var a = this, t = a.data.value;
        console.log(t);
        var e = {};
        e.id = a.data.id, e.himg = "../images/header_0" + a.data.id + ".png", e.con = t;
        var i = a.data.chatArr;
        i.push(e);
        t = "";
        a.setData({
            chatArr: i,
            value: t,
            focus: !0
        }), a.bottom();
    },
    baoClick: function(a) {
        var t = this, e = a.currentTarget.dataset.img;
        console.log(e);
        var i = a.currentTarget.dataset.title;
        console.log(e, i), "../images/baogao_01.png" == e ? e = "../images/baogao_02.png" : (e = "../images/jiankangdangan_01.png") && (e = "../images/jiankangdangan_02.png");
        var o = {};
        o.id = t.data.id, o.himg = "../images/header_0" + t.data.id + ".png", o.wen = [ {
            title: i,
            con: "发了首付款紧身裤啦放假拉伸",
            time: "2018-03-15",
            img: e
        } ];
        var n = t.data.chatArr;
        n.push(o);
        t.setData({
            chatArr: n,
            value: ""
        }), t.bottom();
    },
    phoneClick: function() {
        var o = this;
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths;
                console.log(t);
                var e = {};
                e.id = o.data.id, e.himg = "../images/header_0" + o.data.id + ".png", e.tu = t;
                var i = o.data.chatArr;
                i.push(e), o.setData({
                    chatArr: i
                }), o.bottom();
            }
        });
    },
    load: function(a) {
        console.log(a);
        var t = a.detail.width;
        this.setData({
            widths: t
        });
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.arr, e = a.target.dataset.index;
        console.log(e);
        var i = t[e];
        console.log(t, i), wx.previewImage({
            current: "",
            urls: t
        });
    },
    zhenClick: function() {
        var a = this, t = a.data.obj;
        if (console.log(t), "" != t) {
            var e = t.jianshu, i = t.jieguo, o = t.chufang;
            a.setData({
                jianshu: e,
                jieguo: i,
                chufang: o
            });
        }
        this.setData({
            overflow: "hidden"
        }), a.bottom();
    },
    hide1Click: function() {
        this.setData({
            overflow: ""
        });
    },
    subClick: function(a) {
        console.log(a);
        var t = this, e = a.detail.value.jianshu, i = a.detail.value.jieguo, o = a.detail.value.chufang;
        if ("" == e) wx.showToast({
            title: "请填写病情简述",
            icon: "none"
        }); else if ("" == i) wx.showToast({
            title: "请填写诊断结果",
            icon: "none"
        }); else if ("" == o) wx.showToast({
            title: "请填写处方",
            icon: "none"
        }); else {
            var n = a.detail.value, s = t.data.chatArr, r = t.data.id, c = {};
            c.id = r, c.himg = "../images/header_0" + r + ".png", c.wen = [ {
                title: "诊断结果",
                con: i,
                time: "2018-03-15",
                img: "../images/baogao_02.png",
                btn: "zhenClick"
            } ], s.push(c), t.setData({
                obj: n,
                chatArr: s,
                overflow: ""
            });
        }
    },
    zhuanDetailClick: function() {
        wx.navigateTo({
            url: "/pages/zhuan-detail/zhuan-detail"
        });
    },
    onLoad: function(a) {
        var t = a.zid, e = a.qid, i = a.user_openid, o = a.q_category, n = this.data.tiao1, s = a.fromuser, r = a.z_name, c = a.z_zhiwu, l = a.z_thumbs;
        this.setData({
            tiao1: n,
            zid: t,
            user_openid: i,
            q_category: o,
            qid: e,
            fromuser: s,
            z_name: r,
            z_zhiwu: c,
            z_thumbs: l
        }), this.bottom();
    },
    bottom: function() {
        var t = this, a = wx.createSelectorQuery();
        a.select("#hei").boundingClientRect(), a.selectViewport().scrollOffset(), a.exec(function(a) {
            t.setData({
                scrollTop: a[0].height
            });
        });
    },
    onReady: function() {
        this.getAllquestion();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getAllquestion: function() {
        var t = this, a = t.data.zid, e = t.data.user_openid, i = t.data.qid, o = t.data.fromuser;
        app.util.request({
            url: "entry/wxapp/Allquestion",
            data: {
                qid: i,
                zid: a,
                user_openid: e,
                fromuser: o
            },
            success: function(a) {
                console.log(a), t.setData({
                    qs: a.data.data
                });
            }
        });
    },
    zixun: function(a) {
        var t = this.data.zid, e = this.data.user_openid, i = this.data.q_category;
        wx.navigateTo({
            url: "/hyb_yl/zhuanjiatiwen/zhuanjiatiwen?id=" + t + "&openid=" + e + "&q_category=" + i
        });
    }
});