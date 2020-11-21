function _defineProperty(t, a, n) {
    return a in t ? Object.defineProperty(t, a, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = n, t;
}

var tool = require("../../../../we7/js/countDown.js");

Page({
    data: {
        imgUrls: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152583244623.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152583244623.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152583244623.jpg" ],
        countDownDay: 0,
        countDownHour: 0,
        countDownMinute: 0,
        countDownSecond: 0,
        bargainList: [ {
            endTime: "1827519898765",
            clock: ""
        } ],
        cardimgUrls: [ {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/15258326896.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152583268957.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152583268954.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/15258326895.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152583268947.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/15259327809.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278087.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278084.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278081.png"
        }, {
            state: !1,
            num: 0,
            imgsrc2: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278074.png"
        } ],
        luckdrawnum: 0,
        showplay: !1,
        shopbutton: !1
    },
    onLoad: function(t) {
        this.countdownTime();
    },
    onShareAppMessage: function(t) {
        return "button" === t.from && console.log(t.target), {
            title: "自定义转发标题",
            path: "/page/user?id=123",
            success: function(t) {},
            fail: function(t) {}
        };
    },
    changebutton: function() {
        var t, a = this.data.cardimgUrls, n = (this.data.cardimgUrlsindex, this.data.showplay, 
        Math.floor(10 * Math.random())), i = "cardimgUrls[" + n + "].state", m = a[n].num;
        m += 1;
        var o = "cardimgUrls[" + n + "].num";
        this.setData((_defineProperty(t = {
            cardimgUrlsindex: n,
            shopbutton: !0,
            showplay: !0,
            luckdrawnum: 9
        }, i, !0), _defineProperty(t, o, m), t));
    },
    countdownTime: function() {
        var n = this, i = n.data.bargainList;
        setInterval(function() {
            for (var t = 0; t < i.length; t++) {
                var a = tool.countDown(n, i[t].endTime);
                i[t].clock = a ? "距离结束还剩：" + a[0] + "天" + a[1] + "时" + a[3] + "分" + a[4] + "秒" : "已经截止", 
                n.setData({
                    bargainList: i,
                    countDownDay: a[0] || "0",
                    countDownHour: a[1] || "0",
                    countDownMinute: a[3] || "0",
                    countDownSecond: a[4] || "0"
                });
            }
        }, 1e3);
    },
    luckdraw: function() {
        this.data.showplay;
        var t = this.data.luckdrawnum, a = this.data.cardimgUrls, n = Math.floor(10 * Math.random()), i = "cardimgUrls[" + n + "].state", m = a[n].num;
        m += 1;
        var o, g = "cardimgUrls[" + n + "].num";
        0 < t ? (t--, this.setData((_defineProperty(o = {
            showplay: !0,
            luckdrawnum: t,
            cardimgUrlsindex: n
        }, i, !0), _defineProperty(o, g, m), o))) : wx.showToast({
            title: "抽奖次数已用完",
            icon: "none",
            duration: 2e3
        });
    },
    closeplay: function() {
        var t = this.data.showplay;
        t = !t, this.setData({
            showplay: t
        });
    }
});