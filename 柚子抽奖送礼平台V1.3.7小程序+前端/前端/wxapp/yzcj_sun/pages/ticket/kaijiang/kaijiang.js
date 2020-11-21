Page({
    data: {
        oneself: !0,
        prizenum: 1,
        prizeimgSrc: [ "http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg" ],
        colorCircleFirst: "#fc9b7b",
        colorCircleSecond: "#f8f8f7",
        msg: [ {
            name: "一个手机",
            num: 1,
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152316799312.png"
        } ],
        imgUrls: [ "http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg", "http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg" ]
    },
    onLoad: function(t) {
        var o = this;
        wx.getUserInfo({
            success: function(t) {
                o.setData({
                    userInfo: t.userInfo
                });
            }
        });
        for (var n = 7.5, e = 7.5, i = [], a = 0; a < 66; a++) {
            if (0 == a) e = 8, n = 10; else if (a < 23) e = 8, n += 30; else if (a < 34) e += 30, 
            n = n; else if (a < 56) e = e, n -= 30; else {
                if (!(a < 66)) return;
                e -= 30, n = n;
            }
            i.push({
                topCircle: e,
                leftCircle: n
            });
        }
        setInterval(function() {
            "#f8f8f7" == o.data.colorCircleFirst ? o.setData({
                colorCircleFirst: "#fc9b7b",
                colorCircleSecond: "#f8f8f7"
            }) : o.setData({
                colorCircleFirst: "#f8f8f7",
                colorCircleSecond: "#fc9b7b"
            });
        }, 500), this.setData({
            circleList: i
        }), console.log(i), setTimeout(function() {
            var t = wx.createAnimation({
                duration: 4e3,
                timingFunction: "ease"
            });
            (o.animationRun = t).translateY(-5085).step(), o.setData({
                animationData: t.export()
            });
        }, 1100), setTimeout(function() {
            var t = wx.createAnimation({
                duration: 4e3,
                timingFunction: "ease"
            });
            (o.animationRun = t).translateY(-5085).step(), o.setData({
                animationData1: t.export()
            });
        }, 1600), setTimeout(function() {
            var t = wx.createAnimation({
                duration: 4e3,
                timingFunction: "ease"
            });
            (o.animationRun = t).translateY(-5085).step(), o.setData({
                animationData2: t.export()
            });
        }, 2100), setTimeout(function() {
            var t = wx.createAnimation({
                duration: 200,
                timingFunction: "ease"
            });
            (o.animationRun = t).translateY(178).step(), o.setData({
                animationData3: t.export(),
                height: "auto",
                display: "block"
            });
        }, 4e3);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});