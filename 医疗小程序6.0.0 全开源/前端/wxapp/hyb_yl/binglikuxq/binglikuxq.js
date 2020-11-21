var WxParse = require("../wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        nav: {
            nav_list: [ {
                names: "jack",
                sex: "男",
                age: 18
            } ]
        },
        danganArr: [ {
            dizhi: "山西大医院",
            time: "2018-05-06",
            names: "李世民副主任医师",
            ke: "儿科-血液科",
            miaoshu: "士大夫就爱看风景雷克萨大吉来看撒娇发电量三了福建省立刻吉拉对方",
            jieguo: "士大夫就爱看风景雷克萨大吉来看撒娇发电量三了福建省立刻吉拉对方",
            imgArr: [ "../images/active_01.jpg", "../images/active_02.jpg", "../images/active_03.jpg", "../images/active_01.jpg", "../images/active_02.jpg", "../images/active_03.jpg" ]
        } ],
        jiluArr: [ {
            time: "29",
            time1: "四月",
            imgArr: [ "../images/active_01.jpg", "../images/active_02.jpg", "../images/active_03.jpg", "../images/active_01.jpg", "../images/active_02.jpg", "../images/active_03.jpg" ]
        } ]
    },
    onLoad: function(a) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var n = this, i = a.id;
        app.util.request({
            url: "entry/wxapp/Blxiangq",
            data: {
                id: i
            },
            success: function(a) {
                console.log(a);
                var e = a.data.data.uptime.split(" "), i = (e[1].split("-"), e[0].split("-")), t = i[1], s = i[2];
                if ("01" == t) var o = "一"; else if ("02" == t) o = "二"; else if ("03" == t) o = "三"; else if ("04" == t) o = "四"; else if ("05" == t) o = "五"; else if ("06" == t) o = "六"; else if ("07" == t) o = "七"; else if ("08" == t) o = "八"; else if ("09" == t) o = "九"; else if ("10" == t) o = "十"; else if ("11" == t) o = "十一"; else if ("12" == t) o = "十二";
                console.log(t, s), n.setData({
                    blxiangq: a.data.data,
                    month1: o,
                    day: s
                }), WxParse.wxParse("articles", "html", a.data.data.jida, n, 5);
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                a.data.data.ztcolor;
                n.setData({
                    baseinfo: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
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