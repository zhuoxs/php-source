var app = getApp();

Page({
    data: {
        navTab: [ {
            con: "偏高"
        }, {
            con: "偏低"
        } ],
        current: 0,
        abnormal: {
            askArr: [ {
                title: "遗传因素",
                con: "更舒适的范围和权威股份海报上色，是否会鼓起万分委屈俺姑，阿双方互为更好企鹅窝水电费华为。国际危机各部位发文件。",
                imgArr: [ "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png", "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png" ]
            } ],
            riskArr: [ {
                title: "遗传因素",
                con: "更舒适的范围和权威股份海报上色，是否会鼓起万分委屈俺姑，阿双方互为更好企鹅窝水电费华为。国际危机各部位发文件。",
                imgArr: [ "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png", "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png" ]
            } ],
            doctorArr: [ {
                title: "遗传因素",
                con: "更舒适的范围和权威股份海报上色，是否会鼓起万分委屈俺姑，阿双方互为更好企鹅窝水电费华为。国际危机各部位发文件。",
                imgArr: [ "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png", "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png" ]
            } ],
            drugs: [ {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png",
                title: "药品名字"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png",
                title: "药品名字"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png",
                title: "药品名字"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/active_01.png",
                title: "药品名字"
            } ]
        },
        pageWrapCount: []
    },
    onLoad: function(t) {
        var a = this, o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        }), app.globalData.abnormal = a.data.abnormal, a.setData({
            pageWrapCount: a.data.pageWrapCount.concat([ 0 ])
        });
    },
    navTab: function(t) {
        var a = this;
        console.log(t), a.removal(a.data.pageWrapCount, t.currentTarget.dataset.index) ? a.setData({
            current: t.currentTarget.dataset.index
        }) : a.setData({
            pageWrapCount: a.data.pageWrapCount.concat([ t.currentTarget.dataset.index ]),
            current: t.currentTarget.dataset.index
        });
    },
    removal: function(t, a) {
        for (var o = 0, n = t.length; o < n; o++) if (t[o] == a) return !0;
        return !1;
    },
    drugsDetailClick: function(t) {
        console.log(t.detail.index), wx.navigateTo({
            url: "/hyb_yl/drugs_detail/drugs_detail"
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