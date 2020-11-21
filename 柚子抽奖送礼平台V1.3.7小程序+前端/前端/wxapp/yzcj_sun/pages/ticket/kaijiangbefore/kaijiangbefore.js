var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        msg: [ {
            name: "一个手机",
            num: 1,
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152316799312.png"
        } ],
        headerImg: [ "http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg" ],
        danmuTxt: []
    },
    onLoad: function(n) {
        var t = this, o = 1 * Math.random() >>> 0;
        t.setData({
            awardIndex: o
        }), wx.getUserInfo({
            success: function(n) {
                t.setData({
                    userInfo: n.userInfo
                });
            }
        });
    },
    bindSendDanmu: function() {
        this.videoContext.sendDanmu({
            text: this.inputValue,
            color: getRandomColor()
        });
    },
    goKaijiang: function() {
        wx.redirectTo({
            url: "../kaijiang/kaijiang"
        });
    },
    bindKeyInput: function(n) {
        var t = this;
        t.setData({
            danmuTxt: n.detail.value,
            kong: ""
        }), setTimeout(function() {
            t.setData({
                danmuTxt: "",
                kong: ""
            });
        }, 3e3), console.log(t.data.danmuTxt);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});