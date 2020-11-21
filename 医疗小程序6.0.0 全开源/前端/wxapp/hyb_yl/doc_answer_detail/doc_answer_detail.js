Page({
    data: {
        wenda: [ {
            id: 0,
            img: "../images/header_01.png",
            niming: "匿名用户",
            state: 0,
            con: "返几块大水井坊莱克斯顿解放路卡发链接为发胜利大街发狂了三解放路开始就流口水的解放路看电视",
            states: 1,
            imgArr: [ "../images/background.png", "../images/background.png", "../images/background.png", "../images/background.png", "../images/background.png", "../images/background.png", "../images/background.png", "../images/background.png" ]
        } ],
        doctor: [ {
            id: 1,
            image: "../images/header_02.png",
            zhuan: "小猪佩奇",
            zhi: "主治医师",
            con1: "就得上来咖啡吉林省脸上法律手段放假了设计费雷克萨发了扣三分",
            time: "4天前"
        }, {
            id: 1,
            image: "../images/header_02.png",
            zhuan: "小猪佩奇",
            zhi: "主治医师",
            con1: "就得上来咖啡吉林省脸上法律手段放假了设计费雷克萨发了扣三分",
            time: "4天前"
        } ],
        overflow: !1,
        paySH: !1,
        values: ""
    },
    onLoad: function(a) {
        if (a.con) {
            var n = a.con, e = {
                id: 1,
                image: "../images/header_02.png",
                zhuan: "小猪佩奇",
                zhi: "主治医师"
            };
            e.con1 = n, e.time = "刚刚";
            var i = this.data.doctor;
            i.push(e), this.setData({
                doctor: i
            });
        }
    },
    switchChange: function(a) {
        if (console.log("switch2 发生 change 事件，携带值为", a.detail.value), a.detail.value) n = this.data.values; else var n = "";
        this.setData({
            paySH: a.detail.value,
            values: n
        });
    },
    docAnswerClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/doc_answer/doc_answer"
        });
    },
    payClick: function(a) {
        console.log(a), this.setData({
            values: a.detail.value
        });
    },
    yulan: function(a) {
        var n = a.currentTarget.dataset.idx, e = this.data.wenda;
        console.log(n, e), wx.previewImage({
            current: e[0].imgArr[n],
            urls: e[0].imgArr
        });
    },
    confirm: function() {
        wx.showLoading({
            title: ""
        }), setTimeout(function() {
            wx.hideLoading(), wx.showToast({
                title: "保存成功"
            });
        }, 500);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});